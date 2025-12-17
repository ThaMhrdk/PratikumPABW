<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'summary',
        'diagnosis',
        'recommendation',
        'follow_up_notes',
        'next_session_date',
        'status',
        'started_at',
        'ended_at',
    ];

    protected $casts = [
        'next_session_date' => 'date',
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
    ];

    // Relationships
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function feedback()
    {
        return $this->hasOne(Feedback::class);
    }

    public function chatMessages()
    {
        return $this->hasMany(ChatMessage::class);
    }

    // Helper methods
    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    public function getDurationAttribute()
    {
        if ($this->started_at && $this->ended_at) {
            return $this->started_at->diffInMinutes($this->ended_at) . ' menit';
        }
        return null;
    }
}
