<?php

namespace App\Http\Controllers\Api\Picker;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Services\PickingService;

class GetBestRoute extends Controller
{
    public function __construct(protected PickingService $pickingService)
    {
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(Assignment $order)
    {
        if (!$order->where('picker_id', auth()->id())->exists()) {
            return $this->errorResponse("invalid order id");
        }
        $picker = auth()->user();
        $route = $this->pickingService->getBestPickingRoute($picker, $order);

        return $this->successResponse([
            'picking_route' => $route
        ]);
    }
}
