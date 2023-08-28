<?php

namespace App\Services;

use App\Models\Assignment;

class PickingService
{
    public function getBestPickingRoute($picker,Assignment $assignedOrder)
    {
        $orderProductsLocation = $assignedOrder->order->products->transform(function ($product){
            // The product may be located in more than one place according to warehouse
            // or zones or there are many of it. so lets take the first one just for now
            // but we can optimize this according to business model
            return $product->location->first()->coordinates;
        })->toArray();

       return app(RouteCalculatorService::class)->calculateRoute($picker->location->coordinates, $orderProductsLocation);
    }
}
