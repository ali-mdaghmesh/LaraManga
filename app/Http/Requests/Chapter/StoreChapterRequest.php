<?php

namespace App\Http\Requests\Chapter;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreChapterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
           'manga_id' => 'required_without:mangadex_id|nullable|uuid|exists:mangas,id|prohibits:mangadex_id',
           'mangadex_id' => 'required_without:manga_id|nullable|string|prohibits:manga_id',

            'chapters' => 'required|array|min:1',
            'chapters.*.chapter_number' => [
                'required',
                'numeric',
                'min:0',
                'distinct',
                Rule::unique('chapters', 'chapter_number')
                    ->where('manga_id', $this->input('manga_id'))
                    ->where('mangadex_id', $this->input('mangadex_id')),
            ],
            'chapters.*.title' => 'nullable|string|max:255',
            'chapters.*.file'  => 'required|file|mimes:pdf|max:51200',
        ];
    }

    public function messages(): array
    {
        return [
            'manga_id.required_without'    => 'Provide either manga_id or mangadex_id.',
            'mangadex_id.required_without' => 'Provide either manga_id or mangadex_id.',
        ];
    }
}