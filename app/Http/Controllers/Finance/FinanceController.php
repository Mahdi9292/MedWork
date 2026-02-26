<?php

namespace App\Http\Controllers\Finance;

class FinanceController extends BaseFinanceController
{
    public function index()
    {
        return view('templates.finance.default.dashboard');
    }

    public function changelog()
    {
//        return view('templates.finance.default.changelog');
    }
    public function about()
    {
        return view('templates.finance.default.about');
    }

}
