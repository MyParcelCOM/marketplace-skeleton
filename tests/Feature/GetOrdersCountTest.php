<?php

declare(strict_types=1);

namespace Tests\Feature;

use Faker\Factory;
use Tests\TestCase;

class GetOrdersCountTest extends TestCase
{
    use CanCreateActiveTokens;

    public function test_should_get_400_bad_request_when_shop_id_is_missing(): void
    {
        $this->get('/orders/count')->assertStatus(400);
    }

    public function test_should_get_422_unprocessable_entity_when_shop_id_is_not_valid_uuid(): void
    {
        $this->get('/orders/count?shop_id=1234567')->assertUnprocessable();
    }

    public function test_should_get_401_unauthorized_when_shop_is_not_authenticated(): void
    {
        $this->get('/orders/count?shop_id=' . Factory::create()->uuid)->assertUnauthorized();
    }

    public function test_should_get_422_unprocessable_entity_when_date_to_or_date_from_is_not_valid_date_format(): void
    {
        // TODO Mock the remote API. See https://docs.guzzlephp.org/en/stable/testing.html
        $token = $this->createActiveToken();

        $this->get('/orders/count?shop_id=' . $token->shop_id . '&date_from=1-1-2024')
            ->assertUnprocessable();

        $this->get('/orders/count?shop_id=' . $token->shop_id . '&date_to=1-1-2024')
            ->assertUnprocessable();
    }

    public function test_should_get_200_ok_with_available_token(): void
    {
        // TODO Mock the remote API. See https://docs.guzzlephp.org/en/stable/testing.html
        $token = $this->createActiveToken();

        $response = $this->get('/orders/count?shop_id=' . $token->shop_id);

        $response->assertStatus(200);
    }
}
