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
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


Route::post('/reservation', [HomeController::class, 'storeReservation'])->name('reservation.store');

Route::post('/newsletter/subscribe', [HomeController::class, 'subscribeNewsletter'])->name('newsletter.subscribe');
Route::get('/blog/{slug}', [HomeController::class, 'showBlogPost'])->name('blog.show');

Route::post('/contact', [HomeController::class, 'storeContact'])->name('contact.store');
Route::get('/business-status', [HomeController::class, 'getBusinessStatus'])->name('business.status');
