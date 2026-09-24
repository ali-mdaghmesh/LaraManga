<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Manga extends Model implements HasMedia
{
    use HasFactory, HasUuids, InteractsWithMedia; 

    protected $fillable = [
        'mangadex_id',
        'title',
        'description',
        'author_name',
        'artist_name',
        'source'
    ];

    function chapters(){
        return $this->hasMany(Chapter::class); 
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'manga_tags');
    }

     public function registerMediaCollections(): void
    {
        $this->addMediaCollection('cover')->singleFile();
    }

    

}
