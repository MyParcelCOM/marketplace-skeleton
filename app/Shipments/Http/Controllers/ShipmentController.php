<?php

declare(strict_types=1);

namespace App\Shipments\Http\Controllers;

use Carbon\Carbon;
use MyParcelCom\Integration\Address;
use MyParcelCom\Integration\Http\Requests\ShipmentRequest;
use MyParcelCom\Integration\PhysicalProperties;
use MyParcelCom\Integration\Price;
use MyParcelCom\Integration\Shipment\Items\Item;
use MyParcelCom\Integration\Shipment\Items\ItemCollection;
use MyParcelCom\Integration\Shipment\Shipment;

class ShipmentController
{
    /**
     * @return array{
     *     items: Shipment[],
     *     total_records: int,
     *     total_pages: int
     * }
     */
    public function get(ShipmentRequest $request): array
    {
        // TODO Shop UUID is always provided and you should use it to distinguish
        // TODO between different auth sessions
        $shopId = $request->shopId();

        // TODO Use $request->startDate() and $request->endDate() to obtain the request date range for the orders
        $startDate = $request->startDate();
        $endDate = $request->endDate();

        // TODO use the number and size as pagination for the integration
        $pageNumber = $request->pageNumber();
        $pageSize = $request->pageSize();

        // TODO if the integration is configured to use an offset, calculate it here
        $offset = $this->pageOffset($pageNumber, $pageSize);

        // TODO Here you can start incorporating logic that converts orders from the remote API into Shipment objects
        // Use the Shipment object to represent orders as shipments
        $items = [
            // This is an example shipment
            new Shipment(
                shopId: $shopId,
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
                    email: 'sherlock@holmes.com',
                    phoneNumber: '+123456789',
                ),
                description: 'Google Chromecast Ultra',
                customerReference: '#1234567890',
                channel: config('app.channel'),
                totalValue: new Price(4000, 'EUR'),
                price: new Price(4000, 'EUR'), // amount is in cents
                physicalProperties: new PhysicalProperties(
                    weight: 500,
                    height: 30,
                    width: 20,
                    length: 25,
                ),
                items: new ItemCollection(
                    new Item(
                        description: 'A google chromecast with 4K support',
                        quantity: 1,
                        sku: '',
                        itemValue: new Price(4000, 'EUR'),
                        hsCode: '',
                        itemWeight: 500,
                        originCountryCode: 'US',
                    ),
                ),
                createdAt: Carbon::createFromTimeString('2020-01-01 12:30:00'),
            ),
            // This is another example shipment
            new Shipment(
                shopId: $shopId,
                recipientAddress: new Address(
                    street1: 'Bell St',
                    city: 'London',
                    countryCode: 'GB',
                    firstName: 'James',
                    lastName: 'Bond',
                    streetNumber: 27,
                    postalCode: 'NW1 5BY',
                    email: 'james@bond.com',
                    phoneNumber: '+123456789',
                ),
                description: 'Google Stadia Controller',
                customerReference: '#XYZ12345',
                channel: config('app.channel'),
                totalValue: new Price(80000, 'GBP'),
                price: new Price(80000, 'GBP'),
                physicalProperties: new PhysicalProperties(
                    weight: 2500,
                    height: 300,
                    width: 100,
                    length: 100,
                ),
                items: new ItemCollection(
                    new Item(
                        description: 'Game controller',
                        quantity: 1,
                        sku: '',
                        itemValue: new Price(80000, 'GBP'),
                        hsCode: '',
                        itemWeight: 2500,
                        originCountryCode: 'US',
                    ),
                ),
                createdAt: Carbon::createFromTimeString('2020-01-13 20:10:00'),
            ),
        ];

        // TODO this is the total number of orders for all pages
        $totalOrders = 123;

        return [
            'items'         => $items,
            'total_records' => $totalOrders,
            'total_pages'   => (int) ceil($totalOrders / $pageSize),
        ];
    }

    /**
     * @param int|null $pageNumber
     * @param int|null $pageSize
     * @return int|null
     */
    private function pageOffset(?int $pageNumber, ?int $pageSize): ?int
    {
        if (!$pageNumber || !$pageSize) {
            return null;
        }

        return ($pageNumber - 1) * $pageSize;
    }
}
