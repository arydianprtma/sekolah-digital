<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LibraryBook extends Model
{
    protected $fillable = [
        'judul',
        'pengarang',
        'penerbit',
        'tahun_terbit',
        'isbn',
        'kategori',
        'stok',
        'pdf_file',
        'cover_image',
    ];

    public function loans(): HasMany
    {
        return $this->hasMany(BookLoan::class);
    }
}
