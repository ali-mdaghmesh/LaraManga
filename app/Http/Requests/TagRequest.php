<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TagRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    
    public function rules(): array
    {
        return [
             'name' => [
                'required',
                'string',
                'min:3',
                'max:50',
                Rule::unique('tags', 'name')->ignore($this->route('tag')),
            ]
        ];
    }
}
