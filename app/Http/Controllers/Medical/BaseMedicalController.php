<?php

namespace App\Http\Controllers\Medical;

use App\Http\Controllers\MasterController;

class BaseMedicalController extends MasterController
{
    public function __construct() {
        parent::__construct();
        $this->loadDefaultData();

        $this->middleware(function ($request, $next) {
            return $next($request);
        });
    }

    protected function loadDefaultData(array $params=[]){
        $this->appTitle = config('constants.APPLICATIONS.MEDICAL.KEY',);
        $this->activeApp = config('constants.APPLICATIONS.MEDICAL.KEY');

        // calling the parent method to set the global variables
        parent::loadDefaultData($params);
    }
}
