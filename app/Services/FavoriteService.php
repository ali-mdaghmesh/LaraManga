<?php

namespace App\Services;

use App\Models\Favorite;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class FavoriteService
{
    public function __construct(
        private MangaDexService $mangaDexService,
    ) {
    }

    public function toggle(User $user, ?string $mangaId, ?string $mangadexId): bool
    {
        $favorite = Favorite::where('user_id', $user->id)
            ->where('manga_id', $mangaId)
            ->where('mangadex_id', $mangadexId)
            ->first();

        if ($favorite) {
            $favorite->delete();
            return false;
        }

        Favorite::create([
            'user_id' => $user->id,
            'manga_id' => $mangaId,
            'mangadex_id' => $mangadexId,
        ]);

        return true;
    }

    public function getUserFavorites(User $user, int $perPage = 15): LengthAwarePaginator
    {
        $favorites = Favorite::where('user_id', $user->id)
            ->with('manga')
            ->latest()
            ->paginate($perPage);

        $favorites->getCollection()->transform(function (Favorite $favorite) {
            return $favorite->manga_id
                ? $favorite->manga
                : $this->mangaDexService->getManga($favorite->mangadex_id);
        });

        return $favorites;
    }
}