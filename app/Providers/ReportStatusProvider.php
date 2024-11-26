<?php

namespace App\Providers;

use App\Enums\ReportStatusEnum;
use App\Models\AcademicYear;
use App\Models\ReportStatus;
use Illuminate\Support\ServiceProvider;
use Laravel\Reverb\Loggers\Log;

class ReportStatusProvider extends ServiceProvider
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
        // set report status to view
        $this->app->make('view')->share('reportStatus', ReportStatusEnum::class);
    }
}
