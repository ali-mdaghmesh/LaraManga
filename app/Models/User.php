<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $fillable = [
        'email',
        'password',
        'role',
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
        ];
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function uploadedChapters()
    {
        return $this->hasMany(Chapter::class, 'uploaded_by');
    }

    public function favorites()
    {
        return $this->belongsToMany(Manga::class, 'favorites')
            ->withPivot('added_at');
    }

    public function laterToWatch()
    {
        return $this->belongsToMany(Manga::class, 'later_to_watch')
            ->withPivot('added_at');
    }

    public function likedMangas()
    {
        return $this->belongsToMany(Manga::class, 'likes');
    }
}