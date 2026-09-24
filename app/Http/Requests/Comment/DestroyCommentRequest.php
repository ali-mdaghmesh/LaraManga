<?php

namespace App\Http\Requests\Comment;

use App\Models\Comment;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class DestroyCommentRequest extends FormRequest
{

    public function authorize(): bool
    {
        $comment = $this->route('comment'); 
        return $comment instanceof Comment && $comment->user_id === $this->user()->id; 
    }


    public function rules(): array
    {
        return [
            
        ];
    }
}
