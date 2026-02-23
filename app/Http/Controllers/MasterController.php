<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\View\Components\Form\AjaxCheckbox;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;

class MasterController extends Controller
{
    protected string $pageTitle = '';
    protected string $appTitle = '';
    protected string $activeApp = '';
    protected array $data = [];

    public function __construct() {}

    /**
     *
     * Function to load common data which will be available
     * to all views.
    */
    protected function loadDefaultData(array $params=[])
    {
        // setting predefined global variables
        View()->share( 'pageTitle', $this->pageTitle );
        View()->share( 'appTitle', $this->appTitle );
        View()->share( 'activeApp', $this->activeApp );

        // setting global variables requested from child controllers
        if($params) {
            foreach ($params as $key => $param){
                View()->share( $key, $param);
            }
        }
    }

    /**
     * Common function to generate the Grid Actions
    */
    protected function generateGridActions(array $routes, $item): array
    {
        $actions = [];

        if($routes)
        {
            if(($routes['edit'] ?? false) && $item){
                $actions['edit']['url'] = route($routes['edit'], $item);
            }

            if(($routes['show'] ?? false) && $item){
                $actions['show']['url'] = route($routes['show'], $item);
            }

            if(($routes['delete'] ?? false) && $item){
                $actions['delete']['url'] = route($routes['delete'], $item);
            }
            if(($routes['email'] ?? false) && $item){
                $actions['email']['url'] = route($routes['email'], $item);
            }

            if(($routes['simulate'] ?? false) && $item){
                $actions['simulate']['url'] = route($routes['simulate'], $item);
            }

            if(($routes['print'] ?? false) && $item){
                $actions['print']['url'] = route($routes['print'], $item);
            }
        }

        return $actions;
    }

    /**
     * function to generate month list used for dropdowns
    */
    protected function getMonthList(): array
    {
         return [
            1 => trans('Januar'),
            2 => trans('Februar'),
            3 => trans('März'),
            4 => trans('April'),
            5 => trans('Mai'),
            6 => trans('Juni'),
            7 => trans('Juli'),
            8 => trans('August'),
            9 => trans('September'),
            10 => trans('Oktober'),
            11 => trans('November'),
            12 => trans('Dezember'),
        ];
    }

    /**
     * Add the fetch api body content as parameters
     * to the current ajax request.
     * @param $body
     * @return object
     */
    protected function getFetchParameters($body): object
    {
        $body = json_decode($body->getContent());
        $content = [];
        if($body && isset($body->params) && $body->params){
            $content = json_decode($body->params);
        }

        return ((object) array_merge((array) $content, (array) $body));
    }

    /**
     * TODO:: this function is moved to helpers, remove it carefully
     * return formatted yadcf filter string for query
     * @param $query
     * @param string $type
     * @return array|false
     */
    protected function formatYadcfFilters($query, string $type='date'): bool|array
    {
        if(!$query){
            return false;
        }

        $filters= [];

        if($type == 'date' && str_contains($query, '-yadcf_delim-'))
        {
            $keywords = explode('-yadcf_delim-', $query);
            if(array_filter($keywords))
            {
                $filters['start_date'] = formatDate($keywords[0], 'Y-m-d', 'd.m.Y');
                $filters['end_date'] = isset($keywords[1]) && $keywords[1] ? formatDate($keywords[1], 'Y-m-d', 'd.m.Y') : Carbon::now()->format('Y-m-d');
            }
        }

        return $filters;
    }

    /**
     * return checkbox for js datagrid column
     * @param $checked
     * @param bool $editable
     * @param array $param
     * @param bool $route
     * @return View|string
     */
    protected function renderCheckbox($checked, $editable=false, $param=[], $route=false)
    {
        if(!$editable || !$param || !$route) {
            return $checked ? '<i class="fa fa-check-square"></i>' : '<i class="far fa-square"></i>';
        }

        // returning editable checkbox
        return (new AjaxCheckbox())->render(
            [
                'name'=>'cbx-service',
                'checked' => $checked, 'params' => json_encode($param),
                'ajaxUrl' => $route
            ]);
    }
}
