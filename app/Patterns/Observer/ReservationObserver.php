<?php

namespace App\Patterns\Observer;

use App\Models\Reservation;

class ReservationObserver
{
    /**
     * Handle the Reservation "created" event.
     */
    public function created(Reservation $reservation): void
    {
        \Log::info('Reservation created via observer', [
            'reservation_id' => $reservation->reservation_id,
            'customer' => $reservation->full_name,
            'date' => $reservation->reservation_date,
            'guests' => $reservation->guests
        ]);

        // Send real-time notification to admin
        broadcast(new \App\Events\ReservationUpdated($reservation))->toOthers();
    }

    /**
     * Handle the Reservation "updated" event.
     */
    public function updated(Reservation $reservation): void
    {
        \Log::info('Reservation updated via observer', [
            'reservation_id' => $reservation->reservation_id,
            'changes' => $reservation->getChanges()
        ]);

        // Broadcast status changes
        if ($reservation->wasChanged('status')) {
            broadcast(new \App\Events\ReservationUpdated($reservation))->toOthers();
        }
    }

    /**
     * Handle the Reservation "deleted" event.
     */
    public function deleted(Reservation $reservation): void
    {
        \Log::info('Reservation deleted via observer', [
            'reservation_id' => $reservation->reservation_id,
            'customer' => $reservation->full_name
        ]);
    }
}