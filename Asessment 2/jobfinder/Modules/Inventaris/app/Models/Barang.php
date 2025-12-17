<?php

namespace Modules\Inventaris\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Inventaris\Database\Factories\BarangFactory;

class Barang extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['nama_barang', 'kode_barang', 'kategori', 'stok', 'harga'];


    // protected static function newFactory(): BarangFactory
    // {
    //     // return BarangFactory::new();
    // }
}
