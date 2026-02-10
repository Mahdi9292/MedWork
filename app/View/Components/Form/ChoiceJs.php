<?php

declare(strict_types=1);
namespace App\View\Components\Form;

use App\Concerns\HandlesValidationErrors;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class ChoiceJs extends Component
{
    use HandlesValidationErrors;

    public mixed $selectedKey;

    public function __construct(
        public string $name,
        public ?string $id = null,
        public string $type = 'text',
        public string $wrap = 'col-sm-8',
        public string $row = 'row mb-3',
        public string $leadingAddon = '',
        public string $leadingIcon = '',
        public string $trailingAddon = '',
        public string $trailingIcon = '',
        public string $label='',
        public string $labelClass ='col-sm-2',
        public mixed $value = '',
        public ?string $placeholder = null,
        public bool $isInvalid = false,
        public bool $multiple = false,
        public bool $addNullRow = true,
        public mixed $options = [],
        public array $configurations = []
    ) {
        $this->name = $multiple ? $name.'[]' : $name;
        $this->id = $id ?? $name;
        $this->value = old($name, $value ?? '');

        $this->selectedKey = $this->getSelectedKey();

        if($this->addNullRow) {
            $this->options->prepend(__('Please Select'), null);
        }
    }

    private function getSelectedKey()
    {
        $selectedValue = $this->name ? old($this->name, $this->value) : $this->value;

        // handing multiple selection
        if($this->multiple && !is_array($selectedValue))
        {
            if($selectedValue instanceof Collection) {
                return $selectedValue->toArray();
            }

            $selectedValue = json_decode($selectedValue);
        }

        return $selectedValue;
    }

    public function configurations(): array
    {
        return array_merge([
            'removeItemButton' => true,
        ], $this->configurations);
    }

    public function jsonOptions(): string
    {
        if (empty($this->configurations())) {
            return '';
        }

        return json_encode((object) $this->configurations());
    }

    public function isSelected($key): bool
    {
        if ($this->selectedKey == $key) {
            return true;
        }

        return is_array($this->selectedKey) && in_array($key, $this->selectedKey, false);
    }

    public function inputClass(): string
    {
        return collect([
            'form-control',
            $this->hasErrorsAndShow($this->name) ? 'is-invalid' : null,
        ])->filter()->implode(' ');
    }

    public function convertToStringArray($values): array
    {
        $values = json_decode((string)$values);

        if(!is_array($values)){
            return [(string)$values];
        }

        // for multiple
        $stringArray = [];

        foreach ($values as $value){
            $stringArray[] = (string)$value;
        }

        return $stringArray;
    }

    public function render(): View
    {
        return view('components.forms.inputs.choice-js');
    }
}
