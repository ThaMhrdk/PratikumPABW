<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'payment_code',
        'amount',
        'payment_method',
        'status',
        'proof_of_payment',
        'paid_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($payment) {
            $payment->payment_code = 'PAY-' . strtoupper(Str::random(10));
        });
    }

    // Relationships
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    // Helper methods
    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'pending' => '<span class="badge bg-warning">Menunggu Pembayaran</span>',
            'paid' => '<span class="badge bg-success">Sudah Dibayar</span>',
            'failed' => '<span class="badge bg-danger">Gagal</span>',
            'refunded' => '<span class="badge bg-info">Dikembalikan</span>',
            default => '<span class="badge bg-secondary">' . $this->status . '</span>',
        };
    }

    public function getFormattedAmountAttribute()
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }

    public function getPaymentMethodNameAttribute()
    {
        return match($this->payment_method) {
            'transfer' => 'Transfer Bank',
            'ewallet' => 'E-Wallet',
            'cash' => 'Tunai',
            default => $this->payment_method,
        };
    }
}
