<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Event;
use App\Listeners\UpdateLastAccess;

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
        Blade::component('components.layouts.app', 'app-layout');
         Event::listen(Login::class, [UpdateLastAccess::class, 'handle']);
    }
}
