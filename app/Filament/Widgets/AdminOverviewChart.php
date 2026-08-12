<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class AdminOverviewChart extends ChartWidget
{
    protected ?string $heading = 'Distribusi Pengguna';
    protected static ?int $sort = 2;

    public static function canView(): bool
    {
        $user = auth()->user();
        return $user && ($user->hasRole('Super Admin') || $user->hasRole('admin'));
    }

    protected function getData(): array
    {
        $rolesCount = DB::table('model_has_roles')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->select('roles.name', DB::raw('count(*) as total'))
            ->groupBy('roles.name')
            ->pluck('total', 'roles.name')
            ->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Pengguna',
                    'data' => array_values($rolesCount),
                    'backgroundColor' => [
                        '#f59e0b', // amber
                        '#10b981', // emerald
                        '#3b82f6', // blue
                        '#6366f1', // indigo
                        '#8b5cf6', // violet
                    ],
                ],
            ],
            'labels' => array_map('ucfirst', array_keys($rolesCount)),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
