<?php

namespace App\Contracts;

use App\Models\User;
use App\Models\Order;

interface LoyaltyServiceInterface
{
    /**
     * Award points for an order
     */
    public function awardPointsForOrder(Order $order): int;

    /**
     * Award bonus points for reservation
     */
    public function awardReservationBonus(User $user): int;

    /**
     * Redeem points for reward
     */
    public function redeemPoints(User $user, int $points, string $description): bool;

    /**
     * Get user's loyalty tier
     */
    public function getUserTier(User $user): string;

    /**
     * Get discount percentage for user's tier
     */
    public function getTierDiscount(User $user): int;

    /**
     * Get points needed for next tier
     */
    public function getPointsToNextTier(User $user): int;
}