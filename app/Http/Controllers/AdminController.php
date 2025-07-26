<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MenuItem;
use App\Models\Reservation;
use App\Models\ContactMessage;
use App\Models\NewsletterSubscriber;
use App\Models\User;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Dashboard statistics
        $stats = [
            'total_users' => User::count(),
            'new_users_today' => User::whereDate('created_at', today())->count(),
            'total_reservations' => Reservation::count(),
            'pending_reservations' => Reservation::where('status', 'pending')->count(),
            'revenue_today' => Order::whereDate('created_at', today())->sum('total'),
            'revenue_month' => Order::whereMonth('created_at', now()->month)->sum('total'),
            'popular_items' => [
                ['name' => 'Cappuccino', 'orders' => 45],
                ['name' => 'Latte', 'orders' => 38],
                ['name' => 'Espresso', 'orders' => 32],
                ['name' => 'Americano', 'orders' => 28]
            ],
            'recent_users' => User::latest()->take(5)->get()
        ];

        // Chart data for dashboard
        $chartData = [
            'daily_sales' => [
                'labels' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                'data' => [12000, 15000, 18000, 14000, 22000, 25000, 20000]
            ]
        ];

        return view('admin.dashboard', compact('stats', 'chartData'));
    }

    public function reservations()
    {
        // Get today's reservations and statistics
        $todayReservations = Reservation::whereDate('reservation_date', today())->get();
        $pendingReservations = Reservation::where('status', 'pending')->get();
        $confirmedReservations = Reservation::where('status', 'confirmed')->get();
        $totalGuests = Reservation::whereDate('reservation_date', today())->sum('guests');
        
        // All reservations for the table
        $reservations = Reservation::with('user')
            ->latest('reservation_date')
            ->latest('reservation_time')
            ->paginate(20);

        $stats = [
            'today_count' => $todayReservations->count(),
            'pending_count' => $pendingReservations->count(),
            'confirmed_count' => $confirmedReservations->count(),
            'total_guests' => $totalGuests
        ];

        return view('admin.reservations.index', compact('reservations', 'stats'));
    }

    public function createUser()
    {
        return view('admin.users.create');
    }

    public function storeUser(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:customer,admin',
            'phone' => 'nullable|string|max:20',
            'birthday' => 'nullable|date',
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'role' => $validatedData['role'],
            'email_verified_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'User created successfully',
            'user' => $user
        ], 201);
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return response()->json([
            'success' => true,
            'user' => $user
        ]);
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:customer,admin',
            'phone' => 'nullable|string|max:20',
            'birthday' => 'nullable|date',
        ]);

        $user->update($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'User updated successfully',
            'user' => $user
        ]);
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->id === auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot delete your own account'
            ], 403);
        }
        
        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully'
        ]);
    }

    public function getUserStats($id)
    {
        $user = User::with(['orders', 'reservations', 'loyaltyPoints'])->findOrFail($id);
        
        $stats = [
            'total_orders' => $user->orders->count(),
            'total_spent' => $user->orders->sum('total'),
            'total_reservations' => $user->reservations->count(),
            'loyalty_points' => $user->total_loyalty_points,
            'loyalty_tier' => $user->loyalty_tier,
            'recent_orders' => $user->orders()->latest()->take(5)->get(),
            'recent_reservations' => $user->reservations()->latest()->take(3)->get(),
        ];

        return response()->json([
            'success' => true,
            'user' => $user,
            'stats' => $stats
        ]);
    }

    public function orders()
    {
        $orders = Order::with('user')->latest()->paginate(20);
        return view('admin.orders.index', compact('orders'));
    }

    public function users()
    {
        $users = User::latest()->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function menuManagement()
    {
        $menuItems = MenuItem::all();
        $categories = MenuItem::select('category')->distinct()->pluck('category');
        return view('admin.menu.index', compact('menuItems', 'categories'));
    }

    public function analytics()
    {
        // Sample analytics data
        $analyticsData = [
            'overview' => [
                'total_revenue' => 125000,
                'revenue_growth' => 12.5,
                'total_orders' => 450,
                'order_growth' => 8.3,
                'total_customers' => 280,
                'customer_growth' => 15.2,
                'avg_order_value' => 850
            ],
            'sales_by_period' => [
                'daily' => [
                    'labels' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                    'data' => [12000, 15000, 18000, 14000, 22000, 25000, 20000]
                ],
                'monthly' => [
                    'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    'data' => [45000, 52000, 48000, 61000, 55000, 67000]
                ]
            ],
            'top_products' => [
                ['name' => 'Cappuccino', 'sales' => 156, 'revenue' => 74880],
                ['name' => 'Latte', 'sales' => 134, 'revenue' => 69680],
                ['name' => 'Americano', 'sales' => 98, 'revenue' => 39200],
                ['name' => 'Espresso', 'sales' => 87, 'revenue' => 27840]
            ],
            'customer_analytics' => [
                'customer_retention' => 78.5,
                'avg_visits_per_customer' => 3.2,
                'new_customers_monthly' => [
                    'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    'data' => [25, 32, 28, 41, 35, 47]
                ]
            ],
            'peak_hours' => [
                'labels' => ['6AM', '8AM', '10AM', '12PM', '2PM', '4PM', '6PM', '8PM'],
                'data' => [12, 45, 32, 67, 89, 54, 78, 23]
            ],
            'payment_methods' => [
                'labels' => ['Cash', 'Card', 'Mobile', 'Other'],
                'data' => [35, 45, 15, 5]
            ]
        ];

        return view('admin.analytics.index', compact('analyticsData'));
    }

    public function settings()
    {
        $settings = [
            'cafe_name' => 'Café Elixir',
            'contact_email' => 'info@cafeelixir.lk',
            'contact_phone' => '+94 77 186 9132',
            'max_reservation_guests' => 20,
            'opening_time' => '06:00',
            'closing_time' => '22:00'
        ];

        return view('admin.settings', compact('settings'));
    }

    // API endpoints for real-time data
    public function getTodayReservations()
    {
        $todayReservations = Reservation::with('user')
            ->whereDate('reservation_date', today())
            ->orderBy('reservation_time')
            ->get();

        $stats = [
            'today_count' => $todayReservations->count(),
            'pending_count' => Reservation::where('status', 'pending')->whereDate('reservation_date', today())->count(),
            'confirmed_count' => Reservation::where('status', 'confirmed')->whereDate('reservation_date', today())->count(),
            'total_guests' => $todayReservations->sum('guests')
        ];

        return response()->json([
            'success' => true,
            'reservations' => $todayReservations,
            'stats' => $stats
        ]);
    }

    public function storeReservation(Request $request)
    {
        $validatedData = $request->validate([
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'reservationDate' => 'required|date|after:today',
            'reservationTime' => 'required|string',
            'guests' => 'required|integer|min:1|max:20',
            'tableType' => 'nullable|string',
            'occasion' => 'nullable|string',
            'specialRequests' => 'nullable|string|max:1000',
            'emailUpdates' => 'nullable|boolean'
        ]);

        $reservationId = 'CE' . str_pad(Reservation::count() + 1, 6, '0', STR_PAD_LEFT);

        $reservation = Reservation::create([
            'reservation_id' => $reservationId,
            'first_name' => $validatedData['firstName'],
            'last_name' => $validatedData['lastName'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'],
            'reservation_date' => $validatedData['reservationDate'],
            'reservation_time' => $validatedData['reservationTime'],
            'guests' => $validatedData['guests'],
            'table_type' => $validatedData['tableType'],
            'occasion' => $validatedData['occasion'],
            'special_requests' => $validatedData['specialRequests'],
            'email_updates' => $validatedData['emailUpdates'] ?? false,
            'user_id' => auth()->id(),
            'status' => 'confirmed'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Reservation confirmed successfully!',
            'reservation_id' => $reservationId,
            'data' => $reservation
        ]);
    }

    public function updateReservationStatus(Request $request, $id)
    {
        $validatedData = $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled'
        ]);

        $reservation = Reservation::findOrFail($id);
        $oldStatus = $reservation->status;
        $reservation->update(['status' => $validatedData['status']]);

        // If reservation is confirmed, award loyalty points to user
        if ($validatedData['status'] === 'confirmed' && $oldStatus !== 'confirmed' && $reservation->user_id) {
            \App\Models\LoyaltyPoint::create([
                'user_id' => $reservation->user_id,
                'points' => 50,
                'type' => 'earned',
                'description' => "Bonus points for confirmed reservation #{$reservation->reservation_id}"
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'Reservation status updated successfully',
            'reservation' => $reservation
        ]);
    }

    public function deleteReservation($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();

        return response()->json([
            'success' => true,
            'message' => 'Reservation deleted successfully'
        ]);
    }

    public function getReservationStats()
    {
        $today = today();
        
        $stats = [
            'today_count' => Reservation::whereDate('reservation_date', $today)->count(),
            'pending_count' => Reservation::where('status', 'pending')->count(),
            'confirmed_count' => Reservation::where('status', 'confirmed')->count(),
            'total_guests' => Reservation::whereDate('reservation_date', $today)->sum('guests'),
            'upcoming_count' => Reservation::where('reservation_date', '>', $today)->count(),
            'this_week_count' => Reservation::whereBetween('reservation_date', [
                $today->startOfWeek(),
                $today->endOfWeek()
            ])->count()
        ];

        return response()->json([
            'success' => true,
            'stats' => $stats
        ]);
    }

    public function getAllReservations(Request $request)
    {
        $query = Reservation::with('user');

        // Apply filters
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        if ($request->has('date') && $request->date !== '') {
            $query->whereDate('reservation_date', $request->date);
        }

        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('reservation_id', 'like', "%{$search}%");
            });
        }

        $reservations = $query->latest('reservation_date')
                             ->latest('reservation_time')
                             ->paginate(20);

        return response()->json([
            'success' => true,
            'reservations' => $reservations
        ]);
    }

    public function getReservation($id)
    {
        $reservation = Reservation::with('user')->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'reservation' => $reservation
        ]);
    }

    // Real-time dashboard data
    public function getDashboardData()
    {
        $stats = [
            'total_users' => User::count(),
            'new_users_today' => User::whereDate('created_at', today())->count(),
            'total_reservations' => Reservation::count(),
            'pending_reservations' => Reservation::where('status', 'pending')->count(),
            'revenue_today' => Order::whereDate('created_at', today())->sum('total'),
            'revenue_month' => Order::whereMonth('created_at', now()->month)->sum('total'),
            'active_orders' => Order::whereIn('status', ['pending', 'confirmed', 'preparing'])->count(),
            'completed_orders_today' => Order::where('status', 'completed')->whereDate('created_at', today())->count(),
        ];

        $recentActivity = [
            'recent_orders' => Order::with('user')->latest()->take(5)->get(),
            'recent_reservations' => Reservation::with('user')->latest()->take(5)->get(),
            'recent_users' => User::latest()->take(5)->get(),
        ];

        return response()->json([
            'success' => true,
            'stats' => $stats,
            'activity' => $recentActivity,
            'timestamp' => now()->toISOString()
        ]);
    }
}