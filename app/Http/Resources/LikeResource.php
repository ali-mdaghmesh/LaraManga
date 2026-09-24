<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LikeResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id, 
            'user_id' => $this->user_id, 
            'manga_id' => $this->manga_id,
            'mangadex_id' => $this->mangadex_id,
            'created_at' => $this->created_at
        ]; 
    }
}
