<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Mahasiswa extends Authenticatable
{
    use HasFactory, Notifiable;

    public $timestamps = false;
    protected $table = 'mahasiswa';
    protected $primaryKey = 'nim';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nim',
        'email',
        'nmdepan',
        'nmbelakang',
        'jk',
        'Idprodi',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    public function getNamaAttribute()
    {
        return $this->nmdepan . ' ' . $this->nmbelakang;
    }
}