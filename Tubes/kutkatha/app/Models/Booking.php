<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'schedule_id',
        'booking_code',
        'status',
        'complaint',
        'notes',
        'confirmed_at',
        'cancelled_at',
        'cancel_reason',
    ];

    protected $casts = [
        'confirmed_at' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($booking) {
            $booking->booking_code = 'KTH-' . strtoupper(Str::random(8));
        });
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function consultation()
    {
        return $this->hasOne(Consultation::class);
    }

    // Helper methods
    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'pending' => '<span class="badge bg-warning">Menunggu Konfirmasi</span>',
            'confirmed' => '<span class="badge bg-info">Dikonfirmasi</span>',
            'completed' => '<span class="badge bg-success">Selesai</span>',
            'cancelled' => '<span class="badge bg-danger">Dibatalkan</span>',
            'rescheduled' => '<span class="badge bg-secondary">Dijadwalkan Ulang</span>',
            default => '<span class="badge bg-secondary">' . $this->status . '</span>',
        };
    }

    public function isPaid()
    {
        return $this->payment && $this->payment->status === 'paid';
    }

    public function canBeCancelled()
    {
        return in_array($this->status, ['pending', 'confirmed']);
    }
}
