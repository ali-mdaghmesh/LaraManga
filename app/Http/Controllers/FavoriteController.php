<?php

namespace App\Http\Controllers;

use App\Http\Requests\FavoriteRequest;
use App\Http\Resources\MangaResource;
use App\Services\FavoriteService;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function __construct(private FavoriteService $favoriteService)
    {
    }

    public function toggle(FavoriteRequest $request)
    {
        $validatedData = $request->validated();
        $favorite = $this->favoriteService->toggle($request->user(), $validatedData['manga_id'] ?? null, $validatedData['mangadex_id'] ?? null);

        if ($favorite) {
            return $this->successResponse(message: "The favorite added successfully.");
        }

        return $this->deletedResponse("The favorite deleted successfully");
    }

    public function getFavorites(Request $request)
    {
        $favorites = $this->favoriteService->getUserFavorites($request->user());

        return $this->paginatedResponse($favorites, MangaResource::class, "Favorites list:");
    }
}