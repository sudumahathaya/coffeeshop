<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'message_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'subject',
        'message',
        'contact_method',
        'best_time',
        'urgency',
        'newsletter',
        'status',
    ];

    protected $casts = [
        'newsletter' => 'boolean',
    ];

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function scopeNew($query)
    {
        return $query->where('status', 'new');
    }

    public function scopeUrgent($query)
    {
        return $query->where('urgency', 'urgent');
    }
}