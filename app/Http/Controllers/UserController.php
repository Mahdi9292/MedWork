<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class UserController extends Controller
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

        return view('home');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    public function editRoles(User $user)
    {
        $this->authorize('assignRole', $user);

        $roles = Role::all();

        return view('templates.user.roles', compact('user', 'roles'));
    }

    public function updateRoles(Request $request, User $user)
    {
        $this->authorize('assignRole', $user);

        $request->validate([
            'roles' => 'array'
        ]);

//        dd($request->roles);

        $user->syncRoles($request->roles ?? []);

        return redirect()->back()->with('success', 'Roles updated.');
    }
}
