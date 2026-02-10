<?php

namespace App\View\Components\Datatable;

use Illuminate\View\Component;

class Basic extends Component
{
    /**
     * if row is selectable
     *
     * @var bool
     */
    public bool $selectableRow;

    /**
     * Length menu
     *
     * @var string
     */
    public string $lengthMenu;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($selectableRow=true, $lengthMenu='')
    {
        $this->selectableRow = $selectableRow;
        $this->lengthMenu = $lengthMenu;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.datatable.basic');
    }
}
