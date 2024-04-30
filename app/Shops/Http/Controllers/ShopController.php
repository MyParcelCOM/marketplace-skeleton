<?php

declare(strict_types=1);

namespace App\Shops\Http\Controllers;

use MyParcelCom\Integration\Http\Requests\ShopSetupRequest;
use MyParcelCom\Integration\Http\Responses\ShopSetupResponse;
use MyParcelCom\Integration\Http\Responses\ShopTearDownResponse;

class ShopController
{
    public function setUp(string $shopId, ShopSetupRequest $request): ShopSetupResponse
    {
        // TODO: Save the posted settings for this shop in the database. We will need them to query the webshop API.

        // TODO: Does the marketplace require OAuth2? Then you can get the redirect url from the request
        // TODO: and return an authorization URL in the response
        // return new ShopSetupResponse('https://example.com/oauth2/authorize');

        return new ShopSetupResponse();
    }

    public function tearDown(string $shopId): ShopTearDownResponse
    {
        // TODO: Remove any saved settings for this shop from the database.

        return new ShopTearDownResponse();
    }
}
