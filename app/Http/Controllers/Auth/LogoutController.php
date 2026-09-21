<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Auth\LogoutService;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    private $logoutService; 

    public function __construct(LogoutService $logoutService)
    {
        $this->logoutService = $logoutService; 
    }

    function logout(Request $request)
    {
        $user = $request->user(); 
        $this->logoutService->logout($user); 
        $this->successResponse();
    }


    function logoutFromAllDevices(Request $request)
    {
        $user = $request->user(); 
        $this->logoutService->logoutAll($user); 
        $this->successResponse();
    }


}
