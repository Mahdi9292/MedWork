<?php

namespace App\View\Components\Template;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class LandingPageTile extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $title = '',
        public string $version = '',
        public string $url = '',
        public string $subTitle = '',
        public string $shortInfo = '',
        public string $wrapClass = 'col-sm-4 col-xl-2 mb-3',
        public array|string $permissions = [],
    )
    {
        // Adding Developer to permissions
        $this->permissions = array_merge(['Developer'], $this->permissions);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.template.landing-page-tile');
    }
}
