<?php

namespace App\Http\Requests\Comment;

use App\Models\Comment;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCommentRequest extends FormRequest
{

    public function authorize(): bool
    {

         $comment = $this->route('comment');

        return $comment instanceof Comment && $comment->user_id === $this->user()->id;
    }

    public function rules(): array
    {
        return [
            'content' => 'required|string|min:1|max:2000',
        ];
    }
}
