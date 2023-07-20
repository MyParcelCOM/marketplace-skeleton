<?php

declare(strict_types=1);

namespace App\Shops\Http\Controllers;

use App\Shops\Http\Requests\ShopRequest;
use Illuminate\Http\Response;

class ShopController
{
    public function setUp(string $shopId, ShopRequest $request): Response
    {
        // TODO: Save the posted settings for this shop in the database. We will need them to query the webshop API.

        return new Response('', Response::HTTP_NO_CONTENT);
    }

    public function tearDown(string $shopId): Response
    {
        // TODO: Remove any saved settings for this shop from the database.

        return new Response('', Response::HTTP_NO_CONTENT);
    }
}
