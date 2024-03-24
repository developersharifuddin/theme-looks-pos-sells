<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    // public const HOME = '/user/profile';
    public const HOME = '/admin';
    public const ADMIN = '/admin/dashboard';
    public const API = '/api';
    public const CUSTOMER = '/my-panel';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */

    public function boot(): void
    {
        // Define rate limiting for API requests
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->configureRoutes();
    }


    protected function configureRoutes(): void
    {
        Route::middleware('web')
            ->group(base_path('routes/web.php'));

        // Route::prefix('api')
        //     ->middleware(['web', 'auth:web', 'verified'])
        //     ->prefix('api')
        //     ->group(base_path('routes/api.php'));

        Route::middleware('api')
            ->prefix('api')
            ->group(base_path('routes/api.php'));

        Route::prefix('admin')
            ->middleware(['web', 'auth:web', 'verified'])
            ->namespace($this->namespace)
            ->name('admin.')
            ->group(base_path('routes/admin.php'));

        Route::prefix('my-panel')
            ->middleware(['web', 'auth:customer', 'verified'])
            ->namespace($this->namespace)
            ->name('customer.')
            ->group(base_path('routes/customer.php'));
    }
}
