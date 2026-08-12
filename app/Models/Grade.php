<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Grade extends Model
{
    protected $fillable = [
        'student_id',
        'subject_id',
        'academic_year_id',
        'nilai_presensi',
        'nilai_tugas',
        'nilai_uh',
        'nilai_uts',
        'nilai_uas',
        'nilai_akhir',
        'nilai_huruf',
        'catatan',
    ];

    protected $casts = [
        'nilai_presensi' => 'float',
        'nilai_tugas' => 'float',
        'nilai_uh' => 'float',
        'nilai_uts' => 'float',
        'nilai_uas' => 'float',
        'nilai_akhir' => 'float',
    ];

    protected static function booted()
    {
        static::saving(function ($grade) {
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

            $grade->nilai_akhir = $nilaiAkhir;
            $grade->nilai_huruf = $predikat;
        });
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }
}
