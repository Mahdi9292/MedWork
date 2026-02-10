<?php

declare(strict_types=1);

namespace App\View\Components\Form;

use App\Concerns\HandlesValidationErrors;
use Illuminate\View\Component;
use Barryvdh\Debugbar;

class Select extends Component
{
    use HandlesValidationErrors;

    /** @var string */
    public string $name;

    /** @var string */
    public string $id;

    /** @var string */
    public string $label;

    /** @var string */
    public string $row;

    /** @var string */
    public string $wrap;

    /** @var string */
    public string $labelClass;

    /** @var bool */
    public bool $labelAsterisk;

    /** @var bool */
    public bool $multiple = false;

    /** @var bool */
    public bool $addNullRow = true;

    /** @var string */
    public string $nullRowText;

    public mixed $nullRowValue=null;

    public mixed $value;

    public mixed $selectedKey;

    public mixed $options = [];

    public function __construct(
        string $name,
        string $id = null,
        $options = [],
        $value = null,
        bool $multiple = false,
        bool $addNullRow = true,
        string $nullRowText = "Bitte auswählen",
        mixed $nullRowValue = null,
        bool $showErrors = true,
        string $label='',
        string $labelClass ='col-sm-2',
        bool $labelAsterisk =false,
        string $row ='row mb-3',
        string $wrap ='col-sm-8'
    )
    {
        $this->name = $multiple ? $name.'[]' : $name;
        $this->id = $id ?? $name;
        $this->options = $options;
        $this->multiple = $multiple;
        $this->addNullRow = $addNullRow;
        $this->nullRowText = $nullRowText;
        $this->showErrors = $showErrors;
        $this->label = $label;
        $this->labelClass = $labelClass;
        $this->labelAsterisk = $labelAsterisk;
        $this->row = $row;
        $this->wrap = $wrap;
        $this->value = old($name, $value ?? '');
        $this->selectedKey = $this->name ? old($this->name, $this->value) : $this->value;
        $this->nullRowValue = $nullRowValue;

        if ($this->addNullRow) {
            if (!($this->options instanceof \Illuminate\Database\Eloquent\Collection)) {
                $this->options = collect($this->options);
            }
            $this->options->prepend(__($this->nullRowText), $this->nullRowValue);
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
            'form-select',
            $this->hasErrorsAndShow($this->name) ? 'is-invalid' : null,
        ])->filter()->implode(' ');
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.forms.inputs.select');
    }
}
