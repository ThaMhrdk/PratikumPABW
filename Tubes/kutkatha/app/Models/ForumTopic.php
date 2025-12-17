<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumTopic extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'category',
        'description',
        'is_anonymous',
        'is_pinned',
        'is_closed',
        'views_count',
    ];

    protected $casts = [
        'is_anonymous' => 'boolean',
        'is_pinned' => 'boolean',
        'is_closed' => 'boolean',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function posts()
    {
        return $this->hasMany(ForumPost::class, 'topic_id');
    }

    // Helper methods
    public function getPostsCountAttribute()
    {
        return $this->posts()->count();
    }

    public function getAuthorNameAttribute()
    {
        return $this->is_anonymous ? 'Anonim' : $this->user->name;
    }
}
