<?php

declare(strict_types=1);

namespace App\Http;

use App\Http\Middleware\Authenticate;
use App\Http\Middleware\PreventRequestsDuringMaintenance;
use App\Http\Middleware\TrimStrings;
use App\Http\Middleware\TrustProxies;
use Illuminate\Auth\Middleware\AuthenticateWithBasicAuth;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Auth\Middleware\EnsureEmailIsVerified;
use Illuminate\Auth\Middleware\RequirePassword;
use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull;
use Illuminate\Foundation\Http\Middleware\ValidatePostSize;
use Illuminate\Http\Middleware\HandleCors;
use Illuminate\Http\Middleware\SetCacheHeaders;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Routing\Middleware\ValidateSignature;
use MyParcelCom\Integration\Http\Middleware\MatchingChannelOnly;
use MyParcelCom\Integration\Http\Middleware\TransformsManyToJsonApi;
use MyParcelCom\Integration\Http\Middleware\TransformsOneToJsonApi;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        TrustProxies::class,
        HandleCors::class,
        PreventRequestsDuringMaintenance::class,
        ValidatePostSize::class,
        TrimStrings::class,
        ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'api' => [
            'throttle:api',
            SubstituteBindings::class,
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth'                       => Authenticate::class,
        'auth.basic'                 => AuthenticateWithBasicAuth::class,
        'cache.headers'              => SetCacheHeaders::class,
        'can'                        => Authorize::class,
        'password.confirm'           => RequirePassword::class,
        'signed'                     => ValidateSignature::class,
        'throttle'                   => ThrottleRequests::class,
        'verified'                   => EnsureEmailIsVerified::class,
        'transform_many_to_json_api' => TransformsManyToJsonApi::class,
        'transform_one_to_json_api'  => TransformsOneToJsonApi::class,
        'matching_channel_only'      => MatchingChannelOnly::class,
    ];
}
