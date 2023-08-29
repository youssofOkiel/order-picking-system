<?php

namespace App\Jobs;

use App\Enums\OrderStatus;
use App\Enums\TimeSlotStatus;
use App\Models\Order;
use App\Models\TimeSlot;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessAssignOrderToNearestTimeSlot implements ShouldQueue
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
            ->status([OrderStatus::Picked])
            ->orderBy('priority')
            ->chunk(10, function ($orders) {
                foreach ($orders as $order) {
                    $timeSlot = TimeSlot::query()
                        ->status([TimeSlotStatus::Available])
                        ->orderBy('start_time')
                        ->first();

                    if ($timeSlot) {
                        $order->update([
                            'time_slot_id' => $timeSlot->getKey()
                        ]);
                    }
                }
            });
    }
}
