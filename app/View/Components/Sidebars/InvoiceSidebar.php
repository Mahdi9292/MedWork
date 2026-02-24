<?php

namespace App\View\Components\Sidebars;

use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class InvoiceSidebar extends Component
{
    /**
     * Active Item
     *
     * @var string
     */
    public string $active;

    /**
     * Parent Items Except default
     *
     * @var array
     */
    private array $parentItems = ['invoices', 'dashboard'];

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($active='')
    {
        $this->getActiveItem($active);
    }

    private function getActiveItem($activeItem): void
    {
        $this->active = (!$activeItem || !in_array($activeItem, $this->parentItems)) ? 'default' : $activeItem;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View
     */
    public function render(): View
    {
        return view('components.sidebars.invoice-sidebar');
    }
}
