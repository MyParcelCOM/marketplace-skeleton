<?php

declare(strict_types=1);

namespace App\Statuses\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use MyParcelCom\Integration\Shipment\Http\Requests\ShipmentStatusCallbackRequest;

class ShipmentStatusCallbackController
{
    public function post(ShipmentStatusCallbackRequest $request): JsonResponse
    {
        $shopId = $request->shopId();

        $statusData = $request->getStatusData();
        $shipmentData = $request->getShipmentData();
        $trackingCode = Arr::get($shipmentData, 'attributes.tracking_code');

        // TODO Here you can start incorporating logic to update the remote API with the status data

        return response()->json();
    }
}
