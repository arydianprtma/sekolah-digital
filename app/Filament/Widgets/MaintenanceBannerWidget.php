<?php

namespace App\Filament\Widgets;

use App\Models\Setting;
use Filament\Widgets\Widget;

class MaintenanceBannerWidget extends Widget
{
    protected string $view = 'filament.widgets.maintenance-banner';

    // Tampilkan di urutan paling atas
    protected static ?int $sort = -99;

    // Full width
    protected int | string | array $columnSpan = 'full';

    // Hanya tampil jika maintenance mode aktif
    public static function canView(): bool
    {
        return (bool) Setting::get('maintenance_mode', false);
    }

    public function getMaintenanceMessage(): string
    {
        return Setting::get('maintenance_message', 'Website sedang dalam pemeliharaan berkala.');
    }
}
