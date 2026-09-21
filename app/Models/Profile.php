<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Profile extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia; 

    protected $fillable = [
        'user_id',
        'full_name',
        'birthdate',

    ];

    protected $casts = [
    'birthdate' => 'date',
    ];

    function user(){
        return $this->belongsTo(User::class);  
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatar')
            ->singleFile() ;
           // ->useFallbackUrl(asset('images/default-avatar.png')); 
    }
}
