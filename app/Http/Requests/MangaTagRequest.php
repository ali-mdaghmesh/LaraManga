<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MangaTagRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tag_ids' => 'required|array',
            'tag_ids.*' => 'integger|distinct|exists:tags,id'
        ];
    }
}