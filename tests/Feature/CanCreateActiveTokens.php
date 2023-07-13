<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Authentication\Domain\ExpiresAt;
use App\Authentication\Domain\Token;
use Carbon\Carbon;

trait CanCreateActiveTokens
{
    private function createActiveToken(): Token
    {
        return Token::factory()->create([
            'expires_at' => new ExpiresAt(Carbon::now()->addSeconds(600)),
        ]);
    }
}
