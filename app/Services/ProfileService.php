<?php 

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Arr;

class ProfileService{

    public function updateProfile(array $data,User $user){
        $profile = $user->profile;

        $profile->update(Arr::except($data, ['avatar']));

        if (isset($data['avatar'])) {
            $profile->addMedia($data['avatar'])->toMediaCollection('avatar');
        }

        return $profile;
    }



}