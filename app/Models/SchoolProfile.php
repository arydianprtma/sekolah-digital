<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_name',
        'npsn',
        'address',
        'phone',
        'email',
        'website',
        'established_year',
        'accreditation',
        'history',
        'vision',
        'mission',
        'principal_name',
        'principal_photo',
        'principal_greeting',
    ];

    protected $casts = [
        'mission' => 'array',
    ];
}
