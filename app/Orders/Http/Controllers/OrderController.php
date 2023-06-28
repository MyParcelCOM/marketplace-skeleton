<?php

declare(strict_types=1);

namespace App\Orders\Http\Controllers;

use App\Orders\Http\Requests\OrderRequest;
use Carbon\Carbon;
use MyParcelCom\Integration\Address;
use MyParcelCom\Integration\Order\Items\Item;
use MyParcelCom\Integration\Order\Items\ItemCollection;
use MyParcelCom\Integration\Order\Order;
use MyParcelCom\Integration\ProvidesJsonAPI;

class OrderController
{
    public function get(string $orderId, OrderRequest $request): ProvidesJsonAPI
    {
        // TODO Shop UUID is always provided and you should use it to distinguish
        // TODO between different auth sessions
        $shopId = $request->shopId();

        // TODO Use the access token to connect to the remote API from where orders are fetched
        $accessToken = $request->token();

        // TODO Here you can start incorporating logic that gets the order from the remote API

        // TODO Finally, you are expected to return an Order object
        return new Order(
            shopId: $shopId,
            id: $orderId,
            createdAt: Carbon::now(),
            recipientAddress: new Address(
                street1: 'Baker St',
                city: 'London',
                countryCode: 'GB',
                firstName: 'Sherlock',
                lastName: 'Holmes',
                streetNumber: 221,
                streetNumberSuffix: 'b',
                postalCode: 'NW1 6XE',
                company: '',
            ),
            items: new ItemCollection(
                new Item(
                    name: 'The Adventures of Sherlock Holmes',
                    description: 'A collection of twelve short stories by Arthur Conan Doyle.',
                    quantity: 1,
                ),
                new Item(
                    name: 'The Memoirs of Sherlock Holmes',
                    description: 'A collection of Sherlock Holmes stories by Arthur Conan Doyle.',
                    quantity: 1,
                ),
            )
        );
    }
}
