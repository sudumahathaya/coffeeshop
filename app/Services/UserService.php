<?php

namespace App\Services;

use App\Models\User;
use App\Models\ProfileChangeRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class UserService
{
    /**
     * Create a new user
     */
    public function createUser(array $data): array
    {
        try {
            DB::beginTransaction();

            // Validate user data
            $this->validateUserData($data);

            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => $data['role'] ?? 'customer',
                'email_verified_at' => now(),
            ]);

            DB::commit();

            Log::info('User created successfully', [
                'user_id' => $user->id,
                'email' => $user->email,
                'role' => $user->role
            ]);

            return [
                'success' => true,
                'message' => 'User created successfully',
                'user' => $user
            ];

        } catch (\Exception $e) {
            DB::rollback();
            
            Log::error('User creation failed', [
                'error' => $e->getMessage(),
                'data' => array_except($data, ['password'])
            ]);

            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Update user information
     */
    public function updateUser(int $id, array $data): array
    {
        try {
            $user = User::findOrFail($id);
            
            // Validate update data
            $this->validateUserData($data, $id);

            $user->update($data);

            Log::info('User updated successfully', [
                'user_id' => $user->id,
                'changes' => $user->getChanges()
            ]);

            return [
                'success' => true,
                'message' => 'User updated successfully',
                'user' => $user
            ];

        } catch (\Exception $e) {
            Log::error('User update failed', [
                'user_id' => $id,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Delete a user
     */
    public function deleteUser(int $id): array
    {
        try {
            $user = User::findOrFail($id);
            
            if ($user->id === auth()->id()) {
                throw new \Exception('You cannot delete your own account');
            }
            
            $userInfo = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email
            ];
            
            $user->delete();

            Log::info('User deleted successfully', $userInfo);

            return [
                'success' => true,
                'message' => 'User deleted successfully'
            ];

        } catch (\Exception $e) {
            Log::error('User deletion failed', [
                'user_id' => $id,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Get user statistics
     */
    public function getUserStatistics(int $id): array
    {
        try {
            $user = User::with(['orders', 'reservations', 'loyaltyPoints'])->findOrFail($id);
            
            $stats = [
                'total_orders' => $user->orders->count(),
                'total_spent' => $user->orders->sum('total'),
                'total_reservations' => $user->reservations->count(),
                'loyalty_points' => $user->total_loyalty_points,
                'loyalty_tier' => $user->loyalty_tier,
                'recent_orders' => $user->orders()->latest()->take(5)->get(),
                'recent_reservations' => $user->reservations()->latest()->take(3)->get(),
                'account_created' => $user->created_at,
                'last_activity' => $user->updated_at
            ];

            return [
                'success' => true,
                'user' => $user,
                'stats' => $stats
            ];

        } catch (\Exception $e) {
            Log::error('Failed to get user statistics', [
                'user_id' => $id,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => 'Failed to retrieve user statistics'
            ];
        }
    }

    /**
     * Submit profile change request
     */
    public function submitProfileChangeRequest(int $userId, array $requestedChanges): array
    {
        try {
            $user = User::findOrFail($userId);
            
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
            foreach ($requestedChanges as $key => $value) {
                if (($currentData[$key] ?? null) !== $value) {
                    $hasChanges = true;
                    break;
                }
            }

            if (!$hasChanges) {
                return [
                    'success' => false,
                    'message' => 'No changes detected in your profile.'
                ];
            }

            // Check if user has pending request
            $existingRequest = ProfileChangeRequest::where('user_id', $user->id)
                ->where('status', 'pending')
                ->first();

            if ($existingRequest) {
                // Update existing pending request
                $existingRequest->update([
                    'requested_changes' => $requestedChanges,
                    'current_data' => $currentData,
                ]);
            } else {
                // Create new request
                ProfileChangeRequest::create([
                    'user_id' => $user->id,
                    'requested_changes' => $requestedChanges,
                    'current_data' => $currentData,
                    'status' => 'pending',
                ]);
            }

            Log::info('Profile change request submitted', [
                'user_id' => $userId,
                'changes' => $requestedChanges
            ]);

            return [
                'success' => true,
                'message' => 'Profile change request submitted successfully! It will be reviewed by an administrator.',
                'status' => 'pending'
            ];

        } catch (\Exception $e) {
            Log::error('Failed to submit profile change request', [
                'user_id' => $userId,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => 'Failed to submit profile change request'
            ];
        }
    }

    /**
     * Validate user data
     */
    private function validateUserData(array $data, ?int $excludeId = null): void
    {
        if (empty($data['name'])) {
            throw new \InvalidArgumentException('Name is required');
        }

        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Valid email address is required');
        }

        // Check for duplicate email
        $query = User::where('email', $data['email']);
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }
        
        if ($query->exists()) {
            throw new \InvalidArgumentException('Email address is already in use');
        }

        if (isset($data['password']) && strlen($data['password']) < 8) {
            throw new \InvalidArgumentException('Password must be at least 8 characters long');
        }

        if (isset($data['role']) && !in_array($data['role'], ['customer', 'admin'])) {
            throw new \InvalidArgumentException('Invalid role specified');
        }
    }
}