<?php

namespace Modules\JobFinder\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lamaran extends Model
{
    use HasFactory;
    
    /**
     * Nama tabel database
     */
    protected $table = 'lamarans';

    /**
     * Atribut yang dapat diisi massal
     */
    protected $fillable = [
        'user_id',
        'lowongan_id',
        'deskripsi_lamaran',
        'cv_file',
    ];

    /**
     * Relasi ke model User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke model Lowongan
     */
    public function lowongan()
    {
        return $this->belongsTo(Lowongan::class);
    }

    /**
     * Mendapatkan URL file CV
     */
    public function getCvUrlAttribute()
    {
        if ($this->cv_file) {
            return asset('storage/' . $this->cv_file);
        }
        return null;
    }
}
