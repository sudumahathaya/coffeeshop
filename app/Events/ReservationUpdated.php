<?php

namespace App\Events;

use App\Models\Reservation;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ReservationUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $reservation;

    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;
    }

    public function broadcastOn()
    {
        return new Channel('reservations');
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->reservation->id,
            'reservation_id' => $this->reservation->reservation_id,
            'status' => $this->reservation->status,
            'customer_name' => $this->reservation->full_name,
            'updated_at' => $this->reservation->updated_at->toISOString()
        ];
    }
}