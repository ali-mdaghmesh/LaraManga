<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class MangaDexService
{
    private string $baseUrl = 'https://api.mangadex.org';

    public function search(string $title, int $limit = 30)
    {
        $response = Http::get("{$this->baseUrl}/manga", [
            'title' => $title,
            'limit' => $limit,
            'includes' => ['cover_art', 'author', 'artist'],
            'order' => ['relevance' => 'desc'],
        ]);

        $response->throw();

        return collect($response->json('data'))
            ->map(fn ($manga) => $this->formatManga($manga))
            ->all();
    }

    public function getManga(string $mangadexId)
    {
        $response = Http::get("{$this->baseUrl}/manga/{$mangadexId}", [
            'includes' => ['cover_art', 'author', 'artist'],
        ]);

        $response->throw();

        return $this->formatManga($response->json('data'));
    }

    public function getFeed(string $mangadexId, string $language = 'ar', int $limit = 100, int $offset = 0): array
    {
        $response = Http::get("{$this->baseUrl}/manga/{$mangadexId}/feed", [
            'translatedLanguage' => [$language],
            'order' => ['chapter' => 'asc'],
            'limit' => $limit,
            'offset' => $offset,
            'includes' => ['scanlation_group'],
        ]);

        $response->throw();

        return collect($response->json('data'))
            ->map(fn ($chapter) => $this->formatChapter($chapter))
            ->all();
    }

    public function getChapterPages(string $chapterId, bool $dataSaver = false): array
    {
        return Cache::remember("mangadex:pages:{$chapterId}:" . ($dataSaver ? 'saver' : 'full'), 840, function () use ($chapterId, $dataSaver) {
            $response = Http::get("{$this->baseUrl}/at-home/server/{$chapterId}");
            $response->throw();

            $data = $response->json();
            $baseUrl = $data['baseUrl'];
            $hash = $data['chapter']['hash'];
            $quality = $dataSaver ? 'data-saver' : 'data';
            $filenames = $dataSaver ? $data['chapter']['dataSaver'] : $data['chapter']['data'];

            return collect($filenames)
                ->map(fn ($filename) => "{$baseUrl}/{$quality}/{$hash}/{$filename}")
                ->all();
        });
    }

    private function formatManga(array $manga)
    {
        $attributes = $manga['attributes'];
        $coverFileName = collect($manga['relationships'] ?? [])
            ->firstWhere('type', 'cover_art')['attributes']['fileName'] ?? null;

        return [
            'mangadex_id' => $manga['id'],
            'title' => $attributes['title']['ar']
                ?? reset($attributes['title'])
                ?? 'Untitled',
            'description' => $attributes['description']['ar'] ?? null,
            'status' => $attributes['status'],
            'year' => $attributes['year'],
            'tags' => collect($attributes['tags'])
                ->map(fn ($tag) => $tag['attributes']['name']['ar'] ?? null)    
                ->filter()
                ->values()
                ->all(),
            'cover_url' => $coverFileName
                ? "https://uploads.mangadex.org/covers/{$manga['id']}/{$coverFileName}.256.jpg"
                : null,
        ];
    }

    private function formatChapter(array $chapter): array
    {
        $attributes = $chapter['attributes'];
        $group = collect($chapter['relationships'] ?? [])
            ->firstWhere('type', 'scanlation_group')['attributes']['name'] ?? null;

        return [
            'mangadex_chapter_id' => $chapter['id'],
            'chapter_number' => $attributes['chapter'],
            'volume' => $attributes['volume'],
            'title' => $attributes['title'],
            'language' => $attributes['translatedLanguage'],
            'pages_count' => $attributes['pages'],
            'scanlation_group' => $group,
            'published_at' => $attributes['publishAt'],
        ];
    }
}