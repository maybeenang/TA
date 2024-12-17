<?php

namespace App\Providers;

use App\Services\SidebarService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class SidebarServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(SidebarService::class, function () {
            return new SidebarService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('layouts.sidebar', function ($view) {
            $sidebarService = app(SidebarService::class);

            $view->with([
                'badgeCount' => $sidebarService->getBadgeCount(),
            ]);
        });
    }
}
