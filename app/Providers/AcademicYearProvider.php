<?php

namespace App\Providers;

use App\Models\AcademicYear;
use Illuminate\Support\ServiceProvider;
use Laravel\Reverb\Loggers\Log;

class AcademicYearProvider extends ServiceProvider
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

        // get now date
        $now = now();
        // get academic year now
        $academicYearNow = AcademicYear::where('start_date', '<=', $now)
            ->where('end_date', '>=', $now)
            ->first();

        if (!$academicYearNow) {
            $academicYearNow = AcademicYear::where('start_date', '>=', $now)
                ->orderBy('start_date', 'asc')
                ->first();
        }




        Log::info('Academic Year Now: ' . $academicYearNow);

        // set academic year now to view
        $this->app->make('view')->share('academicYearNow', $academicYearNow);
    }
}
