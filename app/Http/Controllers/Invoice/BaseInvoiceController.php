<?php

namespace App\Http\Controllers\Invoice;

use App\Http\Controllers\MasterController;

class BaseInvoiceController extends MasterController
{
    public function __construct() {
        parent::__construct();
        $this->loadDefaultData();

        $this->middleware(function ($request, $next) {
            return $next($request);
        });
    }

    protected function loadDefaultData(array $params=[]){
        $this->appTitle = 'Rechnung';
        $this->activeApp = config('constants.APPLICATIONS.INVOICE.KEY');

        // calling the parent method to set the global variables
        parent::loadDefaultData($params);
    }
}
