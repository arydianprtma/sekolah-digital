<?php

namespace App\Filament\Widgets;

use App\Models\Assignment;
use App\Models\Student;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class PendingAssignmentsWidget extends BaseWidget
{
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 'full';

    public static function canView(): bool
    {
        return auth()->user()?->hasRole('siswa') ?? false;
    }

    public function table(Table $table): Table
    {
        $student = Student::where('user_id', auth()->id())->first();
        $classroomId = $student ? $student->classroom_id : 0;
        $studentId = $student ? $student->id : 0;

        return $table
            ->query(
                Assignment::query()
                    ->where('classroom_id', $classroomId)
                    ->whereDoesntHave('submissions', function (Builder $query) use ($studentId) {
                        $query->where('student_id', $studentId);
                    })
                    ->latest()
            )
            ->heading('Tugas Belum Dikerjakan')
            ->description('Daftar tugas yang belum Anda kumpulkan')
            ->columns([
                Tables\Columns\TextColumn::make('judul')
                    ->label('Judul Tugas')
                    ->searchable(),
                Tables\Columns\TextColumn::make('subject.nama_mapel')
                    ->label('Mata Pelajaran'),
                Tables\Columns\TextColumn::make('tenggat_waktu')
                    ->label('Tenggat Waktu')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->badge()
                    ->color(fn ($record) => $record->tenggat_waktu && $record->tenggat_waktu < now() ? 'danger' : 'warning'),
            ])
            ->actions([
                \Filament\Actions\Action::make('kerjakan')
                    ->label('Kerjakan')
                    ->url(fn ($record) => url('/portal/assignments/' . $record->id))
                    ->icon('heroicon-o-pencil-square')
                    ->button(),
            ]);
    }
}
