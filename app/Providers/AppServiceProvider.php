<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use LLoadout\Microsoftgraph\EventListeners\MicrosoftGraphCallbackReceived;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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
        // Livewire::setUpdateRoute(function ($handle) {
        //     return Route::post('/livewire/update', $handle)
        //         ->middleware('web')
        //         ->prefix(LaravelLocalization::setLocale());
        // });

        // Event::listen(function (MicrosoftGraphCallbackReceived $event) {
        //     session()->put('microsoftgraph-access-data', $event->accessData);
        // });
    }
}
