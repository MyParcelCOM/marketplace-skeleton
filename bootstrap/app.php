<?php

declare(strict_types=1);

use Illuminate\Foundation\Application;
use MyParcelCom\ConcurrencySafeMigrations\Commands\Migrate;
use MyParcelCom\Integration\Exceptions\ExceptionMapper;
use MyParcelCom\Integration\Http\Middleware\MiddlewareMapper;

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

return Application::configure(basePath: $_ENV['APP_BASE_PATH'] ?? dirname(__DIR__))
    ->withExceptions(new ExceptionMapper($_ENV['APP_DEBUG'] ?? false))
    ->withMiddleware(new MiddlewareMapper())
    ->withCommands([
        Migrate::class,
    ])
    ->create();
