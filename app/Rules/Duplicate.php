<?php

namespace App\Rules;

use Closure;
use Illuminate\Support\Arr;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;
use Illuminate\Contracts\Validation\ValidatorAwareRule;
use Illuminate\Validation\Validator;

class Duplicate implements DataAwareRule, ValidationRule, ValidatorAwareRule
{
    /**
     * All the data under validation.
     *
     * @var array<string, mixed>
     */
    protected array $data = [];

    /**
     * Name of the Model Class as string which we need to check the duplicates in.
     *
     * @var string
     */
    protected string $modelName;

    /**
     * The validator instance.
     *
     * @var Validator
     */
    protected $validator;

    public function __construct(string $modelName)
    {
        $this->modelName = $modelName;
    }

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
        // e.g. => $attribute = inputs.0.number

        $idAttribute = (new $this->modelName())->getKeyName();

        if(str_contains($attribute, '.')) {
            // get id Attribute of the item (e.g. 'inputs.0.id')
            $prefix = substr($attribute, 0, strrpos($attribute, '.'));
            $idAttribute = $prefix . '.' . (new $this->modelName())->getKeyName();
        }

        // check if the item already exist in database
        $inputId = Arr::get($this->data, $idAttribute, 0);
        $itemExistsInDB = $this->modelName::where('number', '=', $value)
            ->when($inputId, function ($query) use ($inputId) {
                return $query->where('id', '!=', $inputId);
            })
            ->exists();

        // check if the item is a new input and if it already exists
        if($itemExistsInDB){
            $fail('diese Kundennummer existiert bereits')->translate();
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

    /**
     * Set the current validator.
     */
    public function setValidator(Validator $validator): static
    {
        $this->validator = $validator;

        return $this;
    }
}
