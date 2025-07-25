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

    public function menuManagement()
    {
        // Sample menu items data
        $menuItems = [
            (object) [
                'id' => 1,
                'name' => 'Classic Espresso',
                'category' => 'Hot Coffee',
                'price' => 320.00,
                'description' => 'Rich, bold espresso shot with perfect crema',
                'image' => 'https://images.unsplash.com/photo-1510591509098-f4fdc6d0ff04?w=400&h=300&fit=crop',
                'status' => 'active',
                'preparation_time' => '2-3 min',
                'ingredients' => ['Espresso beans', 'Water'],
                'allergens' => [],
                'calories' => 5,
                'created_at' => now()->subDays(30)
            ],
            (object) [
                'id' => 2,
                'name' => 'Cappuccino',
                'category' => 'Hot Coffee',
                'price' => 480.00,
                'description' => 'Perfect balance of espresso, steamed milk, and foam',
                'image' => 'https://images.unsplash.com/photo-1572442388796-11668a67e53d?w=400&h=300&fit=crop',
                'status' => 'active',
                'preparation_time' => '3-4 min',
                'ingredients' => ['Espresso', 'Steamed milk', 'Milk foam'],
                'allergens' => ['Dairy'],
                'calories' => 120,
                'created_at' => now()->subDays(25)
            ],
            (object) [
                'id' => 3,
                'name' => 'Caramel Macchiato',
                'category' => 'Specialty',
                'price' => 650.00,
                'description' => 'Rich espresso with vanilla syrup and caramel drizzle',
                'image' => 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=400&h=300&fit=crop',
                'status' => 'active',
                'preparation_time' => '5-6 min',
                'ingredients' => ['Espresso', 'Vanilla syrup', 'Steamed milk', 'Caramel sauce'],
                'allergens' => ['Dairy'],
                'calories' => 250,
                'created_at' => now()->subDays(20)
            ],
            (object) [
                'id' => 4,
                'name' => 'Iced Coffee',
                'category' => 'Cold Coffee',
                'price' => 580.00,
                'description' => 'Cold brew coffee served over ice',
                'image' => 'https://images.unsplash.com/photo-1461023058943-07fcbe16d735?w=400&h=300&fit=crop',
                'status' => 'active',
                'preparation_time' => '3-4 min',
                'ingredients' => ['Cold brew coffee', 'Ice', 'Milk'],
                'allergens' => ['Dairy'],
                'calories' => 80,
                'created_at' => now()->subDays(15)
            ],
            (object) [
                'id' => 5,
                'name' => 'Ceylon Tea',
                'category' => 'Tea & Others',
                'price' => 380.00,
                'description' => 'Premium Sri Lankan black tea',
                'image' => 'https://images.unsplash.com/photo-1597318374671-96ee162414ca?w=400&h=300&fit=crop',
                'status' => 'active',
                'preparation_time' => '3-4 min',
                'ingredients' => ['Ceylon tea leaves', 'Hot water'],
                'allergens' => [],
                'calories' => 2,
                'created_at' => now()->subDays(10)
            ]
        ];

        $categories = [
            'Hot Coffee',
            'Cold Coffee',
            'Specialty',
            'Tea & Others',
            'Food & Snacks'
        ];

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