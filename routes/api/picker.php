<?php

use App\Enums\Role;
use App\Http\Controllers\Api\Picker\OrderController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'role:' . Role::Picker])->prefix('pickers')->group(function () {
    Route::get('orders', [OrderController::class, 'index']);
//    Route::get('orders/{order}/pickers/{picker}', [OrderController::class, 'assignToPicker']);
});