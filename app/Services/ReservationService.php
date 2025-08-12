<?php

namespace App\Services;

use App\DTOs\ReservationDTO;
use App\Models\Reservation;
use App\Models\User;
use App\Services\Enhanced\EnhancedLoyaltyService;
use App\Contracts\NotificationServiceInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReservationService
{
    private EnhancedLoyaltyService $loyaltyService;
    private NotificationServiceInterface $notificationService;

    public function __construct(
        EnhancedLoyaltyService $loyaltyService,
        NotificationServiceInterface $notificationService
    ) {
        $this->loyaltyService = $loyaltyService;
        $this->notificationService = $notificationService;
    }

    /**
     * Create a new reservation
     */
    public function createReservation(ReservationDTO $reservationDTO): array
    {
        try {
            DB::beginTransaction();

            // Validate reservation data
            $this->validateReservation($reservationDTO);

            // Check availability
            if (!$this->checkAvailability($reservationDTO)) {
                throw new \Exception('Selected time slot is not available');
            }

            // Generate reservation ID
            $reservationId = $this->generateReservationId();

            // Create reservation
            $reservation = Reservation::create(array_merge($reservationDTO->toArray(), [
                'reservation_id' => $reservationId,
                'status' => 'pending' // Requires admin approval
            ]));

            // Send confirmation notification
            if ($reservationDTO->userId) {
                $user = User::find($reservationDTO->userId);
                if ($user) {
                    $this->notificationService->sendReservationConfirmation($user, [
                        'reservation_id' => $reservationId,
                        'reservation_date' => $reservationDTO->reservationDate,
                        'reservation_time' => $reservationDTO->reservationTime,
                        'guests' => $reservationDTO->guests
                    ]);
                }
            }

            DB::commit();

            Log::info('Reservation created successfully', [
                'reservation_id' => $reservationId,
                'user_id' => $reservationDTO->userId,
                'date' => $reservationDTO->reservationDate,
                'time' => $reservationDTO->reservationTime,
                'guests' => $reservationDTO->guests
            ]);

            return [
                'success' => true,
                'reservation_id' => $reservationId,
                'reservation' => $reservation
            ];

        } catch (\Exception $e) {
            DB::rollback();
            
            Log::error('Reservation creation failed', [
                'error' => $e->getMessage(),
                'data' => $reservationDTO->toArray()
            ]);

            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Approve a reservation
     */
    public function approveReservation(int $reservationId, ?string $adminNotes = null): array
    {
        try {
            DB::beginTransaction();

            $reservation = Reservation::findOrFail($reservationId);
            
            if ($reservation->status === 'confirmed') {
                throw new \Exception('This reservation is already confirmed');
            }
            
            $reservation->update([
                'status' => 'confirmed',
                'admin_notes' => $adminNotes,
                'approved_by' => auth()->id(),
                'approved_at' => now()
            ]);
            
            // Award loyalty points to user
            if ($reservation->user_id) {
                $user = User::find($reservation->user_id);
                if ($user) {
                    $this->loyaltyService->awardReservationBonus($user);
                }
            }
            
            // Broadcast real-time update
            broadcast(new \App\Events\ReservationUpdated($reservation))->toOthers();

            DB::commit();

            Log::info('Reservation approved successfully', [
                'reservation_id' => $reservation->reservation_id,
                'approved_by' => auth()->id()
            ]);
            
            return [
                'success' => true,
                'message' => 'Reservation approved successfully! Customer has been notified and earned 50 loyalty points.',
                'reservation' => $reservation
            ];

        } catch (\Exception $e) {
            DB::rollback();
            
            Log::error('Failed to approve reservation', [
                'reservation_id' => $reservationId,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Reject a reservation
     */
    public function rejectReservation(int $reservationId, string $rejectionReason, ?string $adminNotes = null): array
    {
        try {
            $reservation = Reservation::findOrFail($reservationId);
            
            if ($reservation->status === 'rejected') {
                throw new \Exception('This reservation is already rejected');
            }
            
            $reservation->update([
                'status' => 'rejected',
                'rejection_reason' => $rejectionReason,
                'admin_notes' => $adminNotes,
                'approved_by' => auth()->id(),
                'approved_at' => now()
            ]);
            
            // Broadcast real-time update
            broadcast(new \App\Events\ReservationUpdated($reservation))->toOthers();

            Log::info('Reservation rejected', [
                'reservation_id' => $reservation->reservation_id,
                'reason' => $rejectionReason,
                'rejected_by' => auth()->id()
            ]);
            
            return [
                'success' => true,
                'message' => 'Reservation rejected successfully. Customer has been notified.',
                'reservation' => $reservation
            ];

        } catch (\Exception $e) {
            Log::error('Failed to reject reservation', [
                'reservation_id' => $reservationId,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Validate reservation data
     */
    private function validateReservation(ReservationDTO $reservationDTO): void
    {
        if (!$reservationDTO->isValidDateTime()) {
            throw new \InvalidArgumentException('Invalid reservation date or time');
        }

        if (!$reservationDTO->isWithinBusinessHours()) {
            throw new \InvalidArgumentException('Reservation time is outside business hours');
        }

        if ($reservationDTO->guests < 1 || $reservationDTO->guests > 20) {
            throw new \InvalidArgumentException('Number of guests must be between 1 and 20');
        }
    }

    /**
     * Check table availability
     */
    private function checkAvailability(ReservationDTO $reservationDTO): bool
    {
        $existingReservations = Reservation::where('reservation_date', $reservationDTO->reservationDate)
            ->where('reservation_time', $reservationDTO->reservationTime)
            ->where('status', '!=', 'cancelled')
            ->count();

        // Assume we have 10 tables maximum
        return $existingReservations < 10;
    }

    /**
     * Generate unique reservation ID
     */
    private function generateReservationId(): string
    {
        return 'CE' . str_pad(Reservation::count() + 1, 6, '0', STR_PAD_LEFT);
    }
}