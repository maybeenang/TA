<?php

namespace App\Providers;

use App\Services\DashboardService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class DashboardProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {

        $this->app->singleton(DashboardService::class, function () {
            return new DashboardService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {

        View::composer('pages.welcome', function ($view) {

            $dashboardService = app(DashboardService::class);

            return $view->with(
                [
                    'adminDashboardData' => $dashboardService->adminDashboardData(),
                ]
            );
        });
    }
}
