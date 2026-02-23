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

}
