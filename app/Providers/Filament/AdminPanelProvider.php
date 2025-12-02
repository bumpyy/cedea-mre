<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Dashboard;
use Asmit\ResizedColumn\ResizedColumnPlugin;
use BinaryBuilds\FilamentFailedJobs\FilamentFailedJobsPlugin;
use Boquizo\FilamentLogViewer\FilamentLogViewerPlugin;
use Cmsmaxinc\FilamentErrorPages\FilamentErrorPagesPlugin;
use Filament\Enums\DatabaseNotificationsPosition;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
// use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Assets\Js;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Hugomyb\FilamentErrorMailer\FilamentErrorMailerPlugin;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Kenepa\ResourceLock\ResourceLockPlugin;
use ShuvroRoy\FilamentSpatieLaravelBackup\FilamentSpatieLaravelBackupPlugin;
use ShuvroRoy\FilamentSpatieLaravelHealth\FilamentSpatieLaravelHealthPlugin;
use SolutionForest\FilamentPanzoom\FilamentPanzoomPlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                // Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                // AccountWidget::class,
                // FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->authGuard('admin')
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->databaseNotifications(position: DatabaseNotificationsPosition::Sidebar)
            ->databaseNotificationsPolling('30s')
            ->profile()
            ->plugins([
                ResizedColumnPlugin::make(),
                FilamentPanzoomPlugin::make(),
                ResourceLockPlugin::make()
                    ->usesPollingToDetectPresence()
                    // ->displayResourceLockOwner()
                    ->presencePollingInterval(5)
                    ->lockTimeout(15),
                FilamentSpatieLaravelHealthPlugin::make(),
                FilamentErrorMailerPlugin::make(),
                FilamentErrorPagesPlugin::make(),
                FilamentLogViewerPlugin::make()
                    ->timezone('Asia/Jakarta'),
                // FilamentFailedJobsPlugin::make()
                //     ->hideConnectionOnIndex()
                //     ->hideQueueOnIndex(),
                FilamentSpatieLaravelBackupPlugin::make(),
            ])
            ->assets([
                Js::make('panzoom-helper', asset('js/app/custom-pan-zoom.js')),
            ]);

    }
}
