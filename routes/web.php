<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf as PDF;

Route::get('/', [UserController::class, 'home'])->middleware('auth')->name('home');
Route::get('/home', [UserController::class, 'home'])->middleware('auth');
Route::get('/logout', [UserController::class, 'logout']);

Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

//Route::get('/test-pdf', function () {
//    $pdf = PDF::loadView('test-pdf', [
//        'message' => 'PDF is working correctly.'
//    ]);
//
//    return $pdf->download('test.pdf');
//});


require __DIR__.'/settings.php';
