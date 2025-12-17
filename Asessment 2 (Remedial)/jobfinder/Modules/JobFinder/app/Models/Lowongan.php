<?php

namespace Modules\JobFinder\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lowongan extends Model
{
    use HasFactory;
    
    /**
     * Nama tabel database
     */
    protected $table = 'lowongans';

    /**
     * Atribut yang dapat diisi massal
     */
    protected $fillable = [
        'posisi',
        'perusahaan',
        'lokasi_kerja',
        'deskripsi',
        'gaji',
    ];

    /**
     * Relasi ke model Lamaran
     */
    public function lamarans()
    {
        return $this->hasMany(Lamaran::class);
    }

    /**
     * Format gaji sebagai mata uang Indonesia
     */
    public function getFormattedGajiAttribute()
    {
        if ($this->gaji) {
            return 'Rp ' . number_format($this->gaji, 0, ',', '.');
        }
        return '-';
    }
}
