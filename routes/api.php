<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\DriverController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('driver/login', [AuthController::class, 'login'])->middleware('throttle:api');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('driver/logout', [AuthController::class, 'logout']);
        Route::get('driver/orders', [DriverController::class, 'orders']);
        Route::patch('driver/orders/{order}/status', [DriverController::class, 'updateOrderStatus']);
        Route::post('driver/work-sessions/start', [DriverController::class, 'startSession']);
        Route::post('driver/work-sessions/{session}/end', [DriverController::class, 'endSession']);
        Route::post('driver/location', [DriverController::class, 'location']);
    });
});