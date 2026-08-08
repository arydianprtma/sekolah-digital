<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'seo_title',
        'seo_description',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function news(): HasMany
    {
        return $this->hasMany(News::class);
    }
}
