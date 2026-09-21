<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\UserResource;
use App\Services\Auth\LoginService;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    private $loginService; 

    public function __construct(LoginService $loginService)
    {
        $this->loginService = $loginService; 
    }

    function login(LoginRequest $loginRequest){
        $validatedData = $loginRequest->validated(); 
        $data = $this->loginService->login($validatedData); 
        return [
            'user' => $this->successResponse(new UserResource($data['user'])),
            'token' => $data['token']
        ];
    }

}
