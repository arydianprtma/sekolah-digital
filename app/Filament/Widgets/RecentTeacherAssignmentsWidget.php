<?php

namespace App\Filament\Widgets;

use App\Models\Assignment;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentTeacherAssignmentsWidget extends BaseWidget
{
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 'full';

    public static function canView(): bool
    {
        return auth()->user()?->hasRole('guru') ?? false;
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Assignment::query()
                    ->where('teacher_id', auth()->id())
                    ->latest()
                    ->limit(5)
            )
            ->heading('Tugas Terakhir Dibuat')
            ->description('Memantau 5 tugas terakhir yang Anda berikan')
            ->columns([
                Tables\Columns\TextColumn::make('judul')
                    ->label('Judul Tugas')
                    ->searchable(),
                Tables\Columns\TextColumn::make('classroom.nama_kelas')
                    ->label('Kelas'),
                Tables\Columns\TextColumn::make('submissions_count')
                    ->counts('submissions')
                    ->label('Dikumpulkan')
                    ->badge()
                    ->color('success'),
                Tables\Columns\TextColumn::make('tenggat_waktu')
                    ->label('Tenggat')
                    ->dateTime('d M Y H:i'),
            ])
            ->actions([
                \Filament\Actions\Action::make('lihat')
                    ->label('Lihat Detail')
                    ->url(fn ($record) => url('/portal/assignments/' . $record->id))
                    ->icon('heroicon-o-eye'),
            ]);
    }
}
