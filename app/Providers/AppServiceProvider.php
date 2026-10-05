<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Models\Element;
use App\Observers\ElementObserver;

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
        //
        Element::observe(ElementObserver::class);
    }
}
