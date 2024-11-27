<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Symfony\Component\Mercure\Hub;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Jwt\StaticTokenProvider;

class MercureServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(HubInterface::class, function () {
            return new Hub(
                config('broadcasting.connections.mercure.url'),
                new StaticTokenProvider(app()->make('mvanduijker.mercure_broadcaster.publisher_jwt'))
            );
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void {}
}
