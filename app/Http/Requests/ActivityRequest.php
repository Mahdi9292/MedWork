<?php

namespace App\Http\Requests;

use App\Rules\Currency;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ActivityRequest extends FormRequest
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
        // Fetch the activity ID from the route for the update ignore logic
        $activityId = $this->route('activity')?->id;

        return [
            'name' => [
                'required',
                'max:191',
                Rule::unique('medical_activities', 'name')->ignore($activityId),
            ],
            'former_name' => 'nullable|max:191',
        ];
    }

    /**
     * Custom German error messages.
     */
    public function messages(): array
    {
        return [
            'name.unique' => 'Dieser Tätigkeit existiert bereits.',
            'name.required' => 'Das Feld "Tätigkeit" ist ein Pflichtfeld.',
        ];
    }
}
