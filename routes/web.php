<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf as PDF;

Route::get('/', [UserController::class, 'home'])->middleware('auth')->name('home');
Route::get('/home', [UserController::class, 'home'])->middleware('auth');
Route::get('/logout', [UserController::class, 'logout']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

require __DIR__.'/settings.php';
