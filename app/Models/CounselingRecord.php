<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CounselingRecord extends Model
{
    protected $fillable = [
        'student_id',
        'teacher_id',
        'tanggal',
        'jenis',
        'poin',
        'deskripsi',
        'tindak_lanjut',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'poin'    => 'integer',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
}
