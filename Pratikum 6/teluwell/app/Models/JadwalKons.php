<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalKons extends Model
{
    use HasFactory;
    protected $table = 'jadwalkons';
    protected $primaryKey = 'Idjadwal_kons';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;
}