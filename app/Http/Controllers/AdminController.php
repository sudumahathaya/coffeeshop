<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use App\Models\Order;
use App\Models\Reservation;
use App\Models\ContactMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{

    public function dashboard()
    {
        // Dashboard statistics
        $stats = [
            'total_users' => User::count(),
            'new_users_today' => User::whereDate('created_at', today())->count(),
            'total_reservations' => Reservation::count(),
            'pending_reservations' => Reservation::pending()->count(),
            'revenue_today' => Order::today()->sum('total'),
            'revenue_month' => Order::whereMonth('created_at', now()->month)->sum('total'),
            'popular_items' => $this->getPopularMenuItems(),
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
        $reservations = Reservation::with('user')->latest()->paginate(20);

        return view('admin.reservations.index', compact('reservations'));
    }

    public function orders()
    {
        $orders = Order::with('user')->latest()->paginate(20);

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

    public function menuManagement()
    {
        $menuItems = MenuItem::latest()->get();
        $categories = MenuItem::select('category')->distinct()->pluck('category');

        return view('admin.menu.index', compact('menuItems', 'categories'));
    }

    public function analytics()
    {
        // Sample analytics data
        $analyticsData = [
            'overview' => [
                'total_revenue' => 1250000.00,
                'total_orders' => 3456,
                'total_customers' => 892,
                'avg_order_value' => 850.00,
                'revenue_growth' => 12.5,
                'order_growth' => 8.3,
                'customer_growth' => 15.2
            ],
            'sales_by_period' => [
                'daily' => [
                    'labels' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                    'data' => [35000, 42000, 38000, 51000, 49000, 62000, 58000]
                ],
                'monthly' => [
                    'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    'data' => [120000, 135000, 128000, 145000, 152000, 168000, 175000, 162000, 158000, 172000, 185000, 195000]
                ]
            ],
            'top_products' => [
                ['name' => 'Cappuccino', 'sales' => 456, 'revenue' => 218880],
                ['name' => 'Latte', 'sales' => 389, 'revenue' => 202280],
                ['name' => 'Espresso', 'sales' => 312, 'revenue' => 99840],
                ['name' => 'Caramel Macchiato', 'sales' => 278, 'revenue' => 180700],
                ['name' => 'Iced Coffee', 'sales' => 234, 'revenue' => 135720]
            ],
            'customer_analytics' => [
                'new_customers_monthly' => [
                    'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    'data' => [45, 52, 48, 61, 58, 67]
                ],
                'customer_retention' => 78.5,
                'avg_visits_per_customer' => 3.8,
                'customer_lifetime_value' => 2850.00
            ],
            'peak_hours' => [
                'labels' => ['6AM', '7AM', '8AM', '9AM', '10AM', '11AM', '12PM', '1PM', '2PM', '3PM', '4PM', '5PM', '6PM', '7PM', '8PM', '9PM'],
                'data' => [12, 45, 89, 67, 34, 28, 56, 78, 45, 67, 89, 76, 65, 54, 43, 32]
            ],
            'payment_methods' => [
                'labels' => ['Cash', 'Card', 'Mobile Payment', 'Gift Card'],
                'data' => [35, 45, 15, 5]
            ]
        ];

        return view('admin.analytics.index', compact('analyticsData'));
    }

    // Helper methods for statistics
    private function getPopularMenuItems()
    {
        // This would be calculated from actual order data
        return MenuItem::active()->take(3)->get()->map(function ($item) {
            return [
                'name' => $item->name,
                'orders' => rand(50, 100) // Simulated for now
            ];
        })->toArray();
    }

    private function getDailySalesData()
    {
        // Get last 7 days sales data
        $salesData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $sales = Order::whereDate('created_at', $date)->sum('total');
            $salesData[] = $sales ?: rand(30000, 60000); // Fallback to random data if no orders
        }
        
        return [
            'labels' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            'data' => $salesData
        ];
    }

    private function getUserRegistrationData()
    {
        // Get last 6 months user registration data
        $registrationData = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $count = User::whereMonth('created_at', $month->month)
                        ->whereYear('created_at', $month->year)
                        ->count();
            $registrationData[] = $count ?: rand(10, 30);
        }
        
        return [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            'data' => $registrationData
        ];
    }

    private function getReservationTrends()
    {
        // Get last 4 weeks reservation data
        $reservationData = [];
        for ($i = 3; $i >= 0; $i--) {
            $weekStart = now()->subWeeks($i)->startOfWeek();
            $weekEnd = now()->subWeeks($i)->endOfWeek();
            $count = Reservation::whereBetween('created_at', [$weekStart, $weekEnd])->count();
            $reservationData[] = $count ?: rand(40, 70);
        }
        
        return [
            'labels' => ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
            'data' => $reservationData
        ];
    }
}