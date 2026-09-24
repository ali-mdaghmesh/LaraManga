<?php

namespace App\Http\Requests\Comment;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
{
  
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'chapter_id' => 'required_without:mangadex_chapter_id|nullable|integer|exists:chapters,id|prohibits:mangadex_chapter_id',
            'mangadex_chapter_id' => 'required_without:chapter_id|nullable|string|prohibits:chapter_id',
            'parent_id' => 'nullable|integer|exists:comments,id',
            'content' => 'required|string|min:1|max:2000'
        ];
    }
}
