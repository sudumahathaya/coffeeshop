<?php

namespace App\Http\Controllers;

use App\Models\ProfileChangeRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminProfileController extends Controller
{
    public function index()
    {
        $requests = ProfileChangeRequest::with('user')
            ->latest()
            ->paginate(20);

        return view('admin.profile-requests.index', compact('requests'));
    }

    public function show($id)
    {
        $request = ProfileChangeRequest::with(['user', 'approvedBy'])->findOrFail($id);

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

        $changeRequest = ProfileChangeRequest::findOrFail($id);

        if ($changeRequest->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'This request has already been processed.'
            ], 400);
        }

        // Apply the changes to the user
        $user = $changeRequest->user;
        $user->update($changeRequest->requested_changes);

        // Update the request status
        $changeRequest->update([
            'status' => 'approved',
            'admin_notes' => $validatedData['admin_notes'] ?? null,
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Profile change request approved successfully!',
            'request' => $changeRequest->fresh(['user', 'approvedBy'])
        ]);
    }

    public function reject(Request $request, $id)
    {
        $validatedData = $request->validate([
            'admin_notes' => 'required|string|max:1000'
        ]);

        $changeRequest = ProfileChangeRequest::findOrFail($id);

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
            'message' => 'Profile change request rejected.',
            'request' => $changeRequest->fresh(['user', 'approvedBy'])
        ]);
    }

    public function getPendingCount()
    {
        $count = ProfileChangeRequest::where('status', 'pending')->count();

        return response()->json([
            'success' => true,
            'pending_count' => $count
        ]);
    }
}