<?php

declare(strict_types=1);

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use MyParcelCom\ConcurrencySafeMigrations\Commands\Migrate;
use MyParcelCom\Integration\Exceptions\DoNotReportExceptions;
use MyParcelCom\Integration\Exceptions\ExceptionRendering;
use MyParcelCom\Integration\Http\Middleware\DefaultMiddleware;

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

$exceptionHandling = new class() {
    public function __invoke(Exceptions $exceptions): void
    {
        $exceptionRendering = new ExceptionRendering($_ENV['APP_DEBUG'] ?? false);
        $doNotReportExceptions = new DoNotReportExceptions();

        $exceptionRendering($exceptions);
        $doNotReportExceptions($exceptions);
    }
};

$middlewareHandling = new DefaultMiddleware();

return Application::configure(basePath: $_ENV['APP_BASE_PATH'] ?? dirname(__DIR__))
    ->withExceptions($exceptionHandling)
    ->withMiddleware($middlewareHandling)
    ->withCommands([Migrate::class])
    ->create();
