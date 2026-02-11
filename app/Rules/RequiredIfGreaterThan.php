<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class RequiredIfGreaterThan implements DataAwareRule, ValidationRule
{
    public bool $implicit = true;

    /**
     * All the data under validation.
     *
     * @var array<string, mixed>
     */
    protected array $data = [];

    public string $modelField;
    public string $collectionName;

    public function __construct($modelField='amount', $collectionName='inputs')
    {
        $this->modelField= $modelField;
        $this->collectionName = $collectionName;
    }

    /**
     * Run the validation rule.
     *
     * @param string $attribute
     * @param mixed $value
     * @param Closure(string): PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $fieldName = $this->modelField;
        $fieldValue = $this->data[$fieldName] ?? null;

        if(str_contains($attribute, '.')){
            $fieldValue = $this->data[$this->collectionName][$fieldName] ?? null;

            if(!$fieldValue){
                $prefix = substr($attribute, 0, strrpos( $attribute, '.'));
                $parts = explode('.', $prefix);

                // preg_match("/inputs\.(\d+)\.category/", $attribute, $matches);

                $index = $parts[1] ?? null;
                $fieldValue = $this->data[$this->collectionName][$index][$this->modelField];
            }
        }

        if ($fieldValue) {
            $amount = parseNumber(formatNumber(trim($fieldValue)));

            // Fail If amount > 0 and category is empty or only spaces
            if (!empty($amount) && is_numeric($amount) && $amount > 0 && empty(trim($value))) {
                $fail("Dieses Feld ist erforderlich, wenn der Betrag größer als null ist.");
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
