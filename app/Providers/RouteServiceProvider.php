<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/dashboard';
    protected $namespace = 'App\Http\Controllers';
    protected $base = 'App\Http\Controllers\Base';
    protected $jeebika = 'App\Http\Controllers\jeebika';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        Route::pattern('id', '[0-9]+');
        Route::pattern('eid', '[0-9]+');
        Route::pattern('name', '[A-Za-z]+');
        Route::pattern('type', '[A-Za-z]+');
        Route::pattern('search', '.*');
        parent::boot();
        $this->configureRateLimiting();
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();
        $this->mapWebRoutes();
        $this->mapMisRoutes();
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')->middleware('api')->namespace($this->namespace)->group(base_path('routes/api.php'));
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')->namespace($this->namespace)->group(base_path('routes/web.php'));
    }

    /**
     * Define the "mis" routes for this application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapMisRoutes(): void
    {
        Route::middleware(['web', 'auth'])->namespace($this->namespace)->group(function () {
            Route::namespace($this->base)->group(base_path('routes/base/base.php'));
        });

        Route::middleware(['web', 'auth', 'base'])->group(function () {
            //base routes
            Route::namespace($this->base)->group(base_path('routes/base/all-mustahiq.php'));
            Route::prefix('base/settings')->as('settings.')->group(base_path('routes/base/settings.php'));
            Route::prefix('base/acl')->as('acl.')->group(base_path('routes/base/acl.php'));

            //jeebika routes
            Route::namespace($this->jeebika)->group(base_path('routes/jeebika/jeebika.php'));
            Route::namespace($this->jeebika)->group(base_path('routes/jeebika/settings.php'));
            Route::namespace($this->jeebika)->group(base_path('routes/jeebika/reports.php'));
            Route::namespace($this->jeebika)->group(base_path('routes/jeebika/approve.php'));
        });
    }
}
