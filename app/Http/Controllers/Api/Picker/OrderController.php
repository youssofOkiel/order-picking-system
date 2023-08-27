<?php

namespace App\Http\Controllers\Api\Picker;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class OrderController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $orders = auth()->user()->assignedOrders()->with('order.products')->get();

        return OrderResource::collection($orders);
    }
}
