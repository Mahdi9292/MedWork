<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;

class SidebarComposer
{
    /**
     * Create a sidebar composer.
     *
     * @return void
    */
    public function __construct()
    {
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view): void
    {
        $view->with('activeSidebarItem', request()->segment(2));
    }
}
