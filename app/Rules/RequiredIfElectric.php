<?php

namespace App\Rules;

use Closure;
use App\Models\Management\Vehicle;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Arr;
use Illuminate\Translation\PotentiallyTranslatedString;

class RequiredIfElectric implements DataAwareRule, ValidationRule
{
    public bool $implicit = true;

    public string $modelField;

    public function __construct($modelField='model_id')
    {
        $this->modelField = $modelField;
    }

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
        $modelField = $this->modelField;

        if(str_contains($attribute, '.')){
            $prefix = substr($attribute, 0, strrpos( $attribute, '.'));
            $modelField = $prefix .'.'. $this->modelField;
        }

        $modelId = Arr::get($this->data, $modelField, 0);

        if($modelId)
        {
            $vehicle = Vehicle::find($modelId);
            if(($vehicle->drive_type ?? null) == 'electric' && !$value){
                $fail('Dieses Feld muss ausgefüllt werden.')->translate();
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
