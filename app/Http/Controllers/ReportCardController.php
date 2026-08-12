<?php

namespace App\Http\Controllers;

use App\Models\ReportCard;
use App\Models\Grade;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportCardController extends Controller
{
    public function downloadPdf($id)
    {
        $reportCard = ReportCard::with(['student.classroom', 'academicYear'])->findOrFail($id);
        
        $user = auth()->user();
        
        // Cek hak akses
        if ($user->hasRole('siswa') && $reportCard->student->user_id !== $user->id) {
            abort(403, 'Anda tidak diizinkan melihat rapor ini.');
        }

        if ($user->hasRole('orang_tua')) {
            $studentIds = \App\Models\StudentParent::where('user_id', $user->id)->pluck('student_id')->toArray();
            if (!in_array($reportCard->student_id, $studentIds)) {
                abort(403, 'Anda tidak diizinkan melihat rapor ini.');
            }
        }

        // Dapatkan semua nilai siswa pada tahun ajaran ini
        $grades = Grade::with('subject')
            ->where('student_id', $reportCard->student_id)
            ->where('academic_year_id', $reportCard->academic_year_id)
            ->get();
            
        $finalGrades = [];
        foreach ($grades as $grade) {
            $nilaiAkhir = $grade->nilai_akhir;
            $predikat = $grade->nilai_huruf;

            // Jika nilai akhir belum ada di database, hitung ulang secara otomatis
            if ($nilaiAkhir === null) {
                $totalBobot = 0;
                $nilaiTotal = 0;
                
                if ($grade->nilai_tugas > 0) { $nilaiTotal += $grade->nilai_tugas * 0.2; $totalBobot += 0.2; }
                if ($grade->nilai_uh > 0) { $nilaiTotal += $grade->nilai_uh * 0.2; $totalBobot += 0.2; }
                if ($grade->nilai_uts > 0) { $nilaiTotal += $grade->nilai_uts * 0.3; $totalBobot += 0.3; }
                if ($grade->nilai_uas > 0) { $nilaiTotal += $grade->nilai_uas * 0.3; $totalBobot += 0.3; }
                
                $nilaiAkhir = $totalBobot > 0 ? round($nilaiTotal / $totalBobot) : 0;
                
                $predikat = 'Kurang';
                if ($nilaiAkhir >= 90) $predikat = 'Sangat Baik';
                elseif ($nilaiAkhir >= 80) $predikat = 'Baik';
                elseif ($nilaiAkhir >= 70) $predikat = 'Cukup';
            }

            $finalGrades[] = [
                'nama_mapel' => $grade->subject->nama_mapel,
                'kkm' => 75,
                'nilai_akhir' => $nilaiAkhir,
                'predikat' => $predikat
            ];
        }

        // Dapatkan rekap absensi
        $attendances = Attendance::where('student_id', $reportCard->student_id)
            ->where('academic_year_id', $reportCard->academic_year_id)
            ->get();
            
        $rekapAbsensi = [
            'Hadir' => $attendances->where('status', 'Hadir')->count(),
            'Sakit' => $attendances->where('status', 'Sakit')->count(),
            'Izin' => $attendances->where('status', 'Izin')->count(),
            'Alpa' => $attendances->where('status', 'Alpa')->count(),
        ];

        $pdf = Pdf::loadView('pdf.report-card', compact('reportCard', 'finalGrades', 'rekapAbsensi'));
        $filename = 'Rapor-' . $reportCard->student->nama_lengkap . '-' . $reportCard->academicYear->tahun_ajaran . '.pdf';
        $filename = str_replace(['/', '\\'], '-', $filename);
        
        return $pdf->stream($filename);
    }
}
