<?php

namespace App\Http\Controllers\Api\BusinessOwner;

use App\Enums\OrderStatus;
use App\Enums\Role;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\User;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class OrderController extends Controller
{
    public function __construct(protected OrderService $orderService)
    {
    }

    public function index(): AnonymousResourceCollection
    {
        $orders = $this->orderService->getOrdersWithStatus([OrderStatus::Pending]);

        return OrderResource::collection($orders);
    }

    public function pickedOrders(): AnonymousResourceCollection
    {
        $orders = $this->orderService->getOrdersWithStatus([OrderStatus::Picked]);

        return OrderResource::collection($orders);
    }

    public function assignToPicker(Order $order, User $picker): JsonResponse
    {
        if (!$picker->hasRole(Role::Picker)) {
            return $this->errorResponse("User should be a picker");
        }

        if ($picker->assignedOrders()->count() >= $picker->picker_orders_capacity) {
            return $this->errorResponse("not available picker");
        }

        $this->orderService->assignOrderToPicker($order, $picker);

        return $this->successResponse([]);
    }
}
