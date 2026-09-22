<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Http\Resources\ProfileResource;
use App\Services\ProfileService;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    private $profileService; 

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService; 
    }

    public function update(UpdateProfileRequest $updateProfileRequest)
    {
        $validatedData = $updateProfileRequest->validated();

        $profile = $this->profileService->updateProfile($validatedData, $updateProfileRequest->user());

        return $this->successResponse(new ProfileResource($profile), 'Profile updated successfully.');
    }
}
