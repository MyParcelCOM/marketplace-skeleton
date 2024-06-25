<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Support\ServiceProvider;
use MyParcelCom\Integration\Exceptions\Handler;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(ExceptionHandler::class, function (Container $app) {
            return (new Handler($app))
                ->setResponseFactory($app->make(ResponseFactory::class))
                ->setDebug((bool) config('app.debug'));
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
