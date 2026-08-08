<?php

namespace App\Filament\Pages;

use App\Models\PageView;
use App\Models\News;
use App\Models\ContactMessage;
use App\Models\NewsletterSubscriber;
use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;

class AnalyticsDashboard extends Page
{
    protected string $view = 'filament.pages.analytics-dashboard';

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-chart-bar';

    protected static \UnitEnum|string|null $navigationGroup = 'PPDB & Digital';

    protected static ?string $navigationLabel = 'Analytics';

    protected static ?string $title = 'Dashboard Analytics';

    protected static ?int $navigationSort = 10;

    public function getViewData(): array
    {
        $today = now()->toDateString();
        $sevenDaysAgo = now()->subDays(7)->toDateString();
        $thirtyDaysAgo = now()->subDays(30)->toDateString();

        // Total views
        $totalViews     = PageView::count();
        $viewsHariIni   = PageView::where('tanggal', $today)->count();
        $views7Hari     = PageView::where('tanggal', '>=', $sevenDaysAgo)->count();
        $views30Hari    = PageView::where('tanggal', '>=', $thirtyDaysAgo)->count();

        // Daily chart (last 14 days)
        $grafikHarian = PageView::select('tanggal', DB::raw('count(*) as total'))
            ->where('tanggal', '>=', now()->subDays(13)->toDateString())
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->pluck('total', 'tanggal')
            ->toArray();

        // Fill gaps
        $labels = [];
        $data   = [];
        for ($i = 13; $i >= 0; $i--) {
            $date     = now()->subDays($i)->toDateString();
            $labels[] = now()->subDays($i)->format('d M');
            $data[]   = $grafikHarian[$date] ?? 0;
        }

        // Top pages
        $halamanPopuler = PageView::select('url', DB::raw('count(*) as total'))
            ->where('tanggal', '>=', $thirtyDaysAgo)
            ->groupBy('url')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        // Device breakdown
        $perangkat = PageView::select('device_type', DB::raw('count(*) as total'))
            ->where('tanggal', '>=', $thirtyDaysAgo)
            ->groupBy('device_type')
            ->pluck('total', 'device_type')
            ->toArray();

        // Subscribers
        $totalSubscriber  = NewsletterSubscriber::where('status', 'aktif')->count();
        $subscriberBaru   = NewsletterSubscriber::where('status', 'aktif')
            ->where('created_at', '>=', now()->subDays(30))
            ->count();

        // Unread contact messages
        $pesanBaru = ContactMessage::where('status', 'baru')->count();

        return [
            'totalViews'      => $totalViews,
            'viewsHariIni'    => $viewsHariIni,
            'views7Hari'      => $views7Hari,
            'views30Hari'     => $views30Hari,
            'labels'          => $labels,
            'data'            => $data,
            'halamanPopuler'  => $halamanPopuler,
            'perangkat'       => $perangkat,
            'totalSubscriber' => $totalSubscriber,
            'subscriberBaru'  => $subscriberBaru,
            'pesanBaru'       => $pesanBaru,
        ];
    }
}
