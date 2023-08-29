<?php

namespace App\Observers;

use App\Enums\AssignmentStatus;
use App\Enums\OrderStatus;
use App\Enums\TimeSlotStatus;
use App\Models\Order;

class OrderObserver
{
    /**
     * Handle the Order "created" event.
     */
    public function created(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "updated" event.
     */
    public function updated(Order $order): void
    {
        if ($order->status == OrderStatus::Picked) {
            $order->pickerAssignment()->update([
                'status' => AssignmentStatus::Completed
            ]);
        }

        if ($order->timeSlot?->orders()->count() == config('delivery-timeslot.slot_capacity')) {
            $order->timeSlot->update([
                'status' => TimeSlotStatus::Unavailable
            ]);
        }
    }

    /**
     * Handle the Order "deleted" event.
     */
    public function deleted(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "restored" event.
     */
    public function restored(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "force deleted" event.
     */
    public function forceDeleted(Order $order): void
    {
        //
    }
}
