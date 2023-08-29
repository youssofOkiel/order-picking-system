<?php

namespace App\Jobs;

use App\Enums\OrderStatus;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessCheckCompletedOrder implements ShouldQueue
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
        Order::query()
            ->with('products')
            ->status([OrderStatus::Assigned])
            ->orderBy('priority')
            ->chunk(10, function ($orders) {
                foreach ($orders as $order) {
                    $completed = true;
                    foreach ($order->products as $product) {
                        if ($product->pivot->status != OrderStatus::Picked) {
                            $completed = false;
                        }
                    }

                    if ($completed) {
                        $order->update([
                            'status' => OrderStatus::Picked
                        ]);
                    }
                }
            });
    }
}
