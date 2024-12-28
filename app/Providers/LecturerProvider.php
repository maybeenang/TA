<?php

namespace App\Providers;

use App\Services\LecturerService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class LecturerProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(LecturerService::class, function () {
            return new LecturerService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {

        // Gunakan View Composer di boot()
        View::composer('*', function ($view) {
            $lecturerService = app(LecturerService::class);

            $view->with([
                'allLecturers' => $lecturerService->getAllLecturers(),
            ]);
        });
    }
}
