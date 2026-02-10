<?php

declare(strict_types=1);
namespace App\View\Components\Form;

use Illuminate\Support\ViewErrorBag;
use Illuminate\View\Component;
use Illuminate\View\View;

class Error extends Component
{
    /** @var string */
    public string $field;

    /** @var string */
    public string $bag;

    public function __construct(string $field, string $bag = 'default')
    {
        $this->field = $field;
        $this->bag = $bag;
    }

    public function messages(ViewErrorBag $errors): array
    {
        $bag = $errors->getBag($this->bag);
        return $bag->has($this->field) ? $bag->get($this->field) : [];
    }

    public function render(): View
    {
        return view('components.forms.error');
    }
}
