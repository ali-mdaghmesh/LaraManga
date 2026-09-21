<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LastWatching extends Model
{
    use HasFactory; 

    protected $fillable = [
        'user_id', 
        'manga_id', 
        'chapter_id', 
        'last_page_read'
    ];
    
    function user(){
        return $this->belongsTo(User::class); 
    }

    function manga(){
        return $this->hasMany(Manga::class); 
    }

    function chapter(){
        return $this->belongsTo(Chapter::class); 
    }
}
