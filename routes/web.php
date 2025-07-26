<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileChangeController;
use App\Http\Controllers\ReservationChangeController;
use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\AdminReservationChangeController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/menu', [HomeController::class, 'menu'])->name('menu');
Route::get('/reservation', [HomeController::class, 'reservation'])->name('reservation');
Route::get('/blog', [HomeController::class, 'blog'])->name('blog');
Route::get('/features', [HomeController::class, 'features'])->name('features');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

// Contact form submission
Route::post('/contact', [HomeController::class, 'storeContact'])->name('contact.store');

// Newsletter subscription
Route::post('/newsletter/subscribe', [HomeController::class, 'subscribeNewsletter'])->name('newsletter.subscribe');

// Reservation submission
Route::post('/reservation', [HomeController::class, 'storeReservation'])->name('reservation.store');

// Business status API
Route::get('/api/business-status', [HomeController::class, 'getBusinessStatus'])->name('api.business-status');

// Authentication routes
require __DIR__.'/auth.php';

// Authenticated user routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', function () {
        return view('profile.index');
    })->name('profile.view');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // User orders
    Route::get('/user/orders', [UserController::class, 'orders'])->name('user.orders');
    Route::get('/user/order-history', [UserController::class, 'getOrderHistory'])->name('user.order-history');
    Route::post('/user/reorder-last', [UserController::class, 'reorderLast'])->name('user.reorder-last');
    Route::get('/user/loyalty', [UserController::class, 'getLoyaltyDetails'])->name('user.loyalty');
    Route::get('/user/reservation-updates', [UserController::class, 'getReservationUpdates'])->name('user.reservation-updates');
    Route::post('/user/update-profile', [UserController::class, 'updateProfile'])->name('user.update-profile');
    
    // Profile change requests
    Route::post('/profile-change-requests', [ProfileChangeController::class, 'store'])->name('profile-change-requests.store');
    Route::get('/profile-change-requests/pending', [ProfileChangeController::class, 'getUserPendingRequest'])->name('profile-change-requests.pending');
    Route::delete('/profile-change-requests/{id}', [ProfileChangeController::class, 'cancelRequest'])->name('profile-change-requests.cancel');
    
    // Reservation change requests
    Route::post('/reservation-change-requests/{reservationId}', [ReservationChangeController::class, 'store'])->name('reservation-change-requests.store');
    Route::get('/reservation-change-requests/{reservationId}/status', [ReservationChangeController::class, 'getReservationPendingRequest'])->name('reservation-change-requests.status');
    Route::delete('/reservation-change-requests/{id}', [ReservationChangeController::class, 'cancelRequest'])->name('reservation-change-requests.cancel');
    
    // Direct reservation management for users
    Route::delete('/user/reservations/{id}/cancel', function($id) {
        $reservation = \App\Models\Reservation::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();
        
        if (!$reservation) {
            return response()->json([
                'success' => false,
                'message' => 'Reservation not found or you do not have permission to cancel it.'
            ], 404);
        }
        
        if ($reservation->status === 'cancelled') {
            return response()->json([
                'success' => false,
                'message' => 'This reservation is already cancelled.'
            ], 400);
        }
        
        $reservation->update(['status' => 'cancelled']);
        
        return response()->json([
            'success' => true,
            'message' => 'Reservation cancelled successfully'
        ]);
    })->name('user.reservations.cancel');
});

// Menu API routes
Route::get('/admin/menu', [MenuController::class, 'index'])->name('admin.menu.index');
Route::post('/admin/menu', [MenuController::class, 'store'])->name('admin.menu.store');
Route::get('/admin/menu/{id}', [MenuController::class, 'show'])->name('admin.menu.show');
Route::put('/admin/menu/{id}', [MenuController::class, 'update'])->name('admin.menu.update');
Route::patch('/admin/menu/{id}/toggle-status', [MenuController::class, 'toggleStatus'])->name('admin.menu.toggle-status');
Route::delete('/admin/menu/{id}', [MenuController::class, 'destroy'])->name('admin.menu.destroy');

// Order routes
Route::post('/api/orders', [OrderController::class, 'store'])->name('api.orders.store');
Route::get('/api/orders/{orderId}', [OrderController::class, 'show'])->name('api.orders.show');
Route::get('/admin/api/orders', [OrderController::class, 'index'])->name('admin.api.orders');
Route::patch('/admin/orders/{orderId}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.update-status');

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/reservations', [AdminController::class, 'reservations'])->name('reservations');
    Route::get('/orders', [AdminController::class, 'orders'])->name('orders');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/menu', [AdminController::class, 'menuManagement'])->name('menu');
    Route::get('/analytics', [AdminController::class, 'analytics'])->name('analytics');
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
    
    // User management
    Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
    Route::get('/users/{id}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{id}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('users.destroy');
    Route::get('/users/{id}/stats', [AdminController::class, 'getUserStats'])->name('users.stats');
    
    // Reservation management
    Route::post('/reservations', [AdminController::class, 'storeReservation'])->name('reservations.store');
    Route::patch('/reservations/{id}/status', [AdminController::class, 'updateReservationStatus'])->name('reservations.update-status');
    Route::delete('/reservations/{id}', [AdminController::class, 'deleteReservation'])->name('reservations.destroy');
    Route::get('/reservations/{id}', [AdminController::class, 'getReservation'])->name('reservations.show');
    
    // API endpoints for real-time data
    Route::get('/api/reservations', [AdminController::class, 'getAllReservations'])->name('api.reservations');
    Route::get('/api/reservation-stats', [AdminController::class, 'getReservationStats'])->name('api.reservation-stats');
    Route::get('/api/today-reservations', [AdminController::class, 'getTodayReservations'])->name('api.today-reservations');
    Route::get('/api/dashboard-data', [AdminController::class, 'getDashboardData'])->name('api.dashboard-data');
    
    // Profile change requests management
    Route::get('/profile-requests', [AdminProfileController::class, 'index'])->name('profile-requests.index');
    Route::get('/profile-requests/{id}', [AdminProfileController::class, 'show'])->name('profile-requests.show');
    Route::post('/profile-requests/{id}/approve', [AdminProfileController::class, 'approve'])->name('profile-requests.approve');
    Route::post('/profile-requests/{id}/reject', [AdminProfileController::class, 'reject'])->name('profile-requests.reject');
    Route::get('/profile-requests/pending-count', [AdminProfileController::class, 'getPendingCount'])->name('profile-requests.pending-count');
    
    // Reservation change requests management
    Route::get('/reservation-requests', [AdminReservationChangeController::class, 'index'])->name('reservation-requests.index');
    Route::get('/reservation-requests/{id}', [AdminReservationChangeController::class, 'show'])->name('reservation-requests.show');
    Route::post('/reservation-requests/{id}/approve', [AdminReservationChangeController::class, 'approve'])->name('reservation-requests.approve');
    Route::post('/reservation-requests/{id}/reject', [AdminReservationChangeController::class, 'reject'])->name('reservation-requests.reject');
    Route::get('/reservation-requests/pending-count', [AdminReservationChangeController::class, 'getPendingCount'])->name('reservation-requests.pending-count');
});