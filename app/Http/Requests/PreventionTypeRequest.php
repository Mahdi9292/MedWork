<?php

namespace App\Http\Requests;

use App\Rules\Currency;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PreventionTypeRequest extends FormRequest
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
        // Fetch the preventionType ID from the route for the update ignore logic
        $preventionTypeId = $this->route('preventionType')?->id;

        return [
            'name' => [
                'required',
                'max:191',
                Rule::unique('medical_prevention_types', 'name')->ignore($preventionTypeId),
            ],
            'comment' => 'nullable|max:255',
        ];
    }

    /**
     * Custom German error messages.
     */
    public function messages(): array
    {
        return [
            'name.unique' => 'Dieser Type existiert bereits.',
        ];
    }
}
