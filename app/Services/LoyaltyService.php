<?php

namespace App\Services;

use App\Models\User;
use App\Models\LoyaltyPoint;
use App\Models\Order;

class LoyaltyService
{
    /**
     * Award points for an order
     */
    public function awardPointsForOrder(Order $order): int
    {
        if (!$order->user_id) {
            return 0;
        }

        // Calculate points: 1 point per Rs. 10 spent, minimum 50 points
        $pointsEarned = max(50, floor($order->total / 10));

        LoyaltyPoint::create([
            'user_id' => $order->user_id,
            'points' => $pointsEarned,
            'type' => 'earned',
            'description' => "Points earned from order #{$order->order_id}",
            'order_id' => $order->id
        ]);

        return $pointsEarned;
    }

    /**
     * Award bonus points for reservation
     */
    public function awardReservationBonus(User $user): int
    {
        $bonusPoints = 50;

        LoyaltyPoint::create([
            'user_id' => $user->id,
            'points' => $bonusPoints,
            'type' => 'earned',
            'description' => 'Bonus points for making a reservation'
        ]);

        return $bonusPoints;
    }

    /**
     * Redeem points for reward
     */
    public function redeemPoints(User $user, int $points, string $description): bool
    {
        if ($user->total_loyalty_points < $points) {
            return false;
        }

        LoyaltyPoint::create([
            'user_id' => $user->id,
            'points' => $points,
            'type' => 'redeemed',
            'description' => $description
        ]);

        return true;
    }

    /**
     * Get user's loyalty tier
     */
    public function getUserTier(User $user): string
    {
        $points = $user->total_loyalty_points;
        
        if ($points >= 1500) return 'Platinum';
        if ($points >= 500) return 'Gold';
        return 'Bronze';
    }

    /**
     * Get discount percentage for user's tier
     */
    public function getTierDiscount(User $user): int
    {
        $tier = $this->getUserTier($user);
        
        return match($tier) {
            'Platinum' => 25,
            'Gold' => 15,
            'Bronze' => 5,
            default => 0
        };
    }

    /**
     * Get points needed for next tier
     */
    public function getPointsToNextTier(User $user): int
    {
        $currentPoints = $user->total_loyalty_points;
        
        if ($currentPoints < 500) {
            return 500 - $currentPoints; // To Gold
        } elseif ($currentPoints < 1500) {
            return 1500 - $currentPoints; // To Platinum
        }
        
        return 0; // Already at highest tier
    }
}