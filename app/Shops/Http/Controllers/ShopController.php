<?php

declare(strict_types=1);

namespace App\Shops\Http\Controllers;

use Illuminate\Http\Response;
use MyParcelCom\Integration\Configuration\Form\Form;
use MyParcelCom\Integration\Configuration\Http\Requests\ConfigureRequest;
use MyParcelCom\Integration\Configuration\Http\Responses\ConfigurationResponse;
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

    public function getAccountConfigurationSchema(string $shopId): ConfigurationResponse
    {
        // TODO: Build a JSON Schema representation of account configuration settings of a Shop
        //  by instantiating a Form with classes that implement MyParcelCom\Integration\Configuration\Field interface

        $form = new Form(/* Field instances go here */);

        return new ConfigurationResponse($form);
    }

    public function configureAccount(ConfigureRequest $request, string $shopId): Response
    {
        // TODO: Save the shop's account configuration settings

        return new Response('', Response::HTTP_NO_CONTENT);
    }
}
