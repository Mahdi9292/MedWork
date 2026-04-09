<?php

declare(strict_types=1);

namespace App\View\Components\Form;

use App\Concerns\HandlesValidationErrors;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class Checkboxes extends Component
{
    use HandlesValidationErrors;

    public string $name;
    public string $id;
    public string $label;
    public string $row;
    public string $wrap;
    public string $labelClass;
    public bool $labelAsterisk;
    public mixed $options = [];
    public mixed $value;
    public mixed $selectedKey;

    public function __construct(
        string $name,
        string $id = null,
        $options = [],
        $value = null,
        bool $showErrors = true,
        string $label = '',
        string $labelClass = 'col-sm-2',
        bool $labelAsterisk = false,
        string $row = 'row mb-3',
        string $wrap = 'col-sm-8'
    ) {
        $this->name = $name;
        $this->id = $id ?? $name;
        $this->options = $options;
        $this->showErrors = $showErrors;
        $this->label = $label;
        $this->labelClass = $labelClass;
        $this->labelAsterisk = $labelAsterisk;
        $this->row = $row;
        $this->wrap = $wrap;
        $this->value = old($name, $value ?? []);
        $this->selectedKey = $this->name ? old($this->name, $this->value) : $this->value;

        if (!($this->options instanceof \Illuminate\Database\Eloquent\Collection) && is_array($this->options)) {
            $this->options = collect($this->options);
        }
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
            'form-check-input',
            $this->hasErrorsAndShow($this->name) ? 'is-invalid' : null,
        ])->filter()->implode(' ');
    }

    public function render(): View
    {
        return view('components.forms.inputs.checkboxes');
    }
}
