<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherStaff extends Model
{
    use HasFactory;

    protected $table = 'teacher_staffs';

    protected $fillable = [
        'name',
        'nip',
        'nuptk',
        'position',
        'subject',
        'photo',
        'bio',
        'email',
        'category',
        'status',
        'sort_order',
    ];

    protected $casts = [
        'status' => 'boolean',
        'sort_order' => 'integer',
    ];
}
