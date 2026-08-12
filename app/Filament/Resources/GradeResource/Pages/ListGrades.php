<?php

namespace App\Filament\Resources\GradeResource\Pages;

use App\Filament\Resources\GradeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGrades extends ListRecords
{
    protected static string $resource = GradeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('sinkronisasi_nilai')
                ->label('Sinkronisasi Data')
                ->icon('heroicon-o-arrow-path')
                ->color('success')
                ->requiresConfirmation()
                ->modalHeading('Sinkronisasi Data Nilai')
                ->modalDescription('Proses ini akan membuat lembar nilai kosong untuk semua siswa yang belum memiliki nilai pada mata pelajaran di kelasnya masing-masing. Lanjutkan?')
                ->action(function () {
                    $activeYear = \App\Models\AcademicYear::where('is_active', true)->first();
                    if (!$activeYear) {
                        \Filament\Notifications\Notification::make()
                            ->title('Gagal')
                            ->body('Tidak ada Tahun Ajaran yang aktif.')
                            ->danger()
                            ->send();
                        return;
                    }

                    $schedules = \App\Models\Schedule::all();
                    $createdCount = 0;

                    foreach ($schedules as $schedule) {
                        $students = \App\Models\Student::where('classroom_id', $schedule->classroom_id)->get();
                        
                        foreach ($students as $student) {
                            // Check if grade exists
                            $exists = \App\Models\Grade::where('student_id', $student->id)
                                ->where('subject_id', $schedule->subject_id)
                                ->where('academic_year_id', $activeYear->id)
                                ->exists();

                            if (!$exists) {
                                \App\Models\Grade::create([
                                    'student_id' => $student->id,
                                    'subject_id' => $schedule->subject_id,
                                    'academic_year_id' => $activeYear->id,
                                ]);
                                $createdCount++;
                            }
                        }
                    }

                    \Filament\Notifications\Notification::make()
                        ->title('Berhasil')
                        ->body("Sinkronisasi selesai. $createdCount data nilai baru berhasil ditambahkan.")
                        ->success()
                        ->send();
                })
                ->hidden(fn () => !auth()->user()->hasRole('admin') && !auth()->user()->hasRole('guru')),
            // Actions\CreateAction::make(),
        ];
    }
}
