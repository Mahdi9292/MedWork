<?php

namespace App\Http\Requests;

use App\Rules\Currency;
use Illuminate\Foundation\Http\FormRequest;

class CertificateRequest extends FormRequest
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
            'salutation' => 'nullable',

            'title' => 'nullable|string|max:191',
            'first_name' => 'required|string|max:191',
            'middle_name' => 'nullable|string|max:191',
            'last_name' => 'required|string|max:191',

            'employed_at' => 'nullable|string|max:255',
            'employer_street' => 'nullable|string|max:191',
            'employer_house_number' => 'nullable|string|max:191',
            'employer_city' => 'nullable|string|max:191',
            'employer_postcode' => 'nullable|string|max:191',

            'phone' => 'nullable|string|max:191',
            'mobile' => 'nullable|string|max:191',

            'certificate_number' => 'required|string|max:191',

            'birthday' => 'nullable',
            'issue_date' => 'nullable',

            // =========================
            // Preventions (HasMany)
            // =========================
            'preventions.*.id' => 'nullable|integer|exists:medical_preventions,id', //just to get it during the update
            'preventions.*.activity_id'    => 'required',
            'preventions.*.prevention_type'   => 'required',
            'preventions.*.next_appointment_date'     => 'required',
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
