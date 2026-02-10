<?php

declare(strict_types=1);

namespace App\View\Components\Form;

use App\Concerns\HandlesValidationErrors;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Show extends Component
{
    use HandlesValidationErrors;

    public function __construct(
        public string $name = '',
        public string $id = '',
        public string $type = 'text',
        public mixed $value = '',
        bool $showErrors = true,
        public string $label = '',
        public string $labelClass = 'col-sm-2',
        public string $row = 'row mb-3',
        public string $wrap = 'col-sm-8',
        public bool $border = true,
        public string $bgColor = '#F0F0F05E'
    ) {
        $this->showErrors = $showErrors;
    }

    public function inputClass(): string
    {
        return collect([
            in_array($this->type, ['text', 'boolean'])  ? 'form-text form-control' : null,
            $this->type == 'checkbox' ? 'form-checkbox' : null,
            !$this->border ? 'border-0 ps-1 shadow-none' : null,
            $this->hasErrorsAndShow($this->name) ? 'is-invalid' : null,
        ])->filter()->implode(' ');
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View
     */
    public function render(): View
    {
        return view('components.forms.show');
    }
}
