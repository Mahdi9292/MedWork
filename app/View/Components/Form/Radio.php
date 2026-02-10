<?php

declare(strict_types=1);
namespace App\View\Components\Form;

use App\Concerns\HandlesValidationErrors;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Radio extends Component
{
    use HandlesValidationErrors;

    /** @var string */
    public string $name;

    /** @var string */
    public string $id;

    /** @var string */
    public string $label;

    /** @var string */
    public string $radioLabel;

    /** @var string */
    public string $value;

    /** @var string */
    public string $row;

    /** @var string */
    public string $wrap;

    /** @var string */
    public string $labelClass;

    /** @var string */
    public string $info;

    /** @var bool */
    public bool $switch;

    /** @var bool */
    public bool|null $checked;

    public function __construct(
        string $name,
        string $id = null,
        bool $showErrors = true,
        string $label='',
        string $radioLabel='',
        string $value='',
        string $labelClass ='col-sm-2',
        string $info='',
        string $row ='',
        string $wrap ='',
        bool $switch = false,
        bool|null $checked = false
    )
    {
        $this->name = $name;
        $this->id = $id ?? $name;
        $this->showErrors = $showErrors;
        $this->label = $label;
        $this->radioLabel = $radioLabel;
        $this->value = $value;
        $this->labelClass = $labelClass;
        $this->info = $info;
        $this->row = $row;
        $this->wrap = $wrap;
        $this->switch = $switch;
        $this->checked = (bool) $checked;
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
        return view('components.forms.inputs.radio');
    }
}
