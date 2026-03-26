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
            'employer_name'             => 'nullable|string|max:255',
            'employer_address'          => 'nullable|string|max:191',
            'employer_street'           => 'nullable|string|max:191',
            'employer_house_number'     => 'nullable|string|max:191',
            'employer_city'             => 'nullable|string|max:191',
            'employer_postcode'         => 'nullable|string|max:191',
            'employer_phone'            => 'nullable|string|max:191',
            'employer_mobile'           => 'nullable|string|max:191',
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
