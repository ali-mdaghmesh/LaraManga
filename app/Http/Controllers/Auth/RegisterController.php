<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Services\Auth\RegisterService;

class RegisterController extends Controller
{
    public function __construct(private RegisterService $registerService)
    {
    }

    public function register(RegisterRequest $registerRequest)
    {
        $validatedData = $registerRequest->validated(); 
        $data = $this->registerService->register($validatedData); 

        return $this->createdResponse([
            'user'  => new UserResource($data['user']),
            'token' => $data['token'],
        ], 'User registered successfully.');
    }
}