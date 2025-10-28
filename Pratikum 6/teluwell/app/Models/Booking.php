<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $table = 'booking';
    protected $primaryKey = 'Idbooking';
    protected $keyType = 'string';
    public $incrementing = false;
    
    // Tabel ini TIDAK punya created_at/updated_at, tapi punya timestamp lain
    // Jadi kita tetap matikan timestamp default Laravel
    public $timestamps = false; 
}