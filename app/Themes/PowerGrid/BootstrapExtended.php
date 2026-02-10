<?php

namespace App\Themes\PowerGrid;

use PowerComponents\LivewirePowerGrid\Themes\Bootstrap5;

class BootstrapExtended extends Bootstrap5
{
    public function table(): array
    {
        return [
            'layout' => [
                'base'      => 'pt-3 px-sm-3 px-lg-5 align-middle d-inline-block',
                'div'       => 'table-responsive col-md-12 my-2 mx-0 min-h-500 max-h-500',
                'table'     => 'table table-hover w-100 table-sm table-bordered',
                //'table'     => 'table table-sm table-hover table-flush table-bordered table-checkable table-highlight-head mb-2',
                'container' => 'my-0 mx-sm-n1 mx-lg-n3 overflow-x-auto',
                'actions'   => 'd-flex gap-1',
            ],

            'header' => [
                'thead'    => 'table-dark sticky-top z-1',
                'tr'       => '',
                //'th'       => 'fw-bold text-white text-nowrap small py-2',
                'th'       => 'fw-bold text-white small py-2 align-middle',
                'thAction' => '',
            ],

            'body' => [
                'tbody'              => 'table-group-divider',
                'tbodyEmpty'         => '',
                'tr'                 => '',
                'td'                 => 'align-middle text-nowrap px-2 py-1 lh-sm',
                'tdEmpty'            => 'p-2 text-nowrap',
                'tdSummarize'        => 'text-dark-emphasis small px-3 py-2 lh-sm',
                'trSummarize'        => '',
                'tdFilters'          => '',
                'trFilters'          => '',
                'tdActionsContainer' => 'd-flex gap-1 justify-content-center',
            ],
        ];
    }
}
