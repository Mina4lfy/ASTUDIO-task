<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Macros\StrMacros;

class MacroServiceProvider extends ServiceProvider
{
    /**
     * Register macros.
     */
    public function register(): void
    {
        StrMacros::register();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}