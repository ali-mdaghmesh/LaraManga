<?php

namespace App\Http\Requests\LocalManga;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreMangaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|min:3|max:100',
            'description' => 'nullable|string|min:3|max:255',
            'author_name' => 'nullable|string|min:3|max:100',
            'artist_name' => 'nullable|string|min:3|max:100',
            'cover' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120'
        ];
    }

    public function validated($key = null, $default = null): array
    {
        return array_merge(parent::validated($key, $default), [
            'source' => 'local',
        ]);
    }

}
