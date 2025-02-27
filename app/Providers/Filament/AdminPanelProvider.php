<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

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
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                // Widgets\AccountWidget::class,
                // Widgets\FilamentInfoWidget::class,
            ])
            ->spa()
            ->topNavigation()
            // ->sidebarCollapsibleOnDesktop()
            // ->collapsedSidebarWidth('9rem')
            ->colors([
                'danger' => Color::Red, // Warna merah yang tegas untuk kesalahan atau peringatan penting
                'gray' => Color::Slate, // Abu-abu netral untuk elemen sekunder atau teks tidak aktif
                'info' => Color::Sky, // Biru muda yang lebih segar untuk informasi
                'primary' => Color::Blue, // Biru standar untuk elemen utama
                'success' => Color::Green, // Hijau cerah untuk indikasi sukses atau pembayaran berhasil
                'warning' => Color::Amber, // Kuning-oranye yang lebih lembut untuk peringatan
            ])                
            ->font('Noto Sans')
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->widgets([
                \App\Filament\Widgets\StatsDasbor::class,
                \App\Filament\Widgets\BlogPostsChart::class,
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
            ]);
    }
}
