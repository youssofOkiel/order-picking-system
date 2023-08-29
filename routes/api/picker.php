<?php

use App\Enums\Role;
use App\Http\Controllers\Api\Picker\GetBestRoute;
use App\Http\Controllers\Api\Picker\OrderController;
use App\Http\Controllers\Api\Picker\OrderProductController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'role:' . Role::Picker])->prefix('pickers')->group(function () {

    Route::get('orders', [OrderController::class, 'index']);
    Route::get('orders/{order}/products', [OrderProductController::class, 'assignedOrderProducts']);
    Route::get('orders/{order}/pick/{product}', [OrderProductController::class, 'pickOrderProduct']);
    Route::get('orders/{order}/best-picking-route', GetBestRoute::class);
});
