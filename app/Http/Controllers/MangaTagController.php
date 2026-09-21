<?php

namespace App\Http\Controllers;

use App\Http\Requests\MangaTagRequest;
use App\Http\Resources\TagResource;
use App\Models\Manga;
use App\Models\Tag;
use App\Services\MangaTagService;

class MangaTagController extends Controller
{
    public function __construct(private MangaTagService $mangaTagService)
    {
    }

    public function index(Manga $manga)
    {
        $tags = $this->mangaTagService->getTags($manga);

        return $this->successResponse(TagResource::collection($tags));
    }

    public function store(MangaTagRequest $request, Manga $manga)
    {
        $tags = $this->mangaTagService->attachTags($manga, $request->validated('tag_ids'));

        return $this->successResponse(TagResource::collection($tags), 'Tags added successfully.');
    }

    public function update(MangaTagRequest $request, Manga $manga)
    {
        $tags = $this->mangaTagService->syncTags($manga, $request->validated('tag_ids'));

        return $this->successResponse(TagResource::collection($tags), 'Tags updated successfully.');
    }

    public function destroy(Manga $manga, Tag $tag)
    {
        $this->mangaTagService->detachTag($manga, $tag);

        return $this->deletedResponse('Tag removed from manga successfully.');
    }
}