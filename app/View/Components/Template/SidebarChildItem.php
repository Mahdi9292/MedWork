<?php

namespace App\View\Components\Template;

use Illuminate\View\Component;
use Illuminate\Support\Facades\URL;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Foundation\Application;

class SidebarChildItem extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public string $title,
        public string $link,
        public string $abbr = '',
        public string $icon = '',
        public bool $active = false,
        public ?string $permission = null,
        public string $target = '',
        public string $toolTip = ''
    )
    {
        $this->isActive();
    }

    private function isActive(): void
    {
        //$currentUrlPrefix = Route::current()->uri;
        //$currentUrlPrefix = str_contains($currentUrlPrefix, '{') ? rtrim(substr($currentUrlPrefix, 0,strrpos($currentUrlPrefix, '{')), '/') : $currentUrlPrefix;
        //$linkPrefix = ltrim(str_replace(URL::to('/'), '', $this->link), '/');
        //$this->active = $currentUrlPrefix === $linkPrefix;

        $this->active = $this->link === URL::current();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return Application|Factory|View|void
     */
    public function render()
    {
        if($this->permission === null || Auth::user()->can($this->permission)) {
            return view('components.template.sidebar-child-item');
        }
    }
}
