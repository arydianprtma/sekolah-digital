<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TuitionBill extends Model
{
    protected $fillable = [
        'student_id',
        'nama_tagihan',
        'jumlah',
        'bulan_tahun',
        'jatuh_tempo',
        'status',
    ];

    protected $casts = [
        'jumlah'      => 'float',
        'jatuh_tempo' => 'date',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(TuitionPayment::class);
    }
}
