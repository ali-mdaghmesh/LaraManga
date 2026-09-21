<?php

namespace App\Services\Auth; 

use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Exception; 

class LoginService{

    function login(array $data){
        $user = User::with('profile')
                    ->where('email', $data['email'])
                    ->firstOrFail();

       if (! Hash::check($data['password'], $user->password)) {
        throw ValidationException::withMessages([
            'password' => ['The provided password is incorrect.'],
        ]);
        }

        return [
            'user' => $user,
            'token' => $user->createToken('api-token')->plainTextToken,
        ];
    }   

}