<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TuitionPayment extends Model
{
    protected $fillable = [
        'tuition_bill_id',
        'tanggal_bayar',
        'jumlah_bayar',
        'metode_pembayaran',
        'bukti_bayar',
        'status',
    ];

    protected $casts = [
        'tanggal_bayar' => 'datetime',
        'jumlah_bayar'  => 'float',
    ];

    public function bill(): BelongsTo
    {
        return $this->belongsTo(TuitionBill::class, 'tuition_bill_id');
    }
}
