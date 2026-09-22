<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'full_name' => 'sometimes|string|min:3|max:100',
            'birthdate' => 'sometimes|date|before:today',
            'avatar'    => 'sometimes|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];
    }
}