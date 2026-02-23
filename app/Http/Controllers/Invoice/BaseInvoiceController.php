<?php

namespace App\Http\Controllers\OrderBook;

use App\Http\Controllers\MasterController;
use Illuminate\Support\Facades\Auth;

class BaseOrderBookController extends MasterController
{
    public function __construct() {
        parent::__construct();
        $this->loadDefaultData();

        $this->middleware(function ($request, $next) {
            $this->newNotifications();
            return $next($request);
        });
    }

    protected function loadDefaultData(array $params=[]){
        $this->appTitle = 'Auftragsbuch';
        $this->activeApp = config('constants.APPLICATIONS.ORDERBOOK.KEY');

        // calling the parent method to set the global variables
        parent::loadDefaultData($params);
    }

    protected function newNotifications()
    {
        $currentOrderBookVersion = config('constants.app_version.OrderBook');
        $notificationVersion = Auth::user()->settings()->get('orderbook.newNotification');
        View()->share( 'newNotification', false);

        if($currentOrderBookVersion !== $notificationVersion){
            View()->share( 'newNotification', true);
        }
    }
}
