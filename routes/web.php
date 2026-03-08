<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf as PDF;

Route::get('/', [UserController::class, 'home'])->middleware('auth')->name('home');
Route::get('/home', [UserController::class, 'home'])->middleware('auth');
Route::get('/logout', [UserController::class, 'logout']);

//Route::get('/dashboard', function () {
//    return view('templates.dashboard');
//})->middleware('auth')->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/users/{user}/roles', [UserController::class, 'editRoles'])->name('users.roles.edit');
    Route::post('/users/{user}/roles', [UserController::class, 'updateRoles'])->name('users.roles.update');
});

require __DIR__.'/settings.php';
