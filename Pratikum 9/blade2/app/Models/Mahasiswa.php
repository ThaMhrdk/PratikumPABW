<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'mahasiswas'; // nama tabel yang dihubungkan

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ // kolom yang akan diolah pada controller, jika mau ditambah
                            // maka tambahkan, namun untuk id tidak perlu, karena sudah automatis
        'nama',
        'nim',
        'prodi'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [ // mengubah tipe data dari kolom di database ke tipe data
                         // PHP sehingga bisa mengambil data parsial, seperti ambil tanggalnya saja atau
                         // jamnya saja.
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
