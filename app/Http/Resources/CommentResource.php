<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id, 
            'chapter_id' => $this->chapter_id, 
            'mangadex_chapter_id' => $this->mangadex_chapter_id, 
            'parent_id' => $this->parent_id,
            'content' => $this->content,
            'created_at' => $this->created_at
        ];
    }
}
