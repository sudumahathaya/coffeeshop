<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\OrderController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Public API routes
Route::prefix('v1')->group(function () {
    // Menu routes
    Route::get('/menu', [MenuController::class, 'index']);
    Route::get('/menu/{id}', [MenuController::class, 'show']);
    Route::get('/menu/category/{category}', [MenuController::class, 'byCategory']);
    Route::get('/menu/featured', [MenuController::class, 'featured']);
    
    // Order routes (public for guest orders)
    Route::post('/orders', [OrderController::class, 'store']);
    Route::get('/orders/{orderId}', [OrderController::class, 'show']);
});

// Protected API routes
Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    // User-specific routes would go here
    Route::get('/user/orders', function (Request $request) {
        return $request->user()->orders()->latest()->get();
    });
    
    Route::get('/user/reservations', function (Request $request) {
        return $request->user()->reservations()->latest()->get();
    });
    
    Route::get('/user/loyalty', function (Request $request) {
        $user = $request->user();
        return [
            'points' => $user->total_loyalty_points,
            'tier' => $user->loyalty_tier
        ];
    });
});