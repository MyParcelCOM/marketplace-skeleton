<?php

declare(strict_types=1);

namespace App\Shops\Http\Controllers;

use Illuminate\Http\Response;
use MyParcelCom\Integration\Configuration\Form\Checkbox;
use MyParcelCom\Integration\Configuration\Form\Form;
use MyParcelCom\Integration\Configuration\Form\Number;
use MyParcelCom\Integration\Configuration\Form\Password;
use MyParcelCom\Integration\Configuration\Form\Select;
use MyParcelCom\Integration\Configuration\Form\Text;
use MyParcelCom\Integration\Configuration\Http\Requests\ConfigureRequest;
use MyParcelCom\Integration\Configuration\Http\Responses\ConfigurationResponse;
use MyParcelCom\Integration\Configuration\Properties\PropertyType;
use MyParcelCom\Integration\Http\Requests\FormRequest;
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

    public function getConfigurationSchema(FormRequest $request): ConfigurationResponse
    {
        // TODO: Build a JSON Schema representation of account configuration settings of a Shop
        //  by instantiating a Form with classes that implement MyParcelCom\Integration\Configuration\Field interface

        // TODO: Fetch the Shop's marketplace settings
        $shopId = $request->shopId();

        // TODO: Build the marketplace settings configuration Form
        $text = new Text(
            name: 'orderPrefix',
            description: 'a description of the order prefix field goes here',
            isRequired: true,
            hint: 'an optional hint for the order prefix field goes here',
        );
        $number = new Number(
            name: 'orderNumberPrefix',
            description: 'a description of the order number prefix field goes here',
        );
        $checkbox = new Checkbox(
            name: 'excludeAmazonOrders',
            description: 'indicates whether orders from Amazon should be excluded from the return portal'
        );
        $select = new Select(
            name: 'defaultShopCurrency',
            type: PropertyType::STRING,
            description: 'default shop currency',
            enum: ['EUR', 'GBP', 'USD'],
        );
        $password = new Password(
            name: 'clientSecret',
            description: 'client secret',
        );
        $form = new Form($text, $number, $checkbox, $select, $password);

        return new ConfigurationResponse($form);
    }

    public function configureAccount(ConfigureRequest $request): Response
    {
        // TODO: Save the shop's configuration settings
        $shopId = $request->shopId();

        return new Response('', Response::HTTP_NO_CONTENT);
    }
}
