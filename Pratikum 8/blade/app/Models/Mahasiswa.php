<?php

// app/Models/Mahasiswa.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    protected $table = 'mahasiswa';

    // Kolom yang bisa diisi
    protected $fillable = ['nama', 'nim', 'jurusan'];
}
