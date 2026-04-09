<?php

use App\Http\Controllers\Medical\CertificateController;
use App\Http\Controllers\Medical\MedicalController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', [MedicalController::class, 'index'])->name('medical.home');

Route::group(['as' => 'medical.', 'prefix' => 'examinations'], function () {

    Route::resource('certificates', 'CertificateController');

    // print Certificate
    Route::get('/printCertificate/{certificate}/{downloadType?}', [CertificateController::class, 'printCertificate'])->name('printCertificate');

});

Route::group(['as' => 'medical.', 'prefix' => 'system'], function () {

    Route::resource('employers', 'EmployerController');
    Route::resource('comments', 'CommentController');
    Route::resource('activities', 'ActivityController');
    Route::resource('preventionTypes', 'PreventionTypeController');

});
