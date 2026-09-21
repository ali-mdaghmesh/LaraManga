<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory; 

    protected $fillable = [
        'user_id', 
        'manga_id'
    ];

    public function manga(){
        return $this->hasMany(Manga::class); 
    }

}
