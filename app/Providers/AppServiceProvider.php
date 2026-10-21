<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
Use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;

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
        RateLimiter::for('users', function(Request $request){

            return Limit::perSecond(2,10)->by($request->user()?->id ?? $request->ip());

        });
    }

    
}
