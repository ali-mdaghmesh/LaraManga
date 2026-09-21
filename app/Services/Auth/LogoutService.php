<?php 

namespace App\Services\Auth;

use App\Models\User;

class LogoutService{


    function logout(User $user) :void
    {
        $user->currentAccessToken()->delete();
    }

    public function logoutAll(User $user): void
    {
        $user->tokens()->delete();
    }

}