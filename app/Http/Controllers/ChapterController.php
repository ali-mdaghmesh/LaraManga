<?php

namespace App\Http\Controllers;

use App\Http\Requests\Chapter\StoreChapterRequest;
use App\Http\Requests\Chapter\UpdateChapterRequest;
use App\Http\Resources\ChapterResource;
use App\Models\Chapter;
use App\Services\ChapterService;
use App\Services\MangaDexService;
use Illuminate\Http\Request;

class ChapterController extends Controller
{
    private $chapterService;

    public function __construct(ChapterService $chapterService)
    {
        $this->chapterService = $chapterService;
    }

    public function index(Request $request)
    {
        $request->validate([
            'manga_id'    => 'required_without:mangadex_id|nullable|uuid',
            'mangadex_id' => 'required_without:manga_id|nullable|string',
        ]);

        $chapters = $this->chapterService->getChapters(
            $request->query('manga_id'),
            $request->query('mangadex_id')
        );

        return $this->successResponse(ChapterResource::collection($chapters));
    }

    public function mangadexChaptersWithLocal(string $mangadexId, MangaDexService $mangaDexService)
    {
        $chapters = $this->chapterService->getMangaDexChaptersWithLocal($mangadexId, $mangaDexService);

        return $this->successResponse($chapters);
    }

    public function storeBulk(StoreChapterRequest $request)
    {
        $chapters = $this->chapterService->makeChaptersBulk(
            $request->validated('manga_id'),
            $request->validated('mangadex_id'),
            $request->validated('chapters'),
            $request->user()->id
        );

        return $this->createdResponse(ChapterResource::collection($chapters), 'Chapters created successfully.');
    }

    public function update(UpdateChapterRequest $request, Chapter $chapter)
    {
        $chapter = $this->chapterService->editChapter($chapter, $request->validated());

        return $this->successResponse(new ChapterResource($chapter), 'Chapter updated successfully.');
    }

    public function destroy(Chapter $chapter)
    {
        $this->chapterService->deleteChapter($chapter);
        return $this->deletedResponse("The chapter deleted successfully.");
    }
}