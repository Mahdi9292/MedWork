<?php

declare(strict_types=1);
namespace App\View\Components\Form;

use Illuminate\View\Component;
use Illuminate\View\View;

class Filepond extends Component
{
    public function render(): View
    {
        return view('components.forms.inputs.file-pond');
    }
}
