<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\OrderController;

// Public Routes (No Authentication Required)
Route::post('/login', [AuthController::class, 'login'])->name('login');

// Protected Routes (Requires Authentication)
Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [AuthController::class, 'profile']);
    
    // Order Routes (Only Authenticated Users Can Access)

    Route::post('/orders', [OrderController::class, 'store']);
    Route::post('/checkout', [OrderController::class, 'store']);
});
