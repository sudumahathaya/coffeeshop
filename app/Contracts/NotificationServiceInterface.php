<?php

namespace App\Contracts;

use App\Models\User;

interface NotificationServiceInterface
{
    /**
     * Send order confirmation notification
     */
    public function sendOrderConfirmation(User $user, array $orderData): bool;

    /**
     * Send reservation confirmation notification
     */
    public function sendReservationConfirmation(User $user, array $reservationData): bool;

    /**
     * Send loyalty points notification
     */
    public function sendLoyaltyPointsNotification(User $user, int $points): bool;

    /**
     * Send promotional notification
     */
    public function sendPromotionalNotification(User $user, array $promotionData): bool;
}