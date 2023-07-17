<?php

declare(strict_types=1);

namespace App\Authentication\Domain;

use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\UriInterface;

class AuthorizationLink
{
    public function __construct(
        private string $clientId,
        private string $redirectUri,
        private string $sessionToken,
    ) {
    }

    public function buildUri(): UriInterface
    {
        return Uri::fromParts([
            'scheme' => 'https',
            'host'   => 'enter_platform_host_here.com',
            'path'   => '/oauth2/auth',
            'query'  => http_build_query([
                'client_id'     => $this->clientId,
                'redirect_uri'  => $this->redirectUri . '?session_token=' . $this->sessionToken,
                'response_type' => 'code',
            ]),
        ]);
    }
}
