<?php

namespace App\View\Components\Base;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Changelog extends Component
{
    /**
     * Create a new component instance.
    */
    public function __construct(
        public string $id,
        public string $title
    ) {}

    /**
     * Get the view / contents that represent the component.
     *
     * @return View
    */
    public function render() : View
    {
        return view('components.base.changelog');
    }
}
