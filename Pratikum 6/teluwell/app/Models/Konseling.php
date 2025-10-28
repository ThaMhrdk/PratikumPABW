<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Konseling extends Model
{
    use HasFactory;
    protected $table = 'konseling';
    protected $primaryKey = 'Kodekslg';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;
}