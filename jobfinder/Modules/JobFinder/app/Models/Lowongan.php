<?php

namespace Modules\JobFinder\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lowongan extends Model
{
    use HasFactory;

    /**
     * Nama tabel di database
     */
    protected $table = 'lowongan';

    /**
     * Kolom yang dapat diisi
     */
    protected $fillable = [
        'posisi',
        'perusahaan',
        'lokasi_kerja',
        'deskripsi',
        'gaji'
    ];

    /**
     * Relasi ke lamaran
     */
    public function lamaran(): HasMany
    {
        return $this->hasMany(Lamaran::class, 'lowongan_id');
    }

    /**
     * Format gaji ke rupiah
     */
    public function getGajiFormatAttribute(): string
    {
        return $this->gaji ? 'Rp ' . number_format($this->gaji, 0, ',', '.') : 'Tidak disebutkan';
    }
}
