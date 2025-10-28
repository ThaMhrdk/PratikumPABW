<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeleponKons extends Model
{
    use HasFactory;
    protected $table = 'teleponkons';
    // Model ini punya composite primary key. 
    // Kita set 'telpkons' sebagai PK default, tapi Laravel tidak sepenuhnya support composite.
    protected $primaryKey = 'telpkons'; 
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;
}