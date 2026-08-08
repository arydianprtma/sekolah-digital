<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsletterSubscriber extends Model
{
    protected $fillable = [
        'nama',
        'email',
        'token_verifikasi',
        'terverifikasi_pada',
        'status',
        'sumber',
        'berhenti_pada',
    ];

    protected $casts = [
        'terverifikasi_pada' => 'datetime',
        'berhenti_pada'      => 'datetime',
    ];

    public function isAktif(): bool
    {
        return $this->status === 'aktif';
    }
}
