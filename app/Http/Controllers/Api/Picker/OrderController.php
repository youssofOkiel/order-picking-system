<?php

namespace App\Http\Controllers\Api\Picker;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Services\OrderService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class OrderController extends Controller
{
    public function __construct(protected OrderService $orderService)
    {
    }

    public function index(): AnonymousResourceCollection
    {
        $picker = auth()->user();
        $orders = $this->orderService->getAssignedOrdersForPicker($picker);

        return OrderResource::collection($orders);
    }
}
