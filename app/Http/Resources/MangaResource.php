<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Ramsey\Collection\Collection;

class MangaResource extends JsonResource
{
    
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'mangadex_id' => $this->mangadex_id,
            'title' => $this->title,
            'description' => $this->description,
            'author_name' => $this->author_name,
            'artist_name' => $this->artist_name,
            'cover_url' => $this->getFirstMediaUrl('cover'),
            'created_at' => $this->created_at,
            'chapters' => ChapterResource::collection($this->whenLoaded('chapters')),
        ];
    }

}
