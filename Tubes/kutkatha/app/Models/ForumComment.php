<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'user_id',
        'parent_id',
        'content',
        'is_anonymous',
        'is_psikolog_answer',
    ];

    protected $casts = [
        'is_anonymous' => 'boolean',
        'is_psikolog_answer' => 'boolean',
    ];

    // Relationships
    public function post()
    {
        return $this->belongsTo(ForumPost::class, 'post_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parent()
    {
        return $this->belongsTo(ForumComment::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(ForumComment::class, 'parent_id');
    }

    // Helper methods
    public function getAuthorNameAttribute()
    {
        if ($this->is_anonymous) {
            return 'Anonim';
        }

        $name = $this->user->name;
        if ($this->is_psikolog_answer) {
            $name .= ' (Psikolog)';
        }
        return $name;
    }
}
