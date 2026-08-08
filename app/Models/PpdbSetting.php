<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PpdbSetting extends Model
{
    protected $fillable = [
        'tahun_ajaran',
        'tanggal_mulai',
        'tanggal_selesai',
        'gelombang',
        'persyaratan',
        'jadwal',
        'biaya',
        'link_pendaftaran',
        'whatsapp_pendaftaran',
        'email_pendaftaran',
        'keterangan',
        'is_active',
    ];

    protected $casts = [
        'tanggal_mulai'   => 'date',
        'tanggal_selesai' => 'date',
        'is_active'       => 'boolean',
    ];

    /**
     * Get the currently active PPDB setting.
     */
    public static function aktif(): ?self
    {
        return static::where('is_active', true)->latest()->first();
    }
}
