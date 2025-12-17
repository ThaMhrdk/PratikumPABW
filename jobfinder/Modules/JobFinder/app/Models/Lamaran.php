<?php

namespace Modules\JobFinder\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class Lamaran extends Model
{
    use HasFactory;

    /**
     * Nama tabel di database
     */
    protected $table = 'lamaran';

    /**
     * Kolom yang dapat diisi
     */
    protected $fillable = [
        'user_id',
        'lowongan_id',
        'deskripsi_lamaran',
        'cv_file',
        'status'
    ];

    /**
     * Relasi ke user (pelamar)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi ke lowongan
     */
    public function lowongan(): BelongsTo
    {
        return $this->belongsTo(Lowongan::class, 'lowongan_id');
    }

    /**
     * Get status badge class
     */
    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'pending' => 'bg-warning',
            'diterima' => 'bg-success',
            'ditolak' => 'bg-danger',
            default => 'bg-secondary'
        };
    }

    /**
     * Get status label
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending' => 'Menunggu',
            'diterima' => 'Diterima',
            'ditolak' => 'Ditolak',
            default => 'Unknown'
        };
    }
}
