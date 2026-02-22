<?php

namespace App\Http\Requests;

use App\Rules\Currency;
use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends FormRequest
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
            // =========================
            // Invoice header
            // =========================
            'invoice_number' => 'required',
            'invoice_date'   => 'required',

            'name'           => 'required',
            'street'         => 'required',
            'house_number'   => 'required',
            'postcode'       => 'required',
            'city'           => 'required',
            'phone'          => 'nullable',
            'mobile'         => 'nullable',

            // =========================
            // Services (HasMany)
            // =========================
            'services.*.id' => 'nullable|integer|exists:invoice_services,id', //just to get it during the update
            'services.*.service_type'    => 'required',
            'services.*.service_title'   => 'nullable',
            'services.*.description'     => 'nullable',
            'services.*.service_date'    => 'required',
            'services.*.quantity'        => 'required',
            'services.*.unit_price'      => ['required', new Currency],
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [

            // Invoice
            'invoice_date.required' => 'Rechnungsdatum muss ausgefüllt werden.',
            'name.required'         => 'Name muss ausgefüllt werden.',
            'street.required'       => 'Straße muss ausgefüllt werden.',
            'house_number.required' => 'Hausnummer muss ausgefüllt werden.',
            'postcode.required'     => 'PLZ muss ausgefüllt werden.',
            'city.required'         => 'Stadt muss ausgefüllt werden.',

            // Services
            'services.required'                     => 'Mindestens eine Leistung muss hinzugefügt werden.',
            'services.array'                        => 'Leistungen sind ungültig formatiert.',
            'services.*.service_type.required'      => 'Leistungsart muss ausgefüllt werden.',
            'services.*.service_title.required'     => 'Leistungstitel muss ausgefüllt werden.',
            'services.*.service_date.required'      => 'Leistungsdatum muss ausgefüllt werden.',
            'services.*.service_date.date_format'   => 'Leistungsdatum muss im Format TT.MM.JJJJ sein.',
            'services.*.quantity.required'          => 'Menge muss ausgefüllt werden.',
            'services.*.quantity.numeric'           => 'Menge muss eine Zahl sein.',
            'services.*.unit_price.required'        => 'Einzelpreis muss ausgefüllt werden.',
            'services.*.unit_price.numeric'         => 'Einzelpreis muss eine Zahl sein.',
        ];
    }
}
