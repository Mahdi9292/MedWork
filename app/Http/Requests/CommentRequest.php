<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        // Fetch the comment ID from the route for the update ignore logic
        $activityId = $this->route('comment')?->id;

        return [
            'type' => 'nullable',
            'content' => 'nullable',
        ];
    }

    /**
     * Custom German error messages.
     */
    public function messages(): array
    {
        return [
        ];
    }
}
