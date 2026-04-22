<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InvoiceItemTypeRequest extends FormRequest
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
        $invoiceItemTypeId = $this->route('invoiceItemType')?->id;

        return [
            'name' => [
                'required',
                'max:191',
                Rule::unique('finance_invoice_item_types', 'name')->ignore($invoiceItemTypeId),
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
