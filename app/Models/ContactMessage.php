<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ContactMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'subject',
        'message',
        'status',
        'ip_address',
    ];

    public function replies(): HasMany
    {
        return $this->hasMany(ContactMessageReply::class)->latest();
    }

    public function markAsRead(): void
    {
        if ($this->status === 'baru') {
            $this->update(['status' => 'dibaca']);
        }
    }

    public function markAsReplied(): void
    {
        $this->update(['status' => 'dibalas']);
    }
}
