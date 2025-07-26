<?php

namespace App\Http\Controllers;

use App\Models\ProfileChangeRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileChangeController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'phone' => 'nullable|string|max:20',
            'birthday' => 'nullable|date',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
        ]);

        $user = Auth::user();
        
        // Get current user data
        $currentData = [
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone ?? null,
            'birthday' => $user->birthday ?? null,
            'address' => $user->address ?? null,
            'city' => $user->city ?? null,
            'postal_code' => $user->postal_code ?? null,
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
                'message' => 'No changes detected in your profile.'
            ]);
        }

        // Check if user has pending request
        $existingRequest = ProfileChangeRequest::where('user_id', $user->id)
            ->where('status', 'pending')
            ->first();

        if ($existingRequest) {
            // Update existing pending request
            $existingRequest->update([
                'requested_changes' => $validatedData,
                'current_data' => $currentData,
            ]);
        } else {
            // Create new request
            ProfileChangeRequest::create([
                'user_id' => $user->id,
                'requested_changes' => $validatedData,
                'current_data' => $currentData,
                'status' => 'pending',
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Profile change request submitted successfully! It will be reviewed by an administrator.',
            'status' => 'pending'
        ]);
    }

    public function getUserPendingRequest()
    {
        $user = Auth::user();
        $pendingRequest = ProfileChangeRequest::where('user_id', $user->id)
            ->where('status', 'pending')
            ->first();

        return response()->json([
            'success' => true,
            'has_pending_request' => $pendingRequest !== null,
            'pending_request' => $pendingRequest
        ]);
    }

    public function cancelRequest($id)
    {
        $request = ProfileChangeRequest::where('id', $id)
            ->where('user_id', Auth::id())
            ->where('status', 'pending')
            ->first();

        if (!$request) {
            return response()->json([
                'success' => false,
                'message' => 'Request not found or cannot be cancelled.'
            ], 404);
        }

        $request->delete();

        return response()->json([
            'success' => true,
            'message' => 'Profile change request cancelled successfully.'
        ]);
    }
}