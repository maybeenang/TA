<?php

namespace App\Providers;

use App\Events;
use App\Listeners;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        /*if (config('app.env') === 'production') {*/
        /*    $this->app['request']->server->set('HTTPS', true);*/
        /*}*/

        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
        // Allow for both HTTP and HTTPS requests
        Request::macro('hasValidSignature', function ($absolute = true, array $ignoreQuery = []) {
            $https = clone $this;
            $https->server->set('HTTPS', 'on');

            $http = clone $this;
            $http->server->set('HTTPS', 'off');

            return URL::hasValidSignature($https, $absolute, $ignoreQuery)
                || URL::hasValidSignature($http, $absolute, $ignoreQuery);
        });
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
