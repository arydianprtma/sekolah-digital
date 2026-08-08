<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NewsletterCampaign extends Model
{
    protected $fillable = [
        'subjek',
        'konten',
        'status',
        'dijadwalkan_pada',
        'dikirim_pada',
        'jumlah_penerima',
        'jumlah_terkirim',
        'dibuat_oleh',
    ];

    protected $casts = [
        'dijadwalkan_pada' => 'datetime',
        'dikirim_pada'     => 'datetime',
    ];

    public function pembuat(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }
}
