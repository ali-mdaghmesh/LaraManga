<?php

namespace App\Services;

use App\Models\Chapter;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ChapterService
{
    public function getChapters(?string $mangaId = null, ?string $mangadexId = null)
    {
        return Chapter::when($mangaId, fn ($q) => $q->where('manga_id', $mangaId))
            ->when($mangadexId, fn ($q) => $q->where('mangadex_id', $mangadexId))
            ->orderBy('chapter_number')
            ->with('media')
            ->get();
    }



    public function makeChaptersBulk(?string $mangaId, ?string $mangadexId, array $chaptersData, int $uploadedBy)
    {
        return DB::transaction(function () use ($mangaId, $mangadexId, $chaptersData, $uploadedBy) {
            $chapters = collect();

            foreach ($chaptersData as $data) {
                $chapter = Chapter::create([
                    'manga_id' => $mangaId,
                    'mangadex_id' => $mangadexId,
                    'source' => 'local',
                    'chapter_number' => $data['chapter_number'],
                    'title' => $data['title'] ?? null,
                    'uploaded_by' => $uploadedBy,
                ]);

                $chapter->addMedia($data['file'])->toMediaCollection('chapter');

                $chapters->push($chapter->load('media'));
            }

            return $chapters;
        });
    }

    public function editChapter(Chapter $chapter, array $data)
    {
        return DB::transaction(function () use ($chapter, $data) {
            $chapter->update(collect($data)->except('file')->toArray());

            if (isset($data['file'])) {
                $chapter->addMedia($data['file'])->toMediaCollection('chapter');
            }

            return $chapter->load('media');
        });
    }

    public function deleteChapter(Chapter $chapter)     
    {
        $chapter->delete();
    }

    public function getMangaDexChaptersWithLocal(string $mangadexId, MangaDexService $mangaDexService): array
    {
        $externalChapters = collect($mangaDexService->getFeed($mangadexId))
            ->map(fn ($chapter) => [
                'source' => 'mangaDex',
                'chapter_number' => (float) $chapter['chapter_number'],
                'title' => $chapter['title'],
                'mangadex_chapter_id' => $chapter['mangadex_chapter_id'],
                'scanlation_group' => $chapter['scanlation_group'],
                'file_url' => null,
            ]);

        $localChapters = $this->getChapters(null, $mangadexId)
            ->map(fn ($chapter) => [
                'source'              => 'local',
                'chapter_number'      => (float) $chapter->chapter_number,
                'title'               => $chapter->title,
                'mangadex_chapter_id' => null,
                'scanlation_group'    => null,
                'file_url'            => $chapter->getFirstMediaUrl('chapter'),
            ]);

        return $externalChapters
            ->merge($localChapters)
            ->sortBy('chapter_number')
            ->values()
            ->all();
    }
}