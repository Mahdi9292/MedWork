<?php

declare(strict_types=1);
namespace App\View\Components\Form;

use App\Concerns\HandlesValidationErrors;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FlatPickr extends Component
{
    use HandlesValidationErrors;

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
        public bool $labelAsterisk =false,
        public ?string $value = '',
        public string $format = '',
        public string $altFormat = '',
        public ?string $placeholder = null,
        public bool $enableTime = false,
        public bool $time24Hr = true,
        public bool $weekNumbers = false,
        public bool $allowInput = false,
        public bool $disabled = false,
        public array $options = []
    ) {
        $this->id = $id ?? $name;
        $this->value = old($name, $value ?? '');
        $this->format = $this->format ?: ($this->enableTime ? 'Y-m-d H:i' : 'Y-m-d');
        $this->altFormat = $this->altFormat ?: ($this->enableTime ? 'd.m.Y H:i' : 'd.m.Y');
    }

    public function options(): array
    {
        return array_merge([
            'dateFormat' => $this->format,
            'altInput' => true,
            'disableMobile' => true,
            //'static' => true,
            'allowInput' => $this->allowInput,
            'altFormat' => $this->altFormat,
            'enableTime' => $this->enableTime,
            'time_24hr' => $this->time24Hr,
            'weekNumbers' => $this->weekNumbers,
            'locale' => 'de',
        ], $this->options);
    }

    public function jsonOptions(): string
    {
        if (empty($this->options())) {
            return '';
        }

        return json_encode((object) $this->options());
    }

    public function inputClass(): string
    {
        return collect([
            'form-control left-border-radius',
            //$this->hasErrorsAndShow($this->name) ? 'is-invalid' : null,
        ])->filter()->implode(' ');
    }

    public function render(): View
    {
        return view('components.forms.inputs.flat-pickr');
    }
}
