<?php

namespace App\Providers;

use App\Events;
use App\Listeners;
use Illuminate\Support\Facades\Blade;
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
        if (config('app.env') === 'production') {
            $this->app['request']->server->set('HTTPS', true);
        }

        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        /*Event::listen(Events\StudentGradeUpdated::class, Listeners\RecalculateStudentGrade::class);*/
        /*Event::listen(Events\GradeComponentUpdated::class, Listeners\RecalculateGradeComponent::class);*/
        /*Event::listen(Events\CheckingReport::class, Listeners\ProcessReportVerification::class);*/

        Blade::directive('round', function ($expression) {
            return "<?php echo number_format($expression, 2); ?>";
        });
    }
}
