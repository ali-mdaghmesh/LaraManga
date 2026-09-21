<?php

namespace App\Http\Requests\LocalManga;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateMangaRequest extends FormRequest
{
  
    public function authorize(): bool
    {
        return true;
    }

    
    public function rules(): array
    {
        return [
            'title' => 'sometimes|required|string|min:3|max:100',
            'description' => 'sometimes|nullable|string|min:3|max:255',
            'author_name' => 'sometimes|nullable|string|min:3|max:100',
            'artist_name' => 'sometimes|nullable|string|min:3|max:100',
            'cover' => 'sometimes|nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ];
    }
}
