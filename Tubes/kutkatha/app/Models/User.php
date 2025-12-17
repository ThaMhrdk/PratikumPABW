<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'address',
        'photo',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    // Relationships
    public function psikolog()
    {
        return $this->hasOne(Psikolog::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function forumPosts()
    {
        return $this->hasMany(ForumPost::class);
    }

    public function forumTopics()
    {
        return $this->hasMany(ForumTopic::class);
    }

    public function forumComments()
    {
        return $this->hasMany(ForumComment::class);
    }

    public function articles()
    {
        return $this->hasMany(Article::class, 'author_id');
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }

    // Helper methods
    public function isUser()
    {
        return $this->role === 'user';
    }

    public function isPsikolog()
    {
        return $this->role === 'psikolog';
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isPemerintah()
    {
        return $this->role === 'pemerintah';
    }

    public function getPhotoUrlAttribute()
    {
        return $this->photo ? asset('storage/' . $this->photo) : asset('images/default-avatar.png');
    }
}
