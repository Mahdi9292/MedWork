<?php

namespace App\View\Components\Base;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Modal extends Component
{
    /**
     * Create a new component instance.
    */
    public function __construct(
        public string $id,
        public bool $showCancel = true,
        public bool $hideHeaderClose = false,
        public bool $showSubmit = true,
        public string $title = '',
        public bool $scrollable = true,
        public bool $centered = true,
        public bool $static = false,
        public string $modelBodyClass = ''
    ) {}

    /**
     * Get the view / contents that represent the component.
     *
     * @return View
    */
    public function render() : View
    {
        return view('components.base.modal');
    }
}
