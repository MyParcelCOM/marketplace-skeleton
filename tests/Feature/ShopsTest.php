<?php

declare(strict_types=1);

namespace Tests\Feature;

use Faker\Factory;
use Tests\TestCase;

class ShopsTest extends TestCase
{
    public function test_should_get_204_ok_when_posting_setup(): void
    {
        $faker = Factory::create();
        $data = [
            'data' => [
                'settings' => [],
            ],
        ];

        $response = $this->postJson(sprintf('/shops/%s/setup', $faker->uuid), $data);

        $response->assertStatus(204);
    }

    public function test_should_get_204_ok_when_posting_teardown(): void
    {
        $faker = Factory::create();

        $response = $this->postJson(sprintf('/shops/%s/teardown', $faker->uuid));

        $response->assertStatus(204);
    }
}
