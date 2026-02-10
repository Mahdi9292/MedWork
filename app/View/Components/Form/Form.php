<?php

declare(strict_types=1);

namespace App\View\Components\Form;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Form extends Component
{
    /** @var string */
    public string $action;

    /** @var string */
    public string $method;

    /** @var bool */
    public bool $hasFiles;

    /** @var bool */
    public bool $hasJsValidation;

    public function __construct(string $action, string $method = 'POST', bool $hasFiles = false, bool $hasJsValidation = false)
    {
        $this->action = $action;
        $this->method = strtoupper($method);
        $this->hasFiles = $hasFiles;
        $this->hasJsValidation = $hasJsValidation;
    }

    public function render(): View
    {
        return view('components.forms.form');
    }
}
