<?php

namespace App\Providers;

use App\Services\QiscusService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Client\Factory as HttpFactory;
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
        $this->app->singleton(QiscusService::class, function (Application $app) {

            $config = $app->make('config')->get('qiscus');

            $client = $app->make(HttpFactory::class)->withHeaders([
                'Qiscus-App-Id' => $config['app_id'],
                'Qiscus-Secret-Key' => $config['secret_key'],
            ]);

            // This is much cleaner. We just pass the parts the service needs.
            return new QiscusService(
                $client,
                $config['base_url'],
                $config['app_id'],
                $config['channel_id'],
                $config['templates'],
                $config['default_language']
            );
        });
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
