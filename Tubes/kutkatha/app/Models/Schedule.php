<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'psikolog_id',
        'date',
        'start_time',
        'end_time',
        'consultation_type',
        'is_available',
        'location',
    ];

    protected $casts = [
        'date' => 'date',
        'is_available' => 'boolean',
    ];

    // Relationships
    public function psikolog()
    {
        return $this->belongsTo(Psikolog::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // Helper methods
    public function getFormattedTimeAttribute()
    {
        return date('H:i', strtotime($this->start_time)) . ' - ' . date('H:i', strtotime($this->end_time));
    }

    public function getConsultationTypeNameAttribute()
    {
        return match($this->consultation_type) {
            'online' => 'Online (Video Call)',
            'offline' => 'Tatap Muka',
            'chat' => 'Chat',
            default => $this->consultation_type,
        };
    }

    public function isBooked()
    {
        return $this->bookings()->whereIn('status', ['pending', 'confirmed'])->exists();
    }
}
