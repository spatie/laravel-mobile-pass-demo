<?php

namespace App\Providers;

use App\Support\Database\EnsureSqliteDatabaseExists;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        $this->app->booted(fn () => app(EnsureSqliteDatabaseExists::class)(config('database.default')));
    }
}
