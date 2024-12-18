<?php

namespace App\Providers;

use App\Services\RoleService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class RoleSerivceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(RoleService::class, function () {
            return new RoleService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $roleService = app(RoleService::class);

            $view->with([
                'loggedInUserRole' => $roleService->getLoggedInRole(),
            ]);
        });
    }
}
