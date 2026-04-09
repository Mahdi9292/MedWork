<?php

namespace App\Http\Requests;

use App\Rules\Currency;
use Illuminate\Foundation\Http\FormRequest;

class EmployerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get validation rules.
     */
    public function rules(): array
    {
        return [
            'name'             => 'nullable|string|max:255',
            'contact_person'   => 'nullable|string|max:255',
            'address'          => 'nullable|string|max:255',
            'street'           => 'nullable|string|max:191',
            'house_number'     => 'nullable|string|max:191',
            'city'             => 'nullable|string|max:191',
            'postcode'         => 'nullable|string|max:191',
            'phone'            => 'nullable|string|max:191',
            'mobile'           => 'nullable|string|max:191',
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
        ];
    }
}
