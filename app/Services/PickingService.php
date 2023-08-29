<?php

namespace App\Services;

use App\Enums\OrderStatus;
use App\Models\Assignment;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;

class PickingService
{
    public function getBestPickingRoute($picker, Assignment $assignedOrder)
    {
        $orderProductsLocation = $assignedOrder->order->products->transform(function ($product) {
            // The product may be located in more than one place according to warehouse
            // or zones or there are many of it. so lets take the first one just for now
            // but we can optimize this according to business model
            return $product->location->first()->coordinates;
        })->toArray();

        return app(RouteCalculatorService::class)->calculateRoute($picker->location->coordinates, $orderProductsLocation);
    }

    public function pickProduct(Order $order, Product $product)
    {
        $productIncludedInOrder = OrderProduct::query()
            ->with('order.pickerAssignment.picker', 'product')
            ->where('order_id', $order->getKey())
            ->where('product_id', $product->getKey())
            ->whereNot('status', [OrderStatus::Picked])
            ->first();

        if (!$productIncludedInOrder) {
            return false;
        }

        $product = $productIncludedInOrder->product;
        if ($product->quantity < $productIncludedInOrder->quantity) {
            $productIncludedInOrder->update([
                'status' => OrderStatus::UnavailableProduct
            ]);

            return false;
        }

        $productIncludedInOrder->update([
            'status' => OrderStatus::Picked
        ]);

        $product->update([
            'quantity' => $product->quantity - $productIncludedInOrder->quantity
        ]);

        OrderProduct::query()
            ->where('order_id', $order->getKey())
            ->where('product_id', $product->getKey())
            ->first();

        return true;
    }
}
