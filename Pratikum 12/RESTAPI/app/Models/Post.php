<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // kolom-kolom yang boleh diisi secara massal
    protected $fillable = ['title', 'author', 'article', 'image'];
}
