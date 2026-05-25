<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
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
        RateLimiter::for('text-to-sql-generate', function (Request $request) {
            $maxAttempts = config('ai.limits.queries_per_hour');

            return Limit::perHour($maxAttempts)
                ->by($request->ip())
                ->response(function () {
                    return response()->json([
                        'error' => 'Too many questions this hour. Please try again later.',
                    ], 429);
                });
        });
    }
}
