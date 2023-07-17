<?php

declare(strict_types=1);

namespace Tests\Feature;

use Faker\Factory;
use Tests\TestCase;

class SettingsTest extends TestCase
{
    use CanCreateActiveTokens;

    public function test_should_get_204_ok_when_posting_settings(): void
    {
        $faker = Factory::create();
        $data = [
            'data' => [
                'settings' => [],
            ],
        ];

        $response = $this->postJson('/settings?' . http_build_query(['shop_id' => $faker->uuid]), $data);

        $response->assertStatus(204);
    }

    public function test_should_get_204_ok_when_deleting_settings(): void
    {
        $faker = Factory::create();

        $response = $this->delete('/settings?' . http_build_query(['shop_id' => $faker->uuid]));

        $response->assertStatus(204);
    }
}
