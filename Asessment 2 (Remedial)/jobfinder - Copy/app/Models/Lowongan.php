<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lowongan extends Model
{
    protected $fillable = [
        'posisi',
        'perusahaan',
        'lokasi_kerja',
        'deskripsi',
        'gaji',
    ];

    public function lamarans()
    {
        return $this->hasMany(Lamaran::class);
    }
}
