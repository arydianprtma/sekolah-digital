<?php

namespace App\Filament\Widgets;

use App\Models\Agenda;
use App\Models\Album;
use App\Models\Announcement;
use App\Models\News;
use App\Models\Page;
use App\Models\TeacherStaff;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Berita Terbit', News::where('status', 'published')->count())
                ->description('Total berita sekolah dipublikasikan')
                ->descriptionIcon('heroicon-m-newspaper')
                ->color('success'),

            Stat::make('Pengumuman Aktif', Announcement::where('status', true)->count())
                ->description('Total pengumuman aktif')
                ->descriptionIcon('heroicon-m-megaphone')
                ->color('warning'),

            Stat::make('Agenda Kegiatan', Agenda::where('status', true)->count())
                ->description('Total agenda kegiatan sekolah')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('info'),

            Stat::make('Guru & Staf', TeacherStaff::where('status', true)->count())
                ->description('Tenaga pengidik & kependidikan')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('primary'),

            Stat::make('Album Galeri', Album::where('status', true)->count())
                ->description('Dokumentasi foto & video')
                ->descriptionIcon('heroicon-m-photo')
                ->color('success'),

            Stat::make('Halaman Custom', Page::where('status', 'published')->count())
                ->description('Halaman informasi sekolah')
                ->descriptionIcon('heroicon-m-document-duplicate')
                ->color('gray'),
        ];
    }
}
