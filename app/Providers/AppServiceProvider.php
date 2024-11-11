<?php

namespace App\Providers;

use App\Events;
use App\Listeners;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(Events\StudentGradeUpdated::class, Listeners\RecalculateStudentGrade::class);
        Event::listen(Events\GradeComponentUpdated::class, Listeners\RecalculateGradeComponent::class);
    }
}
