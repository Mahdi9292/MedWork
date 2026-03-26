<?php

use App\Http\Controllers\Medical\CertificateController;
use App\Http\Controllers\Medical\EmployerController;
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

Route::group(['as' => 'medical.', 'prefix' => 'certificates'], function () {

    Route::resource('certificates', 'CertificateController');

    // print Certificate
    Route::get('/printCertificate/{certificate}', [CertificateController::class, 'printCertificate'])->name('printCertificate');

});

Route::group(['as' => 'medical.', 'prefix' => 'activities'], function () {

    Route::resource('activities', 'ActivityController');

});

/*
|--------------------------------------------------------------------------
| Employers (standalone management)
|--------------------------------------------------------------------------
*/
Route::group(['as' => 'medical.', 'prefix' => 'employers'], function () {
    Route::resource('employers', 'EmployerController');
});
