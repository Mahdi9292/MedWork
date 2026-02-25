<?php

namespace App\Http\Controllers\Medical;

class MedicalController extends BaseMedicalController
{
    public function index()
    {
        return view('templates.medical.default.dashboard');
    }

    public function changelog()
    {
//        return view('templates.orderbook.default.changelog');
    }
    public function about()
    {
        return view('templates.medical.default.about');
    }

}
