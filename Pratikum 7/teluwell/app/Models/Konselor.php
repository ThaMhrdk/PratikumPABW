<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Konselor extends Authenticatable
{
    use HasFactory, Notifiable;

    public $timestamps = false;
    protected $table = 'konselor';
    protected $primaryKey = 'Idkonselor';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'Idkonselor',
        'emailkons',
        'nmkonselor',
        'spesialisasi',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    public function getEmailAttribute()
    {
        return $this->emailkons;
    }

    public function getNamaAttribute()
    {
        return $this->nmkonselor;
    }
}