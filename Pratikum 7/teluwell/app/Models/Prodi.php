<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'prodi';
    protected $primaryKey = 'Idprodi';
    public $incrementing = false;
    protected $keyType = 'string';

    public function fakultas()
    {
        return $this->belongsTo(Fakultas::class, 'Idfakultas');
    }
}