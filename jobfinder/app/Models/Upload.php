<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    protected $fillable = ['filename', 'filepath', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
