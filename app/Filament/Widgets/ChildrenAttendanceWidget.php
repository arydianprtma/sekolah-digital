<?php

namespace App\Filament\Widgets;

use App\Models\Attendance;
use App\Models\StudentParent;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class ChildrenAttendanceWidget extends BaseWidget
{
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 'full';

    public static function canView(): bool
    {
        return auth()->user()?->hasRole('orang_tua') ?? false;
    }

    public function table(Table $table): Table
    {
        $parent = StudentParent::where('user_id', auth()->id())->first();
        $studentId = $parent ? $parent->student_id : 0;

        return $table
            ->query(
                Attendance::query()
                    ->where('student_id', $studentId)
                    ->latest('tanggal')
                    ->limit(7)
            )
            ->heading('Kehadiran Anak Terakhir')
            ->description('Memantau absensi anak 7 hari terakhir')
            ->columns([
                Tables\Columns\TextColumn::make('tanggal')
                    ->label('Tanggal')
                    ->date('d M Y'),
                Tables\Columns\TextColumn::make('student.nama_lengkap')
                    ->label('Nama Anak'),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'hadir' => 'success',
                        'izin' => 'warning',
                        'sakit' => 'info',
                        'alpha' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),
                Tables\Columns\TextColumn::make('keterangan')
                    ->label('Keterangan')
                    ->limit(30),
            ])
            ->paginated(false);
    }
}
