<?php

declare(strict_types=1);

namespace App\View\Components\Form;

use App\Concerns\HandlesValidationErrors;
use BladeUIKit\Components\BladeComponent;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Textarea extends Component
{
    use HandlesValidationErrors;

    /** @var string */
    public string $name;

    /** @var string */
    public string $id;

    /** @var string */
    public $value;

    /** @var string */
    public string $label;

    /** @var string */
    public string $row;

    /** @var string */
    public string $wrap;

    /** @var string */
    public string $labelClass;

    /** @var int */
    public $rows;

    public function __construct(
        string $name,
        string $id = null,
        string $type = 'text',
        ?string $value = '',
        bool $showErrors = true,
        string $label='',
        string $labelClass ='col-sm-2',
        string $row ='row mb-3',
        string $wrap ='col-sm-8',
        $rows = 3
    )
    {
        $this->name = $name;
        $this->id = $id ?? $name;
        $this->showErrors = $showErrors;
        $this->label = $label;
        $this->labelClass = $labelClass;
        $this->row = $row;
        $this->wrap = $wrap;
        $this->value = old($name, $value ?? '');
        $this->rows = $rows;
    }

    public function inputClass(): string
    {
        return collect([
            'form-control',
            'form-textarea',
            $this->hasErrorsAndShow($this->name) ? 'is-invalid' : null,
        ])->filter()->implode(' ');
    }

    public function render(): View
    {
        return view('components.forms.inputs.textarea');
    }
}
