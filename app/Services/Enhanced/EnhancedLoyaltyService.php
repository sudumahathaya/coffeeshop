<?php

namespace App\Services\Enhanced;

use App\Contracts\LoyaltyServiceInterface;
use App\Contracts\NotificationServiceInterface;
use App\Models\User;
use App\Models\Order;
use App\Models\LoyaltyPoint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EnhancedLoyaltyService implements LoyaltyServiceInterface
{
    private NotificationServiceInterface $notificationService;
    private array $tierConfig;
    private array $pointsConfig;

    public function __construct(NotificationServiceInterface $notificationService)
    {
        $this->notificationService = $notificationService;
        $this->initializeConfig();
    }

    private function initializeConfig(): void
    {
        $this->tierConfig = [
            'bronze' => ['min_points' => 0, 'max_points' => 499, 'discount' => 5],
            'gold' => ['min_points' => 500, 'max_points' => 1499, 'discount' => 15],
            'platinum' => ['min_points' => 1500, 'max_points' => PHP_INT_MAX, 'discount' => 25]
        ];

        $this->pointsConfig = [
            'order_multiplier' => 0.1, // 1 point per Rs. 10
            'minimum_order_points' => 50,
            'reservation_bonus' => 50,
            'review_bonus' => 100,
            'referral_bonus' => 200
        ];
    }

    public function awardPointsForOrder(Order $order): int
    {
        if (!$order->user_id) {
            return 0;
        }

        try {
            DB::beginTransaction();

            // Calculate points: 1 point per Rs. 10 spent, minimum 50 points
            $pointsEarned = max(
                $this->pointsConfig['minimum_order_points'],
                floor($order->total * $this->pointsConfig['order_multiplier'])
            );

            // Check for tier bonus
            $user = $order->user;
            $tierBonus = $this->calculateTierBonus($user, $pointsEarned);
            $totalPoints = $pointsEarned + $tierBonus;

            // Create loyalty point record
            $loyaltyPoint = LoyaltyPoint::create([
                'user_id' => $order->user_id,
                'points' => $totalPoints,
                'type' => 'earned',
                'description' => "Points earned from order #{$order->order_id}" . 
                               ($tierBonus > 0 ? " (includes {$tierBonus} tier bonus)" : ""),
                'order_id' => $order->id
            ]);

            // Check for tier upgrade
            $oldTier = $this->getUserTier($user);
            $user->refresh(); // Refresh to get updated points
            $newTier = $this->getUserTier($user);

            if ($oldTier !== $newTier) {
                $this->handleTierUpgrade($user, $oldTier, $newTier);
            }

            // Send notification
            $this->notificationService->sendLoyaltyPointsNotification($user, $totalPoints);

            DB::commit();

            Log::info('Loyalty points awarded successfully', [
                'user_id' => $order->user_id,
                'order_id' => $order->order_id,
                'points_earned' => $totalPoints,
                'tier_bonus' => $tierBonus,
                'old_tier' => $oldTier,
                'new_tier' => $newTier
            ]);

            return $totalPoints;

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to award loyalty points', [
                'order_id' => $order->id,
                'error' => $e->getMessage()
            ]);
            return 0;
        }
    }

    public function awardReservationBonus(User $user): int
    {
        try {
            $bonusPoints = $this->pointsConfig['reservation_bonus'];

            LoyaltyPoint::create([
                'user_id' => $user->id,
                'points' => $bonusPoints,
                'type' => 'earned',
                'description' => 'Bonus points for confirmed reservation'
            ]);

            $this->notificationService->sendLoyaltyPointsNotification($user, $bonusPoints);

            return $bonusPoints;

        } catch (\Exception $e) {
            Log::error('Failed to award reservation bonus', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
            return 0;
        }
    }

    public function redeemPoints(User $user, int $points, string $description): bool
    {
        if ($user->total_loyalty_points < $points) {
            return false;
        }

        try {
            DB::beginTransaction();

            LoyaltyPoint::create([
                'user_id' => $user->id,
                'points' => $points,
                'type' => 'redeemed',
                'description' => $description
            ]);

            DB::commit();

            Log::info('Loyalty points redeemed', [
                'user_id' => $user->id,
                'points_redeemed' => $points,
                'description' => $description
            ]);

            return true;

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to redeem loyalty points', [
                'user_id' => $user->id,
                'points' => $points,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    public function getUserTier(User $user): string
    {
        $points = $user->total_loyalty_points;
        
        foreach ($this->tierConfig as $tier => $config) {
            if ($points >= $config['min_points'] && $points <= $config['max_points']) {
                return $tier;
            }
        }
        
        return 'bronze'; // Default tier
    }

    public function getTierDiscount(User $user): int
    {
        $tier = $this->getUserTier($user);
        return $this->tierConfig[$tier]['discount'] ?? 0;
    }

    public function getPointsToNextTier(User $user): int
    {
        $currentPoints = $user->total_loyalty_points;
        $currentTier = $this->getUserTier($user);
        
        // Find next tier
        $tierNames = array_keys($this->tierConfig);
        $currentTierIndex = array_search($currentTier, $tierNames);
        
        if ($currentTierIndex === false || $currentTierIndex >= count($tierNames) - 1) {
            return 0; // Already at highest tier
        }
        
        $nextTier = $tierNames[$currentTierIndex + 1];
        $nextTierMinPoints = $this->tierConfig[$nextTier]['min_points'];
        
        return max(0, $nextTierMinPoints - $currentPoints);
    }

    private function calculateTierBonus(User $user, int $basePoints): int
    {
        $tier = $this->getUserTier($user);
        
        $bonusMultipliers = [
            'bronze' => 0,
            'gold' => 0.1, // 10% bonus
            'platinum' => 0.2 // 20% bonus
        ];
        
        $multiplier = $bonusMultipliers[$tier] ?? 0;
        return floor($basePoints * $multiplier);
    }

    private function handleTierUpgrade(User $user, string $oldTier, string $newTier): void
    {
        Log::info('User tier upgraded', [
            'user_id' => $user->id,
            'old_tier' => $oldTier,
            'new_tier' => $newTier
        ]);

        // Award tier upgrade bonus
        $upgradeBonus = $this->getTierUpgradeBonus($newTier);
        if ($upgradeBonus > 0) {
            LoyaltyPoint::create([
                'user_id' => $user->id,
                'points' => $upgradeBonus,
                'type' => 'earned',
                'description' => "Tier upgrade bonus - Welcome to {$newTier} tier!"
            ]);
        }

        // Send tier upgrade notification
        $this->notificationService->sendPromotionalNotification($user, [
            'type' => 'tier_upgrade',
            'old_tier' => $oldTier,
            'new_tier' => $newTier,
            'bonus_points' => $upgradeBonus
        ]);
    }

    private function getTierUpgradeBonus(string $tier): int
    {
        $bonuses = [
            'gold' => 100,
            'platinum' => 250
        ];

        return $bonuses[$tier] ?? 0;
    }

    private function logNotification(string $type, int $userId, array $data): void
    {
        Log::info("Loyalty notification - {$type}", [
            'type' => $type,
            'user_id' => $userId,
            'data' => $data,
            'timestamp' => now()->toISOString()
        ]);
    }
}