<?php

namespace App\Services;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class OrderService
{
    public function getOrdersWithStatus(array $statuses)
    {
        return Order::query()
            ->with('pickerAssignment')
            ->status($statuses)
            ->get();
    }

    public function getAssignedOrdersForPicker($picker)
    {
        return $picker->assignedOrders()->with('order.products.location')->get();
    }

    public function assignOrderToPicker(Order $order, User $picker): bool|Model
    {
        if ($order->pickerAssignment()->exists()){
            return false;
        }

        return $order->pickerAssignment()->create([
            'picker_id' => $picker->id,
        ]);
    }
}
