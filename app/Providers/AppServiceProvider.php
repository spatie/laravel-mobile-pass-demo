<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        RateLimiter::for('new-pass', fn (Request $request) => [
            Limit::perHour(10)->by($request->ip()),
            Limit::perDay(200)->by('new-pass-global'),
        ]);
    }
}
