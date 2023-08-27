<?php

use App\Http\Controllers\Api\BusinessOwner\OrderController;
use App\Http\Controllers\Api\BusinessOwner\PickerAssignmentController;
use Illuminate\Support\Facades\Route;

Route::prefix('business-owners')->group(function () {
    Route::get('pickers', [PickerAssignmentController::class, 'index']);

    Route::get('orders', [OrderController::class, 'index']);
    Route::get('orders/{order}/pickers/{picker}', [OrderController::class, 'assignToPicker']);
});
