<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Student extends Model
{
    protected $fillable = [
        'user_id',
        'nisn',
        'nis',
        'nama_lengkap',
        'jenis_kelamin',
        'classroom_id',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'no_telepon',
        'status',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class);
    }

    public function parent(): HasOne
    {
        return $this->hasOne(StudentParent::class);
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    public function grades(): HasMany
    {
        return $this->hasMany(Grade::class);
    }

    public function tuitionBills(): HasMany
    {
        return $this->hasMany(TuitionBill::class);
    }

    public function counselingRecords(): HasMany
    {
        return $this->hasMany(CounselingRecord::class);
    }
}
