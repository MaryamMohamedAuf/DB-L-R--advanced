<?php

namespace App\Providers;
use App\Services\CohortClient;

use Illuminate\Support\ServiceProvider;
//use App\Models\Sanctum\PersonalAccessToken;
use Laravel\Sanctum\Sanctum;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
 
/**
 * Bootstrap any application services.
 */

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(CohortClient::class, function ($app) {
            return new CohortClient();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
