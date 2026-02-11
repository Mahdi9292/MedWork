<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;
use Validator;

class Emails implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  Closure(string): PotentiallyTranslatedString  $fail
     * @return void
     */

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $emails = array_map('trim', explode(';', $value));
        $validator = Validator::make(['emails' => $emails], ['emails.*' => 'nullable|email:rfc,filter']);
        if ($validator->fails()) {
            $fail('Ungültige E-Mail-Adressen.');
        }
    }
}
