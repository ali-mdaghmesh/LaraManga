<?php

namespace App\Models;

use Dom\Comment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Chapter extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'manga_id', 
        'mangadex_id', 
        'source',
        'chapter_number', 
        'title',
        'uploaded_by'
    ];

    function manga(){
        return $this->belongsTo(Manga::class); 
    }

    function comments(){
        return $this->hasMany(Comment::class); 
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('chapter')
            ->singleFile()
            ->acceptsMimeTypes(['application/pdf']);
    }

}
