<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserController
{
    /**
     * Show the index page of TWAP
     *
     * @return View
     */
    public function home()
    {
//        $user = Auth::user();

//        if($user->getRoleNames()->count() < 1){
//            $user->syncRolesWithLdapGroups();
//        }

        return view('dashboard');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
