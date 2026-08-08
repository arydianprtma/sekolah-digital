<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'primary_image',
        'gallery',
        'available_features',
        'status',
        'sort_order',
    ];

    protected $casts = [
        'gallery' => 'array',
        'available_features' => 'array',
        'status' => 'boolean',
        'sort_order' => 'integer',
    ];
}
