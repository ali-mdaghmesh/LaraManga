<?php

namespace App\Http\Controllers;

use App\Services\ChapterService;
use App\Services\MangaDexService;
use Illuminate\Http\Request;

class MangaDexController extends Controller
{
    public function __construct(
        private MangaDexService $mangaDexService,
        private ChapterService $chapterService,
    ) {
    }

    public function search(Request $request)
    {
        $request->validate(['title' => 'required|string|min:2']);

        $results = $this->mangaDexService->search($request->query('title'));

        return $this->successResponse($results);
    }

    public function show(string $mangadexId)
    {
        $manga = $this->mangaDexService->getManga($mangadexId);

        return $this->successResponse($manga);
    }

    public function chapterPages(string $chapterId)
    {
        $pages = $this->mangaDexService->getChapterPages($chapterId);

        return $this->successResponse($pages);
    }
}