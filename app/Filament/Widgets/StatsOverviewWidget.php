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
use App\Models\AssignmentSubmission;
use App\Models\ContactMessage;
use App\Models\TuitionBill;
use App\Models\Classroom;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $user = auth()->user();

        // Helper function for random sparkline
        $sparkline = fn() => [rand(1,10), rand(1,10), rand(1,10), rand(1,10), rand(1,10), rand(1,10), rand(1,10)];

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
                    ->chart($sparkline())
                    ->color('success'),
                Stat::make('Tugas & Materi', $tugas)
                    ->description('Tugas dari guru')
                    ->descriptionIcon('heroicon-m-document-text')
                    ->chart($sparkline())
                    ->color('info'),
                Stat::make('Tagihan Aktif', $tagihan)
                    ->description('Tagihan belum lunas')
                    ->descriptionIcon('heroicon-m-banknotes')
                    ->chart($sparkline())
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
                    ->chart($sparkline())
                    ->color('success'),
                Stat::make('Tagihan SPP', $tagihan)
                    ->description('Tagihan belum lunas')
                    ->descriptionIcon('heroicon-m-banknotes')
                    ->chart($sparkline())
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
                    ->chart($sparkline())
                    ->color('info'),
                Stat::make('Wali Kelas', $kelasWali . ' Rombel')
                    ->description('Kelas yang diampu')
                    ->descriptionIcon('heroicon-m-users')
                    ->chart($sparkline())
                    ->color('success'),
            ];
        }

        // Default: Admin Stats
        return [
            Stat::make('Total Siswa', Student::count())
                ->description('Siswa terdaftar aktif')
                ->descriptionIcon('heroicon-m-academic-cap')
                ->chart($sparkline())
                ->color('primary'),

            Stat::make('Guru & Staf', TeacherStaff::where('status', true)->count())
                ->description('Tenaga pendidik & kependidikan')
                ->descriptionIcon('heroicon-m-user-group')
                ->chart($sparkline())
                ->color('success'),

            Stat::make('Berita Terbit', News::where('status', 'published')->count())
                ->description('Total berita sekolah dipublikasikan')
                ->descriptionIcon('heroicon-m-newspaper')
                ->chart($sparkline())
                ->color('info'),

            Stat::make('Pengumuman Aktif', Announcement::where('status', true)->count())
                ->description('Total pengumuman aktif')
                ->descriptionIcon('heroicon-m-megaphone')
                ->chart($sparkline())
                ->color('warning'),

            Stat::make('Agenda Kegiatan', Agenda::where('status', true)->count())
                ->description('Total agenda kegiatan sekolah')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->chart($sparkline())
                ->color('info'),

            Stat::make('Album Galeri', Album::where('status', true)->count())
                ->description('Dokumentasi foto & video')
                ->descriptionIcon('heroicon-m-photo')
                ->chart($sparkline())
                ->color('success'),

            Stat::make('Hadir Hari Ini', Attendance::whereDate('tanggal', Carbon::today())->where('status', 'hadir')->count())
                ->description(
                    'Sakit: ' . Attendance::whereDate('tanggal', Carbon::today())->where('status', 'sakit')->count() .
                    ' · Izin: ' . Attendance::whereDate('tanggal', Carbon::today())->where('status', 'izin')->count() .
                    ' · Alpa: ' . Attendance::whereDate('tanggal', Carbon::today())->where('status', 'alpa')->count()
                )
                ->descriptionIcon('heroicon-m-clipboard-document-check')
                ->chart($sparkline())
                ->color('success'),

            Stat::make('Tugas Belum Dinilai', AssignmentSubmission::whereNull('nilai')->count())
                ->description('Submission menunggu penilaian guru')
                ->descriptionIcon('heroicon-m-pencil-square')
                ->chart($sparkline())
                ->color('warning'),

            Stat::make('Pesan Masuk', ContactMessage::where('status', 'baru')->count())
                ->description('Pesan publik belum dibaca')
                ->descriptionIcon('heroicon-m-envelope')
                ->chart($sparkline())
                ->color('danger'),
        ];
    }
}
