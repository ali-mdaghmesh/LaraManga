<?php

namespace App\Http\Requests\Chapter;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateChapterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $chapter = $this->route('chapter');

        return [
            'chapter_number' => [
                'sometimes',
                'numeric',
                'min:0',
                Rule::unique('chapters', 'chapter_number')
                    ->where('manga_id', $chapter->manga_id)
                    ->where('mangadex_id', $chapter->mangadex_id)
                    ->ignore($chapter->id),
            ],
            'title' => 'nullable|string|max:255',
            'file'  => 'sometimes|file|mimes:pdf|max:20480',
        ];
    }
}