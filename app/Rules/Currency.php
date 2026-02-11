<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class Currency implements ValidationRule
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
        //if(in_array(trim($value), ['.', ',']) || !preg_match('/^[0-9.,\s]*$/', $value)){
            //$fail('ungültiges Zahlenformat')->translate();
        //}
        if (in_array(trim($value), ['.', ',']) || !preg_match('/^-?[0-9.,\s]*$/', $value)) {
            $fail('ungültiges Zahlenformat')->translate();
        }
    }
}
