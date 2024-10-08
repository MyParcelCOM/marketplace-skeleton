<?php

declare(strict_types=1);

use App\Orders\Http\Controllers\OrderController;
use App\Shops\Http\Controllers\ShopController;
use App\Shipments\Http\Controllers\ShipmentController;
use App\Statuses\Http\Controllers\ShipmentStatusCallbackController;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => new JsonResponse([
    'meta' => [
        'title'  => 'MyParcel.com ' . config('app.name') . ' (' . config('app.channel') . ')',
        'status' => 'OK',
    ],
]));

Route::post('/shops/{shop_id}/setup', [ShopController::class, 'setUp'])
    ->name('shop-setup');
Route::post('/shops/{shop_id}/teardown', [ShopController::class, 'tearDown'])
    ->name('shop-teardown');

Route::get('/shipments', [ShipmentController::class, 'get'])
    ->name('get-shipments')
    ->middleware('transform_many_to_json_api');

Route::post('/callback/shipment-statuses', [ShipmentStatusCallbackController::class, 'post'])
    ->name('shipment-statuses')
    ->middleware('matching_channel_only:' . config('app.channel'));

Route::get('/orders/count', [OrderController::class, 'getCount'])
    ->name('get-orders-count');
Route::get('/orders/{order_id}', [OrderController::class, 'get'])
    ->name('get-order')
    ->middleware('transform_one_to_json_api');

Route::get('/shops/{shopId}/configuration', [ShopController::class, 'getConfiguration']);
Route::post('/shops/{shopId}/configure', [ShopController::class, 'configure']);
