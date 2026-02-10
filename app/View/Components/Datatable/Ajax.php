<?php

namespace App\View\Components\Datatable;

use Illuminate\View\Component;

class Ajax extends Component
{
    /**
     * Ajax URL
     *
     * @var string
     */
    public string $ajaxURL;

    /**
     * Current Active page
     *
     * @var array
     */
    public array $cols;

    /**
     * Show Actions Column
     *
     * @var string
     */
    public bool $hasActionCol;

    /**
     * Priority Column
     *
     * @var integer
     */
    public int $priorityCol;

    /**
     * Show Actions Column
     *
     * @var string
     */
    public string $responsive;

    /**
     * Show Actions Column
     *
     * @var string
     */
    public string $autoWidth;

    /**
     * Length menu
     *
     * @var string
     */
    public string $lengthMenu;

    /**
     * Scroll y-axis
     * table body will be scrollable
     *
     * @var int
     */
    public int $scrollY;

    /**
     * fixed header
     *
     * @var string
     */
    public string $fixedHeader;

    /**
     * show export buttons
     *
     * @var bool
     */
    public bool $exportButtons;

    /**
     * default page length
     *
     * @var int
     */
    public int $pageLength;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $ajaxURL='', array $cols=[], $hasActionCol=true, $priorityCol=1, $responsive='true',
                                $autoWidth='true', $lengthMenu='', $scrollY=0, $fixedHeader='true', $exportButtons = true, $pageLength=10)
    {
        $this->ajaxURL = $ajaxURL;
        $this->cols = $cols;
        $this->hasActionCol = $hasActionCol;
        $this->priorityCol = $priorityCol;
        $this->responsive = $responsive;
        $this->autoWidth = $autoWidth;
        $this->lengthMenu = $lengthMenu;
        $this->scrollY = $scrollY;
        $this->fixedHeader = $fixedHeader;
        $this->exportButtons = $exportButtons;
        $this->pageLength = $pageLength;
        $this->generateColumns();
    }

    private function generateColumns()
    {
        $cols = array_filter($this->cols);
        $columns = [];

        foreach($cols as $col){

            if($col && !is_array($col)){
                $columns[] = ['data' => $col, 'name' => $col];
            }
            elseif(is_array($col)){

                // name index exists
                if(!isset($col['name'])){
                    continue;
                }

                $data = $col['data'] ?? $col['name'];
                $columns[] = array_merge($col, ['data' => $data, 'name' => $col['name']]);
            }
        }

        $this->cols = $columns;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.datatable.ajax');
    }
}
