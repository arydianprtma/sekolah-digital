<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class PortalPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('portal')
            ->path('portal')
            ->login()
            ->profile(\App\Filament\Pages\CustomEditProfile::class, isSimple: false)
            ->brandName(fn () => match (true) {
                auth()->check() && auth()->user()->hasRole('Super Admin') => 'Portal Super Admin',
                auth()->check() && auth()->user()->hasRole('admin') => 'Portal Admin',
                auth()->check() && auth()->user()->hasRole('guru') => 'Portal Guru',
                auth()->check() && auth()->user()->hasRole('siswa') => 'Portal Siswa',
                auth()->check() && auth()->user()->hasRole('orang_tua') => 'Portal Orang Tua',
                default => 'Portal Akademik',
            })
            ->favicon(null)
            ->colors([
                'primary' => Color::Amber,
            ])
            ->sidebarCollapsibleOnDesktop()
            ->renderHook(
                'panels::head.done',
                fn () => \Illuminate\Support\Facades\Blade::render('
                    <style>
                        /* Synchronized High-Specificity Jelly Elastic Bounce for Sidebar & Main Content */
                        html body div.fi-layout aside.fi-sidebar,
                        html body div.fi-layout aside[class*="fi-sidebar"] {
                            transition: width 0.55s cubic-bezier(0.68, -0.6, 0.27, 1.6), 
                                        transform 0.55s cubic-bezier(0.68, -0.6, 0.27, 1.6),
                                        margin 0.55s cubic-bezier(0.68, -0.6, 0.27, 1.6) !important;
                        }

                        html body div.fi-layout main.fi-main,
                        html body div.fi-layout header.fi-topbar {
                            transition: margin-left 0.55s cubic-bezier(0.68, -0.6, 0.27, 1.6),
                                        padding-left 0.55s cubic-bezier(0.68, -0.6, 0.27, 1.6) !important;
                        }

                        /* Animasi Bouncy Icon & Item Menu */
                        html body div.fi-layout aside.fi-sidebar a.fi-sidebar-item-btn,
                        html body div.fi-layout aside.fi-sidebar button.fi-sidebar-item-btn,
                        html body div.fi-layout aside.fi-sidebar .fi-sidebar-item-btn {
                            transition: background-color 0.2s ease, 
                                        color 0.2s ease, 
                                        transform 0.35s cubic-bezier(0.68, -0.6, 0.32, 1.6) !important;
                        }

                        html body div.fi-layout aside.fi-sidebar .fi-sidebar-item-btn:hover {
                            transform: translateX(8px) scale(1.02) !important;
                        }

                        html body div.fi-layout aside.fi-sidebar .fi-sidebar-item-btn:active {
                            transform: scale(0.92) !important;
                        }

                        /* Keyframes animasi Jelly / Agar-agar pada ikon saat di-hover */
                        @keyframes jellyBounceAnim {
                            0% { transform: scale(1, 1); }
                            30% { transform: scale(1.3, 0.7); }
                            50% { transform: scale(0.75, 1.25); }
                            75% { transform: scale(1.15, 0.85); }
                            90% { transform: scale(0.95, 1.05); }
                            100% { transform: scale(1, 1); }
                        }

                        html body div.fi-layout aside.fi-sidebar .fi-sidebar-item-btn:hover svg {
                            animation: jellyBounceAnim 0.6s ease-in-out !important;
                        }

                        /* Tombol Toggle Sidebar Membal */
                        html body button[x-on\:click*="sidebar"],
                        html body .fi-sidebar-header button,
                        html body .fi-topbar button {
                            transition: transform 0.4s cubic-bezier(0.68, -0.6, 0.32, 1.6) !important;
                        }
                        html body button[x-on\:click*="sidebar"]:hover,
                        html body .fi-sidebar-header button:hover {
                            transform: scale(1.2) rotate(12deg) !important;
                        }
                        html body button[x-on\:click*="sidebar"]:active,
                        html body .fi-sidebar-header button:active {
                            transform: scale(0.85) rotate(-12deg) !important;
                        }
                    </style>
                ')
            )
            ->navigationGroups([
                'Akademik & Sekolah',
                'E-Learning & Pembelajaran',
                'Informasi & Konten Web',
                'Profil & Fasilitas',
                'Layanan & Keuangan',
                'Pengaturan Pengguna',
                'Sistem & Keamanan',
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                \App\Filament\Widgets\MaintenanceBannerWidget::class,
                \App\Filament\Widgets\StatsOverviewWidget::class,
                \App\Filament\Widgets\WelcomeWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
