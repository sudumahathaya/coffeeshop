<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // Constructor removed - middleware handled in routes

    public function dashboard()
    {
        // Dashboard statistics
        $stats = [
            'total_users' => User::count(),
            'new_users_today' => User::whereDate('created_at', today())->count(),
            'total_reservations' => $this->getReservationsCount(),
            'pending_reservations' => $this->getPendingReservationsCount(),
            'revenue_today' => $this->getTodayRevenue(),
            'revenue_month' => $this->getMonthRevenue(),
            'popular_items' => $this->getPopularItems(),
            'recent_users' => User::latest()->take(5)->get(),
        ];

        // Chart data
        $chartData = [
            'daily_sales' => $this->getDailySalesData(),
            'user_registrations' => $this->getUserRegistrationData(),
            'reservation_trends' => $this->getReservationTrends(),
        ];

        return view('admin.dashboard', compact('stats', 'chartData'));
    }

    public function users()
    {
        $users = User::latest()->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function reservations()
    {
        // In a real app, you'd have a reservations table
        $reservations = collect([
            (object) [
                'id' => 'CE001',
                'customer_name' => 'John Doe',
                'email' => 'john@example.com',
                'date' => '2024-12-20',
                'time' => '14:00',
                'guests' => 4,
                'status' => 'confirmed',
                'created_at' => now()->subHours(2)
            ],
            (object) [
                'id' => 'CE002',
                'customer_name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'date' => '2024-12-21',
                'time' => '18:30',
                'guests' => 2,
                'status' => 'pending',
                'created_at' => now()->subHours(1)
            ]
        ]);

        return view('admin.reservations.index', compact('reservations'));
    }

    public function orders()
    {
        // Sample orders data
        $orders = collect([
            (object) [
                'id' => 'ORD001',
                'customer_name' => 'Alice Johnson',
                'items' => 'Cappuccino x2, Croissant x1',
                'total' => 1200.00,
                'status' => 'completed',
                'created_at' => now()->subMinutes(30)
            ],
            (object) [
                'id' => 'ORD002',
                'customer_name' => 'Bob Wilson',
                'items' => 'Latte x1, Sandwich x1',
                'total' => 850.00,
                'status' => 'preparing',
                'created_at' => now()->subMinutes(15)
            ]
        ]);

        return view('admin.orders.index', compact('orders'));
    }

    public function settings()
    {
        $settings = [
            'cafe_name' => 'Café Elixir',
            'opening_time' => '06:00',
            'closing_time' => '22:00',
            'max_reservation_guests' => 20,
            'reservation_advance_days' => 30,
            'contact_email' => 'info@cafeelixir.lk',
            'contact_phone' => '+94 77 186 9132',
        ];

        return view('admin.settings', compact('settings'));
    }

    // Helper methods for statistics
    private function getReservationsCount()
    {
        // In real app, count from reservations table
        return 156;
    }

    private function getPendingReservationsCount()
    {
        return 12;
    }

    private function getTodayRevenue()
    {
        return 45000.00;
    }

    private function getMonthRevenue()
    {
        return 1250000.00;
    }

    private function getPopularItems()
    {
        return [
            ['name' => 'Cappuccino', 'orders' => 89],
            ['name' => 'Latte', 'orders' => 76],
            ['name' => 'Espresso', 'orders' => 54],
        ];
    }

    private function getDailySalesData()
    {
        return [
            'labels' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            'data' => [35000, 42000, 38000, 51000, 49000, 62000, 58000]
        ];
    }

    private function getUserRegistrationData()
    {
        return [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            'data' => [12, 19, 15, 25, 22, 30]
        ];
    }

    private function getReservationTrends()
    {
        return [
            'labels' => ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
            'data' => [45, 52, 48, 61]
        ];
    }
}