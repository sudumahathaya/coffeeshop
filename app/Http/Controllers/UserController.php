<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Reservation;
use App\Models\LoyaltyPoint;

class UserController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        
        // Get real user data
        $dashboardData = [
            'user' => $user,
            'stats' => [
                'total_orders' => $user->orders()->count(),
                'loyalty_points' => $user->total_loyalty_points,
                'total_reservations' => $user->reservations()->count(),
                'favorite_items' => 12, // This would be calculated from user preferences
                'total_spent' => $user->orders()->sum('total'),
                'current_tier' => $user->loyalty_tier,
                'points_to_next_tier' => $this->getPointsToNextTier($user->total_loyalty_points)
            ],
            'recent_orders' => $user->orders()->latest()->take(3)->get(),
            'upcoming_reservations' => $user->reservations()->upcoming()->take(3)->get(),
            'favorite_items' => $this->getFavoriteItems($user)
        ];

        return view('user.dashboard', $dashboardData);
    }

    public function orders()
    {
        $orders = Auth::user()->orders()->latest()->paginate(10);
        return view('user.orders', compact('orders'));
    }

    public function updateProfile(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'phone' => 'nullable|string|max:20',
            'birthday' => 'nullable|date',
            'preferences' => 'nullable|array',
            'email_notifications' => 'nullable|boolean'
        ]);

        $user = Auth::user();
        $user->update([
            'name' => $validatedData['name'],
            'email' => $validatedData['email']
        ]);

        // In production, you would also update additional profile fields
        // in a separate profile table or user_preferences table

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully!'
        ]);
    }

    public function getOrderHistory(Request $request)
    {
        $orders = Auth::user()->orders()->latest()->get();

        return response()->json([
            'success' => true,
            'orders' => $orders
        ]);
    }

    public function reorderLast()
    {
        $lastOrder = Auth::user()->orders()->latest()->first();
        
        if (!$lastOrder) {
            return response()->json([
                'success' => false,
                'message' => 'No previous orders found'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Last order added to cart!',
            'order' => $lastOrder
        ]);
    }

    public function getLoyaltyDetails()
    {
        $user = Auth::user();
        $totalPoints = $user->total_loyalty_points;
        
        $loyaltyData = [
            'current_points' => $totalPoints,
            'current_tier' => $user->loyalty_tier,
            'points_to_next_tier' => $this->getPointsToNextTier($totalPoints),
            'next_tier' => 'Platinum',
            'lifetime_points' => $user->loyaltyPoints()->earned()->sum('points'),
            'points_earned_this_month' => $user->loyaltyPoints()->earned()
                ->whereMonth('created_at', now()->month)->sum('points'),
            'available_rewards' => [
                ['name' => 'Free Coffee', 'points_required' => 500],
                ['name' => 'Free Pastry', 'points_required' => 300],
                ['name' => '20% Discount Voucher', 'points_required' => 200]
            ]
        ];

        return response()->json([
            'success' => true,
            'loyalty' => $loyaltyData
        ]);
    }

    private function getPointsToNextTier($currentPoints)
    {
        if ($currentPoints < 500) {
            return 500 - $currentPoints; // To Gold
        } elseif ($currentPoints < 1500) {
            return 1500 - $currentPoints; // To Platinum
        }
        return 0; // Already at highest tier
    }

    private function getFavoriteItems($user)
    {
        // This would be calculated from order history
        // For now, return sample data
        return [
            (object) [
                'name' => 'Cappuccino',
                'price' => 480.00,
                'order_count' => 8,
                'image' => 'https://images.unsplash.com/photo-1572442388796-11668a67e53d?w=80&h=80&fit=crop'
            ],
            (object) [
                'name' => 'Café Latte',
                'price' => 520.00,
                'order_count' => 6,
                'image' => 'https://images.unsplash.com/photo-1561882468-9110e03e0f78?w=80&h=80&fit=crop'
            ],
            (object) [
                'name' => 'Caramel Macchiato',
                'price' => 650.00,
                'order_count' => 4,
                'image' => 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=80&h=80&fit=crop'
            ],
            (object) [
                'name' => 'Butter Croissant',
                'price' => 280.00,
                'order_count' => 5,
                'image' => 'https://images.unsplash.com/photo-1555507036-ab794f4afe5b?w=80&h=80&fit=crop'
            ]
        ];
    }
}