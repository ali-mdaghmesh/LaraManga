<?php

namespace App\Http\Controllers;

use App\Http\Requests\LikeRequest;
use App\Services\LikeService;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function __construct(private LikeService $likeService)
    {
    }

    public function toggle(LikeRequest $request)
    {
        $validatedData = $request->validated();

        $like = $this->likeService->toggle(
            $request->user(),
            $validatedData['manga_id'] ?? null,
            $validatedData['mangadex_id'] ?? null
        );

        if ($like) {
            return $this->successResponse(message: "The like added successfully");
        }

        return $this->deletedResponse("The like deleted successfully");
    }
}