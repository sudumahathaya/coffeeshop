<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\ReservationChangeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationChangeController extends Controller
{
    public function store(Request $request, $reservationId)
    {
        $reservation = Reservation::where('id', $reservationId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $validatedData = $request->validate([
            'reservation_date' => 'required|date|after:today',
            'reservation_time' => 'required|string',
            'guests' => 'required|integer|min:1|max:20',
            'table_type' => 'nullable|string',
            'occasion' => 'nullable|string',
            'special_requests' => 'nullable|string|max:1000',
        ]);

        // Get current reservation data
        $currentData = [
            'reservation_date' => $reservation->reservation_date instanceof \Carbon\Carbon ? $reservation->reservation_date->format('Y-m-d') : $reservation->reservation_date,
            'reservation_time' => $reservation->reservation_time instanceof \Carbon\Carbon ? $reservation->reservation_time->format('H:i') : $reservation->reservation_time,
            'guests' => $reservation->guests,
            'table_type' => $reservation->table_type,
            'occasion' => $reservation->occasion,
            'special_requests' => $reservation->special_requests,
        ];

        // Check if there are any changes
        $hasChanges = false;
        foreach ($validatedData as $key => $value) {
            if ($currentData[$key] !== $value) {
                $hasChanges = true;
                break;
            }
        }

        if (!$hasChanges) {
            return response()->json([
                'success' => false,
                'message' => 'No changes detected in your reservation.'
            ]);
        }

        // Check if reservation has pending change request
        $existingRequest = ReservationChangeRequest::where('reservation_id', $reservation->id)
            ->where('status', 'pending')
            ->first();

        if ($existingRequest) {
            // Update existing pending request
            $existingRequest->update([
                'requested_changes' => $validatedData,
                'current_data' => $currentData,
            ]);
        } else {
            // Create new change request
            ReservationChangeRequest::create([
                'reservation_id' => $reservation->id,
                'user_id' => Auth::id(),
                'requested_changes' => $validatedData,
                'current_data' => $currentData,
                'status' => 'pending',
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Reservation change request submitted successfully! It will be reviewed by an administrator.',
            'request_id' => $existingRequest ? $existingRequest->id : ReservationChangeRequest::latest()->first()->id,
            'status' => 'pending'
        ]);
    }

    public function getReservationPendingRequest($reservationId)
    {
        $pendingRequest = ReservationChangeRequest::where('reservation_id', $reservationId)
            ->where('user_id', Auth::id())
            ->with('reservation')
            ->where('status', 'pending')
            ->first();

        return response()->json([
            'success' => true,
            'has_pending_request' => $pendingRequest !== null,
            'pending_request' => $pendingRequest,
            'reservation_details' => $pendingRequest ? $pendingRequest->reservation : null
        ]);
    }

    public function cancelRequest($id)
    {
        $request = ReservationChangeRequest::where('id', $id)
            ->where('user_id', Auth::id())
            ->with('reservation')
            ->where('status', 'pending')
            ->first();

        if (!$request) {
            return response()->json([
                'success' => false,
                'message' => 'Request not found or cannot be cancelled.'
            ], 404);
        }

        $reservationId = $request->reservation_id;
        $request->delete();

        return response()->json([
            'success' => true,
            'message' => 'Reservation change request cancelled successfully.'
        ]);
    }
}