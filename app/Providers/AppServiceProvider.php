<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (app()->isProduction()) {
            URL::forceScheme('https');
            $this->app['request']->server->set('HTTPS', 'on');
        }

    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }
}
