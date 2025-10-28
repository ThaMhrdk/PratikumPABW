<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeleponMhs extends Model
{
    use HasFactory;
    protected $table = 'teleponmhs';
    protected $primaryKey = 'telpmhs';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;
}