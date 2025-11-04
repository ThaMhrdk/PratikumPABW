<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fakultas extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'fakultas';
    protected $primaryKey = 'Idfakultas';
    public $incrementing = false;
    protected $keyType = 'string';

    public function prodi()
    {
        return $this->hasMany(Prodi::class, 'Idfakultas');
    }
}