<?php

namespace App\Services;

use App\Contracts\NotificationServiceInterface;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class NotificationService implements NotificationServiceInterface
{
    private array $channels;
    private array $templates;

    public function __construct()
    {
        $this->channels = config('notifications.channels', ['email', 'sms']);
        $this->templates = config('notifications.templates', []);
    }

    public function sendOrderConfirmation(User $user, array $orderData): bool
    {
        try {
            $this->logNotification('order_confirmation', $user->id, $orderData);

            // Email notification
            if ($this->shouldSendEmail($user)) {
                $this->sendEmailNotification($user, 'order_confirmation', [
                    'order_id' => $orderData['order_id'],
                    'total' => $orderData['total'],
                    'items' => $orderData['items'],
                    'customer_name' => $user->name
                ]);
            }

            // SMS notification (if phone number available)
            if ($this->shouldSendSMS($user)) {
                $this->sendSMSNotification($user, 
                    "Order {$orderData['order_id']} confirmed! Total: Rs. {$orderData['total']}. Thank you for choosing Café Elixir!"
                );
            }

            return true;

        } catch (\Exception $e) {
            Log::error('Failed to send order confirmation notification', [
                'user_id' => $user->id,
                'order_data' => $orderData,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    public function sendReservationConfirmation(User $user, array $reservationData): bool
    {
        try {
            $this->logNotification('reservation_confirmation', $user->id, $reservationData);

            if ($this->shouldSendEmail($user)) {
                $this->sendEmailNotification($user, 'reservation_confirmation', [
                    'reservation_id' => $reservationData['reservation_id'],
                    'date' => $reservationData['reservation_date'],
                    'time' => $reservationData['reservation_time'],
                    'guests' => $reservationData['guests'],
                    'customer_name' => $user->name
                ]);
            }

            if ($this->shouldSendSMS($user)) {
                $this->sendSMSNotification($user,
                    "Reservation {$reservationData['reservation_id']} confirmed for {$reservationData['reservation_date']} at {$reservationData['reservation_time']}. See you soon!"
                );
            }

            return true;

        } catch (\Exception $e) {
            Log::error('Failed to send reservation confirmation notification', [
                'user_id' => $user->id,
                'reservation_data' => $reservationData,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    public function sendLoyaltyPointsNotification(User $user, int $points): bool
    {
        try {
            $this->logNotification('loyalty_points', $user->id, ['points' => $points]);

            if ($this->shouldSendEmail($user)) {
                $this->sendEmailNotification($user, 'loyalty_points', [
                    'points' => $points,
                    'total_points' => $user->total_loyalty_points,
                    'tier' => $user->loyalty_tier,
                    'customer_name' => $user->name
                ]);
            }

            return true;

        } catch (\Exception $e) {
            Log::error('Failed to send loyalty points notification', [
                'user_id' => $user->id,
                'points' => $points,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    public function sendPromotionalNotification(User $user, array $promotionData): bool
    {
        try {
            $this->logNotification('promotional', $user->id, $promotionData);

            if ($this->shouldSendEmail($user)) {
                $this->sendEmailNotification($user, 'promotional', array_merge($promotionData, [
                    'customer_name' => $user->name
                ]));
            }

            return true;

        } catch (\Exception $e) {
            Log::error('Failed to send promotional notification', [
                'user_id' => $user->id,
                'promotion_data' => $promotionData,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    private function shouldSendEmail(User $user): bool
    {
        return in_array('email', $this->channels) && 
               $user->email && 
               ($user->email_notifications ?? true);
    }

    private function shouldSendSMS(User $user): bool
    {
        return in_array('sms', $this->channels) && 
               $user->phone && 
               ($user->sms_notifications ?? false);
    }

    private function sendEmailNotification(User $user, string $template, array $data): void
    {
        // In a real implementation, this would use Laravel's Mail facade
        // with proper email templates
        Log::info('Email notification sent', [
            'user_id' => $user->id,
            'template' => $template,
            'email' => $user->email
        ]);
    }

    private function sendSMSNotification(User $user, string $message): void
    {
        // In a real implementation, this would integrate with SMS service
        Log::info('SMS notification sent', [
            'user_id' => $user->id,
            'phone' => $user->phone,
            'message' => $message
        ]);
    }

    private function logNotification(string $type, int $userId, array $data): void
    {
        Log::info("Notification sent - {$type}", [
            'type' => $type,
            'user_id' => $userId,
            'data' => $data,
            'timestamp' => now()->toISOString()
        ]);
    }
}