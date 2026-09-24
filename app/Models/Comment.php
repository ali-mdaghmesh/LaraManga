<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory; 

    protected $fillable = [
        'user_id', 
        'chapter_id',
        'mangadex_chapter_id', 
        'parent_id',
        'content'
    ];

    function chapter(){
        return $this->belongsTo(Chapter::class); 
    }

    function user(){
        return $this->belongsTo(User::class); 
    }

    public function replyComments()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }
}
