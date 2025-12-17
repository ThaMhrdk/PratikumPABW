<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Psikolog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'str_number',
        'specialization',
        'bio',
        'education',
        'certifications',
        'experience_years',
        'consultation_fee',
        'verification_status',
        'verified_at',
        'str_document',
        'certificate_document',
        'average_rating',
        'total_reviews',
    ];

    protected $casts = [
        'verified_at' => 'datetime',
        'consultation_fee' => 'decimal:2',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    // Helper methods
    public function isVerified()
    {
        return $this->verification_status === 'verified';
    }

    public function isPending()
    {
        return $this->verification_status === 'pending';
    }

    public function getAverageRatingAttribute()
    {
        $bookings = $this->schedules()
            ->with('bookings.consultation.feedback')
            ->get()
            ->pluck('bookings')
            ->flatten();

        $ratings = $bookings->map(function($booking) {
            return $booking->consultation?->feedback?->rating;
        })->filter();

        return $ratings->count() > 0 ? round($ratings->avg(), 1) : 0;
    }

    public function getTotalConsultationsAttribute()
    {
        return $this->schedules()
            ->withCount(['bookings' => function($q) {
                $q->where('status', 'completed');
            }])
            ->get()
            ->sum('bookings_count');
    }
}
