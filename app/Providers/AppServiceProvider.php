<?php

namespace App\Providers;

use App\Models\Admin;
use App\Services\QiscusService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Client\Factory as HttpFactory;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Spatie\Health\Checks\Checks\DebugModeCheck;
use Spatie\Health\Checks\Checks\EnvironmentCheck;
use Spatie\Health\Checks\Checks\OptimizedAppCheck;
use Spatie\Health\Facades\Health;

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
        Schema::defaultStringLength(191);

        Health::checks([
            OptimizedAppCheck::new(),
            DebugModeCheck::new(),
            EnvironmentCheck::new(),
        ]);

        Gate::define('download-backup', function (Admin $admin) {
            return true;
        });

        Gate::define('delete-backup', function (Admin $admin) {
            return true;
        });

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
