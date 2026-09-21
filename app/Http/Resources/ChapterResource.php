<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChapterResource extends JsonResource
{
    
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'manga_id' => $this->manga_id,
            'chapter_number' => $this->chapter_number, 
            'title' => $this->title, 
            'uploaded_by' => $this->uploaded_by,
            'created_at' => $this->created_at
        ];
    }

}
