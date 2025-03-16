<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        # Debugbar.
        if (env('APP_DEBUG')) {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('Debugbar', \Barryvdh\Debugbar\Facades\Debugbar::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
