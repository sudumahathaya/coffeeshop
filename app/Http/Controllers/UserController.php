<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        
        // Sample data - in production, this would come from database
        $dashboardData = [
            'user' => $user,
            'stats' => [
                'total_orders' => 24,
                'loyalty_points' => 1250,
                'total_reservations' => 8,
                'favorite_items' => 12,
                'total_spent' => 28500.00,
                'current_tier' => 'Gold',
                'points_to_next_tier' => 250
            ],
            'recent_orders' => [
                (object) [
                    'id' => 'CE2024001',
                    'items' => 'Cappuccino x2, Croissant x1',
                    'total' => 1240.00,
                    'status' => 'completed',
                    'date' => '2024-12-15 14:30:00'
                ],
                (object) [
                    'id' => 'CE2024002',
                    'items' => 'Latte x1, Sandwich x1',
                    'total' => 850.00,
                    'status' => 'completed',
                    'date' => '2024-12-12 10:15:00'
                ],
                (object) [
                    'id' => 'CE2024003',
                    'items' => 'Iced Coffee x1, Muffin x2',
                    'total' => 920.00,
                    'status' => 'completed',
                    'date' => '2024-12-10 16:45:00'
                ]
            ],
            'upcoming_reservations' => [
                (object) [
                    'id' => 'RES001',
                    'date' => '2024-12-22',
                    'time' => '18:30',
                    'guests' => 4,
                    'table_preference' => 'Window Side',
                    'status' => 'confirmed'
                ]
            ],
            'favorite_items' => [
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
            ]
        ];

        return view('user.dashboard', $dashboardData);
    }

    public function orders()
    {
        return view('user.orders');
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
        // Sample order history - in production, fetch from database
        $orders = [
            (object) [
                'id' => 'CE2024004',
                'items' => 'Frappuccino x1, Cookie x2',
                'total' => 1080.00,
                'status' => 'completed',
                'date' => '2024-12-08 15:20:00'
            ],
            (object) [
                'id' => 'CE2024005',
                'items' => 'Espresso x2, Cake x1',
                'total' => 890.00,
                'status' => 'completed',
                'date' => '2024-12-05 11:30:00'
            ]
        ];

        return response()->json([
            'success' => true,
            'orders' => $orders
        ]);
    }

    public function reorderLast()
    {
        // Get user's last order and add items to cart
        // In production, this would fetch the actual last order from database
        
        $lastOrder = [
            'items' => [
                ['name' => 'Cappuccino', 'quantity' => 2, 'price' => 480.00],
                ['name' => 'Croissant', 'quantity' => 1, 'price' => 280.00]
            ]
        ];

        return response()->json([
            'success' => true,
            'message' => 'Last order added to cart!',
            'order' => $lastOrder
        ]);
    }

    public function getLoyaltyDetails()
    {
        $loyaltyData = [
            'current_points' => 1250,
            'current_tier' => 'Gold',
            'points_to_next_tier' => 250,
            'next_tier' => 'Platinum',
            'lifetime_points' => 3450,
            'points_earned_this_month' => 180,
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
}