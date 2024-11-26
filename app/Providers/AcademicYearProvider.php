<?php

namespace App\Providers;

use App\Services\AcademicYearService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AcademicYearProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(AcademicYearService::class, function () {
            return new AcademicYearService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Gunakan View Composer di boot()
        View::composer('*', function ($view) {
            $academicYearService = app(AcademicYearService::class);

            $view->with([
                'academicYearNow' => $academicYearService->getCurrentAcademicYear(),
                'allAcademicYears' => $academicYearService->getAllAcademicYears(),
                'dashboardData' => $academicYearService->getAllCountDashboard()
            ]);
        });
    }
}
