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
use MyParcelCom\Integration\Configuration\Values\Value;
use MyParcelCom\Integration\Configuration\Values\ValueCollection;
use MyParcelCom\Integration\Shop\Http\Requests\ShopSetupRequest;
use MyParcelCom\Integration\Shop\Http\Responses\ShopSetupResponse;
use MyParcelCom\Integration\Shop\Http\Responses\ShopTearDownResponse;

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

    public function getConfiguration(string $shopId): ConfigurationResponse
    {
        // TODO: Build a Form of account configuration settings of a Shop
        //  Fetch and include the current setting values

        // TODO: Fetch the Shop's marketplace settings

        // TODO: Build the marketplace settings configuration Form
        $text = new Text(
            name: 'orderPrefix',
            label: 'Order prefix',
            isRequired: true,
            help: 'an optional hint for the order prefix field goes here',
        );
        $number = new Number(
            name: 'orderNumberPrefix',
            label: 'Order number prefix',
        );
        $checkbox = new Checkbox(
            name: 'excludeAmazonOrders',
            label: 'Exclude Amazon orders',
        );
        $select = new Select(
            name: 'defaultShopCurrency',
            type: PropertyType::STRING,
            label: 'Default shop currency',
            enum: ['EUR', 'GBP', 'USD'],
        );
        $password = new Password(
            name: 'clientSecret',
            label: 'Client secret',
        );
        $form = new Form($text, $number, $checkbox, $select, $password);

        // TODO: Get current setting values from the db and include them in the response
        $values = new ValueCollection(
            new Value('orderPrefix', 'myparcelcom_'),
        );

        return new ConfigurationResponse($form, $values);
    }

    public function configure(ConfigureRequest $request): Response
    {
        // TODO: Save the shop's configuration settings
        $shopId = $request->shopId();

        return new Response('', Response::HTTP_NO_CONTENT);
    }
}
