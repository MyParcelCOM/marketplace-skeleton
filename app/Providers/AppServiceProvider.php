<?php

declare(strict_types=1);

namespace App\Providers;

use App\Authentication\Domain\AuthorizationSession;
use App\Authentication\Domain\AuthServer;
use App\Authentication\Domain\AuthServerInterface;
use App\Exceptions\ExceptionHandler;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Debug\ExceptionHandler as LaravelExceptionHandler;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

use function config;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(LaravelExceptionHandler::class, function (Container $app) {
            return (new ExceptionHandler($app))
                ->setResponseFactory($app->make(ResponseFactory::class))
                ->setDebug((bool) config('app.debug'));
        });

        $this->app->singleton(AuthServerInterface::class, fn() => new AuthServer(
            (string) config('services.remote.oauth2.client_id'),
            (string) config('services.remote.oauth2.client_secret'),
        ));

        if (!$this->app->environment('testing')) {
            $this->app->singleton(AuthorizationSession::class, fn() => new AuthorizationSession(
                Cache::store('redis')
            ));
        }
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
