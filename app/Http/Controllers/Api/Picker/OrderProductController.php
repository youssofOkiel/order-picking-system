<?php

namespace App\Http\Controllers\Api\Picker;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Http\Resources\ProductResource;
use App\Models\Assignment;
use App\Models\Order;
use App\Models\Product;
use App\Services\OrderService;
use App\Services\PickingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;

class OrderProductController extends Controller
{
    public function __construct(
        protected OrderService   $orderService,
        protected PickingService $pickingService
    )
    {
    }

    public function assignedOrderProducts(Assignment $order): JsonResponse|AnonymousResourceCollection
    {
        if ($order->picker->id != auth()->id()) {
            return $this->errorResponse("Order Not Found!");
        }

        $products = $this->orderService->getOrderProducts($order);

        return ProductResource::collection($products);
    }

    public function pickOrderProduct(Order $order, Product $product): JsonResponse
    {
        $isPicked = DB::transaction(function () use ($order, $product) {
            return $this->pickingService->pickProduct($order, $product);
        });

        if (!$isPicked) {
            // we can provide more clear message according to actual order status
            return $this->errorResponse("Invalid product Or Unavailable product");
        }

        return $this->successResponse([]);
    }
}
