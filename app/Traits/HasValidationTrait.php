<?php

namespace App\Traits;

/**
 * Class HasValidationTrait
 *
 * @package App
 */
trait HasValidationTrait
{
    /**
     * Returns the model's defined validation rules so that they
     * can be used elsewhere, if needed.
     *
     * @param array $options Options
     *
     * @return array
     */
    public function getValidationRules(array $options = []): array
    {
        $rules = $this->validationRules;

        if (isset($options['except']))
        {
            $rules = array_diff_key($rules, array_flip($options['except']));
        }
        elseif (isset($options['only']))
        {
            $rules = array_intersect_key($rules, array_flip($options['only']));
        }

        return $rules;
    }

    /**
     * Returns the model's define validation messages so they
     * can be used elsewhere, if needed.
     *
     * @return array
     */
    public function getValidationMessages(): array
    {
        return $this->validationMessages;
    }
}
