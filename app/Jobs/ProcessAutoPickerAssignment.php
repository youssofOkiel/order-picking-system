<?php

namespace App\Jobs;

use App\Enums\AssignmentStatus;
use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\User;
use App\Services\OrderService;
use App\Services\RouteCalculatorService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessAutoPickerAssignment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // I will use patching order picking method to assign orders to pickers
        Order::query()
            ->status([OrderStatus::Pending, OrderStatus::UnavailableProduct])
            ->orderBy('priority')
            ->chunk(10, function ($orders) {
                foreach ($orders as $order) {
                    $availablePicker = User::query()
                        ->picker()
                        ->whereDoesntHave('assignedOrders', function ($query) {
                            $query->whereIn('status', [AssignmentStatus::Completed]);
                        })
                        ->withCount('assignedOrders')
                        ->having('assigned_orders_count', '<', config('picker.order_capacity'))
                        ->first();

                    if ($availablePicker) {
                        app(OrderService::class)->assignOrderToPicker($order, $availablePicker);
                    }
                }
            });
    }
}
