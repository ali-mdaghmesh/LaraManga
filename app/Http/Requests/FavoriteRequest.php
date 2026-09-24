<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class FavoriteRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'manga_id' => 'required_without:mangadex_id|uuid|nullable|exists:mangas,id|prohibits:mangadex_id',
            'mangadex_id' => 'required_without:manga_id|string|nullable|prohibits:manga_id',
        ];
    }
}
