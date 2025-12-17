<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'topic_id',
        'user_id',
        'content',
        'is_anonymous',
        'is_best_answer',
    ];

    protected $casts = [
        'is_anonymous' => 'boolean',
        'is_best_answer' => 'boolean',
    ];

    // Relationships
    public function topic()
    {
        return $this->belongsTo(ForumTopic::class, 'topic_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(ForumComment::class, 'post_id');
    }

    // Helper methods
    public function getAuthorNameAttribute()
    {
        return $this->is_anonymous ? 'Anonim' : $this->user->name;
    }

    public function incrementViews()
    {
        $this->increment('views_count');
    }
}
