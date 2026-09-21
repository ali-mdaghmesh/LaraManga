<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    
    public function rules(): array
    {
        return [
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'full_name' => 'required|string|min:3|max:100',
            'birthdate' => 'required|date|before_or_equal:today',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'

        ];
    }
}
