<?php

declare(strict_types=1);

namespace App\Shops\Http\Controllers;

use MyParcelCom\Integration\Configuration\Http\Requests\ConfigureRequest;
use MyParcelCom\Integration\Configuration\Http\Responses\ConfigurationResponse;
use MyParcelCom\Integration\Shop\Http\Requests\ShopSetupRequest;
use MyParcelCom\Integration\Shop\Http\Responses\ShopSetupResponse;
use MyParcelCom\Integration\Shop\Http\Responses\ShopTearDownResponse;
use MyParcelCom\JsonSchema\FormBuilder\Form\Checkbox;
use MyParcelCom\JsonSchema\FormBuilder\Form\Form;
use MyParcelCom\JsonSchema\FormBuilder\Form\Number;
use MyParcelCom\JsonSchema\FormBuilder\Form\Option;
use MyParcelCom\JsonSchema\FormBuilder\Form\OptionCollection;
use MyParcelCom\JsonSchema\FormBuilder\Form\Password;
use MyParcelCom\JsonSchema\FormBuilder\Form\Select;
use MyParcelCom\JsonSchema\FormBuilder\Form\Text;
use MyParcelCom\JsonSchema\FormBuilder\Values\Value;
use MyParcelCom\JsonSchema\FormBuilder\Values\ValueCollection;
use Symfony\Component\HttpFoundation\Response;

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
        // TODO:
        //  1. Build a Form of account configuration settings of a Shop
        //  2. Fetch and include the current setting values from the database by populating the `value` property of each field
        //  3. When applicable and no value is already present, set default values by populating the `value` property of each field
        //  For further information on how to construct the configuration Form, see the documentation:
        //   https://github.com/MyParcelCOM/json-schema-form-builder/blob/master/README.md
        $text = new Text(
            name: 'order_prefix',
            label: 'Order prefix',
            isRequired: true,
            help: 'an optional hint for the order prefix field goes here',
            value: 'my_default_prefix_',
        );
        $number = new Number(
            name: 'order_number_prefix',
            label: 'Order number prefix',
        );
        $checkbox = new Checkbox(
            name: 'exclude_amazon_orders',
            label: 'Exclude Amazon orders',
        );
        $select = new Select(
            name: 'default_shop_currency',
            label: 'Default shop currency',
            options: new OptionCollection(
                new Option('EUR', 'EUR'),
                new Option('GBP', 'GBP'),
                new Option('USD', 'USD'),
            ),
        );
        $password = new Password(
            name: 'client_secret',
            label: 'Client secret',
        );
        $form = new Form($text, $number, $checkbox, $select, $password);

        return new ConfigurationResponse($form);
    }

    public function configure(ConfigureRequest $request, string $shopId): Response
    {

        $someShopSetting = $request->getPropertyValue('my_setting');
        $someNestedShopSetting = $request->getPropertyValue('group.nested_setting');

        // TODO: Save the shop's configuration settings to the database

        return new Response('', Response::HTTP_NO_CONTENT);
    }
}
