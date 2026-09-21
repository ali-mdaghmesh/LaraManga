<?php

namespace App\Services;

use App\Models\Manga;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Collection;

class MangaTagService
{
    public function getTags(Manga $manga): Collection
    {
        return $manga->tags()->orderBy('name')->get();
    }

    public function attachTags(Manga $manga, array $tagIds)
    {
        $manga->tags()->syncWithoutDetaching($tagIds);

        return $this->getTags($manga);
    }

    public function syncTags(Manga $manga, array $tagIds)
    {
        $manga->tags()->sync($tagIds);

        return $this->getTags($manga);
    }

    public function detachTag(Manga $manga, Tag $tag)
    {
        $manga->tags()->detach($tag->id);
    }
}