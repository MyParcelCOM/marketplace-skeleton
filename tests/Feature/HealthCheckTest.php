<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

class HealthCheckTest extends TestCase
{
    public function testHealthCheck(): void
    {
        $response = $this->get('/healthz');

        $response->assertStatus(200);
    }
}
