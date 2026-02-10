<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class UserController
{
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
