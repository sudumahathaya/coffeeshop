<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

// Home route (replaces Laravel welcome page)
Route::get('/', [HomeController::class, 'index'])->name('home');

// Additional pages
Route::get('/menu', [HomeController::class, 'menu'])->name('menu');
Route::get('/reservation', [HomeController::class, 'reservation'])->name('reservation');
Route::get('/blog', [HomeController::class, 'blog'])->name('blog');
Route::get('/features', [HomeController::class, 'features'])->name('features');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

// API Routes for frontend
Route::prefix('api')->group(function () {
    Route::get('/menu', [MenuController::class, 'index']);
    Route::get('/menu/{id}', [MenuController::class, 'show']);
    Route::post('/orders', [OrderController::class, 'store']);
    Route::get('/orders/{orderId}', [OrderController::class, 'show']);
});

Route::get('/dashboard', function () {
    return view('user.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile/view', function () {
        return view('profile.index');
    })->name('profile.view');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // User Dashboard Routes
    Route::get('/my-orders', [App\Http\Controllers\UserController::class, 'orders'])->name('user.orders');
    Route::get('/user/profile/update', [App\Http\Controllers\UserController::class, 'updateProfile'])->name('user.profile.update');
    Route::get('/user/orders/history', [App\Http\Controllers\UserController::class, 'getOrderHistory'])->name('user.orders.history');
    Route::post('/user/reorder-last', [App\Http\Controllers\UserController::class, 'reorderLast'])->name('user.reorder.last');
    Route::get('/user/loyalty/details', [App\Http\Controllers\UserController::class, 'getLoyaltyDetails'])->name('user.loyalty.details');
    Route::get('/api/user/reservations/status', [App\Http\Controllers\UserController::class, 'getReservationUpdates'])->name('user.reservations.updates');
    
    // Order management for authenticated users
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{orderId}', [OrderController::class, 'show'])->name('orders.show');
});

require __DIR__.'/auth.php';


Route::post('/reservation', [HomeController::class, 'storeReservation'])->name('reservation.store');

Route::post('/newsletter/subscribe', [HomeController::class, 'subscribeNewsletter'])->name('newsletter.subscribe');
Route::get('/blog/{slug}', [HomeController::class, 'showBlogPost'])->name('blog.show');

Route::post('/contact', [HomeController::class, 'storeContact'])->name('contact.store');
Route::get('/business-status', [HomeController::class, 'getBusinessStatus'])->name('business.status');

// Admin Routes
Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [App\Http\Controllers\AdminController::class, 'users'])->name('users');
    Route::get('/reservations', [App\Http\Controllers\AdminController::class, 'reservations'])->name('reservations');
    Route::get('/orders', [App\Http\Controllers\AdminController::class, 'orders'])->name('orders');
    Route::get('/menu-management', [App\Http\Controllers\AdminController::class, 'menuManagement'])->name('menu.management');
    Route::get('/analytics', [App\Http\Controllers\AdminController::class, 'analytics'])->name('analytics');
    Route::get('/settings', [App\Http\Controllers\AdminController::class, 'settings'])->name('settings');
    
    // Real-time API endpoints
    Route::get('/api/today-reservations', [App\Http\Controllers\AdminController::class, 'getTodayReservations'])->name('api.today-reservations');
    Route::get('/api/reservation-stats', [App\Http\Controllers\AdminController::class, 'getReservationStats'])->name('api.reservation-stats');
    Route::get('/api/reservations', [App\Http\Controllers\AdminController::class, 'getAllReservations'])->name('api.reservations');
    
    // Reservation management
    Route::post('/reservations', [App\Http\Controllers\AdminController::class, 'storeReservation'])->name('reservations.store');
    Route::get('/reservations/{id}', [App\Http\Controllers\AdminController::class, 'getReservation'])->name('reservations.show');
    Route::patch('/reservations/{id}/status', [App\Http\Controllers\AdminController::class, 'updateReservationStatus'])->name('reservations.update-status');
    Route::delete('/reservations/{id}', [App\Http\Controllers\AdminController::class, 'deleteReservation'])->name('reservations.delete');
    
    // Admin menu management
    Route::post('/menu', [MenuController::class, 'store'])->name('menu.store');
    Route::get('/menu/{id}', [MenuController::class, 'show'])->name('menu.show');
    Route::put('/menu/{id}', [MenuController::class, 'update'])->name('menu.update');
    Route::delete('/menu/{id}', [MenuController::class, 'destroy'])->name('menu.destroy');
    Route::patch('/menu/{id}/toggle-status', [MenuController::class, 'toggleStatus'])->name('menu.toggle-status');
    
    // Admin order management
    Route::patch('/orders/{orderId}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::get('/api/orders', [OrderController::class, 'index'])->name('api.orders');
    
    // User management
    Route::get('/users/create', [App\Http\Controllers\AdminController::class, 'createUser'])->name('users.create');
    Route::post('/users', [App\Http\Controllers\AdminController::class, 'storeUser'])->name('users.store');
    Route::get('/users/{id}/edit', [App\Http\Controllers\AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{id}', [App\Http\Controllers\AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{id}', [App\Http\Controllers\AdminController::class, 'deleteUser'])->name('users.delete');
    Route::get('/users/{id}/stats', [App\Http\Controllers\AdminController::class, 'getUserStats'])->name('users.stats');
    
    // Real-time dashboard data
    Route::get('/api/dashboard-data', [App\Http\Controllers\AdminController::class, 'getDashboardData'])->name('api.dashboard-data');
});

// Payment API routes
Route::prefix('api/payment')->middleware('auth')->group(function () {
    Route::post('/create-intent', function (Illuminate\Http\Request $request) {
        $paymentService = new App\Services\PaymentService();
        $result = $paymentService->createPaymentIntent($request->amount);
        return response()->json($result);
    });
    
    Route::post('/mobile', function (Illuminate\Http\Request $request) {
        // Simulate mobile payment processing
        return response()->json([
            'success' => true,
            'transaction_id' => 'MOB' . time(),
            'message' => 'Mobile payment initiated'
        ]);
    });
});
