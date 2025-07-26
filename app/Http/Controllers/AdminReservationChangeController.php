<?php

namespace App\Http\Controllers;

use App\Models\ReservationChangeRequest;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminReservationChangeController extends Controller
{
    public function index()
    {
        $requests = ReservationChangeRequest::with(['reservation', 'user'])
            ->latest()
            ->paginate(20);

        return view('admin.reservation-requests.index', compact('requests'));
    }

    public function show($id)
    {
        $request = ReservationChangeRequest::with(['reservation', 'user', 'approvedBy'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'request' => $request
        ]);
    }

    public function approve(Request $request, $id)
    {
        $validatedData = $request->validate([
            'admin_notes' => 'nullable|string|max:1000'
        ]);

        $changeRequest = ReservationChangeRequest::findOrFail($id);

        if ($changeRequest->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'This request has already been processed.'
            ], 400);
        }

        // Apply the changes to the reservation
        $reservation = $changeRequest->reservation;
        $reservation->update($changeRequest->requested_changes);

        // Update the request status
        $changeRequest->update([
            'status' => 'approved',
            'admin_notes' => $validatedData['admin_notes'] ?? null,
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Reservation change request approved successfully!',
            'request' => $changeRequest->fresh(['reservation', 'user', 'approvedBy'])
        ]);
    }

    public function reject(Request $request, $id)
    {
        $validatedData = $request->validate([
            'admin_notes' => 'required|string|max:1000'
        ]);

        $changeRequest = ReservationChangeRequest::findOrFail($id);

        if ($changeRequest->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'This request has already been processed.'
            ], 400);
        }

        $changeRequest->update([
            'status' => 'rejected',
            'admin_notes' => $validatedData['admin_notes'],
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Reservation change request rejected.',
            'request' => $changeRequest->fresh(['reservation', 'user', 'approvedBy'])
        ]);
    }

    public function getPendingCount()
    {
        $count = ReservationChangeRequest::where('status', 'pending')->count();

        return response()->json([
            'success' => true,
            'pending_count' => $count
        ]);
    }

    public function destroy($id)
    {
        try {
            $changeRequest = ReservationChangeRequest::findOrFail($id);
            $changeRequest->delete();

            return response()->json([
                'success' => true,
                'message' => 'Reservation change request deleted successfully'
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Reservation change request not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete reservation change request: ' . $e->getMessage()
            ], 500);
        }
    }
}