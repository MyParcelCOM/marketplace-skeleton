<?php

declare(strict_types=1);

namespace Tests\Feature;

use Faker\Factory;
use Tests\TestCase;

class GetOrderTest extends TestCase
{
    use CanCreateActiveTokens;

    public function test_should_get_400_bad_request_when_shop_id_is_missing(): void
    {
        $response = $this->get('/orders/1234567');

        $response->assertStatus(400);
    }

    public function test_should_get_422_unprocessable_entity_when_shop_id_is_not_valid_uuid(): void
    {
        $response = $this->get('/orders/1234567?shop_id=1234567');

        $response->assertStatus(422);
    }

    public function test_should_get_401_unauthorized_when_shop_is_not_authenticated(): void
    {
        $response = $this->get('/orders/1234567?shop_id=' . Factory::create()->uuid);

        $response->assertStatus(401);
    }

    public function test_should_get_200_ok_with_available_token(): void
    {
        // TODO Mock the remote API. See https://docs.guzzlephp.org/en/stable/testing.html
        $token = $this->createActiveToken();

        $response = $this->get(
            '/orders/1234567?shop_id='
            . $token->shop_id,
        );

        $response->assertStatus(200);
    }
}
