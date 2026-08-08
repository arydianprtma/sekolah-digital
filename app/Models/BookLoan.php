<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookLoan extends Model
{
    protected $fillable = [
        'library_book_id',
        'student_id',
        'tanggal_pinjam',
        'tenggat_kembali',
        'tanggal_kembali',
        'status',
    ];

    protected $casts = [
        'tanggal_pinjam'  => 'date',
        'tenggat_kembali' => 'date',
        'tanggal_kembali' => 'date',
    ];

    public function book(): BelongsTo
    {
        return $this->belongsTo(LibraryBook::class, 'library_book_id');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}
