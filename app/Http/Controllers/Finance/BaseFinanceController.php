<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\MasterController;

class BaseFinanceController extends MasterController
{
    public function __construct() {
        parent::__construct();
        $this->loadDefaultData();

        $this->middleware(function ($request, $next) {
            return $next($request);
        });
    }

    protected function loadDefaultData(array $params=[]){
        //$this->appTitle = 'Rechnung';
        $this->appTitle = config('constants.APPLICATIONS.FINANCE.KEY');
        $this->activeApp = config('constants.APPLICATIONS.FINANCE.KEY');

        // calling the parent method to set the global variables
        parent::loadDefaultData($params);
    }
}
