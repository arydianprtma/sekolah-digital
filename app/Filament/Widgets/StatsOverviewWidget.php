<?php

namespace App\Filament\Widgets;

use App\Models\Agenda;
use App\Models\Album;
use App\Models\Announcement;
use App\Models\News;
use App\Models\Page;
use App\Models\TeacherStaff;
use App\Models\Student;
use App\Models\StudentParent;
use App\Models\Attendance;
use App\Models\Assignment;
use App\Models\TuitionBill;
use App\Models\Classroom;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $user = auth()->user();

        if ($user && $user->hasRole('siswa')) {
            $student = Student::where('user_id', $user->id)->first();
            $studentId = $student ? $student->id : 0;
            $classroomId = $student ? $student->classroom_id : 0;

            $hadir = Attendance::where('student_id', $studentId)->where('status', 'hadir')->count();
            $tugas = Assignment::where('classroom_id', $classroomId)->count();
            $tagihan = TuitionBill::where('student_id', $studentId)->where('status', '!=', 'lunas')->count();

            return [
                Stat::make('Total Kehadiran', $hadir)
                    ->description('Kehadiran di kelas')
                    ->descriptionIcon('heroicon-m-check-circle')
                    ->color('success'),
                Stat::make('Tugas & Materi', $tugas)
                    ->description('Tugas dari guru')
                    ->descriptionIcon('heroicon-m-document-text')
                    ->color('info'),
                Stat::make('Tagihan Aktif', $tagihan)
                    ->description('Tagihan belum lunas')
                    ->descriptionIcon('heroicon-m-banknotes')
                    ->color('danger'),
            ];
        }

        if ($user && $user->hasRole('orang_tua')) {
            $parent = StudentParent::where('user_id', $user->id)->first();
            $studentId = $parent ? $parent->student_id : 0;

            $hadir = Attendance::where('student_id', $studentId)->where('status', 'hadir')->count();
            $tagihan = TuitionBill::where('student_id', $studentId)->where('status', '!=', 'lunas')->count();

            return [
                Stat::make('Kehadiran Anak', $hadir)
                    ->description('Total hadir di kelas')
                    ->descriptionIcon('heroicon-m-check-circle')
                    ->color('success'),
                Stat::make('Tagihan SPP', $tagihan)
                    ->description('Tagihan belum lunas')
                    ->descriptionIcon('heroicon-m-banknotes')
                    ->color('danger'),
            ];
        }

        if ($user && $user->hasRole('guru')) {
            $tugas = Assignment::where('teacher_id', $user->id)->count();
            $kelasWali = Classroom::where('wali_kelas_id', $user->id)->count();

            return [
                Stat::make('Tugas Diberikan', $tugas)
                    ->description('Tugas e-learning')
                    ->descriptionIcon('heroicon-m-document-text')
                    ->color('info'),
                Stat::make('Wali Kelas', $kelasWali . ' Rombel')
                    ->description('Kelas yang diampu')
                    ->descriptionIcon('heroicon-m-users')
                    ->color('success'),
            ];
        }

        // Default: Admin Stats
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
                ->description('Tenaga pendidik & kependidikan')
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
