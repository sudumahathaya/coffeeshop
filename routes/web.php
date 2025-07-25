<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// Home route (replaces Laravel welcome page)
Route::get('/', [HomeController::class, 'index'])->name('home');

// Additional pages
Route::get('/menu', [HomeController::class, 'menu'])->name('menu');
Route::get('/reservation', [HomeController::class, 'reservation'])->name('reservation');
Route::get('/blog', [HomeController::class, 'blog'])->name('blog');
Route::get('/features', [HomeController::class, 'features'])->name('features');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

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
});
