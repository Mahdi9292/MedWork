<?php

namespace App\View\Components\Template;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Breadcrumb extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public string $activePage,
        public array $links = []
    ) {}

    public function render(): View
    {
        return view('components.template.breadcrumb');
    }
}
