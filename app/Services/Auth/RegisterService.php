<?php

namespace App\Services\Auth;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterService
{
    public function register(array $data): array
    {
        return DB::transaction(function () use ($data) {
            $user = User::create([
                'email'    => $data['email'],
                'password' => Hash::make($data['password']),
            ]);
            $profile = Profile::create([
                'user_id' => $user->id,
                'full_name' => $data['full_name'],
                'birthdate' => $data['birthdate'],
            ]);

            if (isset($data['avatar'])) {
                $profile->addMedia($data['avatar'])->toMediaCollection('avatar');
            }

            $token = $user->createToken('api-token')->plainTextToken;

            return [
                'user'  => $user->load('profile'),
                'token' => $token,
            ];
        });
    }
}