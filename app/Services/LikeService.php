<?php

namespace App\Services;

use App\Models\Like;
use App\Models\User;

class LikeService
{
    public function toggle(User $user, ?string $mangaId, ?string $mangadexId)
    {
        $like = Like::where('user_id', $user->id)
            ->where('manga_id', $mangaId)
            ->where('mangadex_id', $mangadexId)
            ->first();

        if ($like) {
            $like->delete();

            return false;
        }

        Like::create([
            'user_id'     => $user->id,
            'manga_id'    => $mangaId ?? null,
            'mangadex_id' => $mangadexId ?? null,
        ]);

        return true; 
    }
}