<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class MenuProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $menuJson = file_get_contents(base_path('resources/menu/menu.json'));
        $menuData = json_decode($menuJson);

        // Share all menuData to all the views
        $this->app->make('view')->share('menuData', [$menuData]);
    }
}
