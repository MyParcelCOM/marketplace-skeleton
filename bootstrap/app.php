<?php
declare(strict_types=1);
/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| The first thing we will do is create a new Laravel application instance
| which serves as the "glue" for all the components of Laravel, and is
| the IoC container for the system binding all the various parts.
|
*/

use App\Http\Middleware\Authenticate;
use App\Http\Middleware\PreventRequestsDuringMaintenance;
use App\Http\Middleware\TrimStrings;
use App\Http\Middleware\TrustProxies;
use Illuminate\Auth\Middleware\AuthenticateWithBasicAuth;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Auth\Middleware\EnsureEmailIsVerified;
use Illuminate\Auth\Middleware\RequirePassword;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull;
use Illuminate\Foundation\Http\Middleware\ValidatePostSize;
use Illuminate\Http\Middleware\HandleCors;
use Illuminate\Http\Middleware\SetCacheHeaders;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Routing\Middleware\ValidateSignature;
use Illuminate\Validation\ValidationException;
use MyParcelCom\ConcurrencySafeMigrations\Commands\Migrate;
use MyParcelCom\Integration\Exceptions\Handler as MyParcelComExceptionHandler;
use MyParcelCom\Integration\Http\Middleware\MatchingChannelOnly;
use MyParcelCom\Integration\Http\Middleware\TransformsManyToJsonApi;
use MyParcelCom\Integration\Http\Middleware\TransformsOneToJsonApi;

return Application::configure(basePath: $_ENV['APP_BASE_PATH'] ?? dirname(__DIR__))
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->dontReport([
            InvalidArgumentException::class,
        ]);
        $exceptions->render(function (ValidationException $e) {
            return response()->json(
                MyParcelComExceptionHandler::getValidationExceptionBody($e),
                $e->status,
                MyParcelComExceptionHandler::getExceptionHeaders()
            );
        });
    })
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->use([
            TrustProxies::class,
            HandleCors::class,
            PreventRequestsDuringMaintenance::class,
            ValidatePostSize::class,
            TrimStrings::class,
            ConvertEmptyStringsToNull::class,
        ]);
        $middleware->api([
            'throttle:api',
            SubstituteBindings::class,
        ]);
        $middleware->alias([
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
        ]);
    })
    ->withCommands([
        Migrate::class
    ])
    ->create();
