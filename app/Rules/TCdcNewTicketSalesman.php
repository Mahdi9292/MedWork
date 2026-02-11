<?php

namespace App\Rules;

use Closure;
use App\Enums\TCDC\CustomerType;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class TCdcNewTicketSalesman implements DataAwareRule, ValidationRule
{
    public bool $implicit = true;

    /**
     * All the data under validation.
     *
     * @var array<string, mixed>
     */
    protected array $data = [];

    /**
     * Run the validation rule.
     *
     * @param string $attribute
     * @param mixed $value
     * @param Closure(string): PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (in_array($this->data['newTicket']['customer_type_id'], [CustomerType::EKA->value, CustomerType::NKA->value]) && empty($this->data['newTicket']['ka_manager_id'])) {
            if (empty($value)) {
                $fail('Es muss entweder ein KA Manager oder ein Feldverkäufer ausgewählt werden.');
            }
        }
    }

    /**
     * Set the data under validation.
     *
     * @param  array<string, mixed>  $data
     */
    public function setData(array $data): static
    {
        $this->data = $data;
        return $this;
    }
}
