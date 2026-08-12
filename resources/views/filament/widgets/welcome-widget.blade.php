<x-filament-widgets::widget>
    <style>
        .welcome-widget-card {
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, #6366f1 0%, #a855f7 50%, #4f46e5 100%);
            color: white;
            border-radius: 1rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            border: none;
            padding: 0;
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }
        @media (min-width: 768px) {
            .welcome-widget-card {
                flex-direction: row;
                align-items: center;
                justify-content: space-between;
                padding: 1.5rem 2rem;
            }
        }
        .welcome-bg-pattern {
            position: absolute;
            inset: 0;
            opacity: 0.1;
            background-image: url('https://www.transparenttextures.com/patterns/cubes.png');
            mix-blend-mode: overlay;
        }
        .welcome-bg-glow {
            position: absolute;
            top: -6rem;
            right: -6rem;
            width: 16rem;
            height: 16rem;
            background-color: white;
            opacity: 0.1;
            border-radius: 9999px;
            filter: blur(40px);
        }
        .welcome-content-left {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1.5rem;
            text-align: center;
            padding: 1.5rem;
        }
        @media (min-width: 768px) {
            .welcome-content-left {
                flex-direction: row;
                text-align: left;
                padding: 0;
            }
        }
        .welcome-avatar {
            width: 6rem;
            height: 6rem;
            border-radius: 9999px;
            background-color: rgba(255, 255, 255, 0.2);
            padding: 0.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(12px);
            border: 2px solid rgba(255, 255, 255, 0.4);
            box-shadow: inset 0 2px 4px 0 rgba(0,0,0,0.06);
        }
        .welcome-avatar-text {
            font-size: 2.25rem;
            font-weight: 800;
            color: white;
        }
        .welcome-greeting {
            font-size: 1.5rem;
            font-weight: 800;
            letter-spacing: -0.025em;
            margin-bottom: 0.5rem;
            text-shadow: 0 1px 2px rgba(0,0,0,0.1);
        }
        @media (min-width: 768px) {
            .welcome-greeting { font-size: 1.875rem; }
        }
        .welcome-role-badge {
            background-color: rgba(255, 255, 255, 0.2);
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            backdrop-filter: blur(12px);
            font-weight: 600;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .welcome-content-right {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.75rem;
            padding: 0 1.5rem 1.5rem 1.5rem;
        }
        @media (min-width: 768px) {
            .welcome-content-right {
                align-items: flex-end;
                padding: 0;
            }
        }
        .welcome-date {
            font-size: 0.875rem;
            font-weight: 600;
            background-color: rgba(0, 0, 0, 0.2);
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            backdrop-filter: blur(12px);
            box-shadow: inset 0 2px 4px 0 rgba(0,0,0,0.06);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .welcome-logout-btn {
            font-size: 0.875rem;
            padding: 0.625rem 1.25rem;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 0.5rem;
            backdrop-filter: blur(12px);
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            color: white;
            cursor: pointer;
        }
        .welcome-logout-btn:hover {
            background-color: rgba(255, 255, 255, 0.25);
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
        }
        .welcome-icon {
            width: 1.25rem;
            height: 1.25rem;
            opacity: 0.9;
        }
    </style>

    <x-filament::section style="padding: 0; border: none; background: transparent; box-shadow: none;">
        <div class="welcome-widget-card">
            <div class="welcome-bg-pattern"></div>
            <div class="welcome-bg-glow"></div>
            
            <div class="welcome-content-left">
                <div class="welcome-avatar">
                    @if(auth()->user() instanceof \Filament\Models\Contracts\HasAvatar && auth()->user()->getFilamentAvatarUrl())
                        <img src="{{ auth()->user()->getFilamentAvatarUrl() }}" alt="{{ auth()->user()->name }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 9999px;">
                    @else
                        <span class="welcome-avatar-text">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                    @endif
                </div>
                
                <div>
                    <h2 class="welcome-greeting">
                        Selamat {{ match(true) {
                            now()->hour < 11 => 'Pagi',
                            now()->hour < 15 => 'Siang',
                            now()->hour < 18 => 'Sore',
                            default => 'Malam'
                        } }}, {{ auth()->user()->name }}! 👋
                    </h2>
                    <div style="display: flex; align-items: center; gap: 0.5rem; color: #e0e7ff; font-weight: 500; font-size: 1rem; justify-content: center;">
                        <x-heroicon-s-identification class="welcome-icon" style="display: none;" />
                        Anda masuk sebagai: 
                        <span class="welcome-role-badge">
                            {{ ucfirst(str_replace('_', ' ', auth()->user()->getRoleNames()->first() ?? 'Pengguna')) }}
                        </span>
                    </div>
                </div>
            </div>
            
            <div class="welcome-content-right">
                <div class="welcome-date">
                    <x-heroicon-o-calendar-days class="welcome-icon" />
                    {{ now()->translatedFormat('l, d F Y') }}
                </div>
                <form method="POST" action="{{ route('filament.portal.auth.logout') }}" style="margin: 0;">
                    @csrf
                    <button type="submit" class="welcome-logout-btn">
                        <x-heroicon-m-arrow-right-on-rectangle class="welcome-icon" />
                        Keluar Aplikasi
                    </button>
                </form>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
