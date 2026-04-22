<?php

use App\Http\Controllers\Finance\FinanceController;
use App\Http\Controllers\Finance\InvoiceController;
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
Route::get('/', [FinanceController::class, 'index'])->name('finance.home');

Route::group(['as' => 'finance.', 'prefix' => 'accounting'], function () {

    Route::resource('invoices', 'InvoiceController');

    // print Invoice
    Route::get('/printInvoice/{invoice}', [InvoiceController::class, 'printInvoice'])->name('printInvoice');
});

Route::group(['as' => 'finance.', 'prefix' => 'system'], function () {

    Route::resource('invoiceItemTypes', 'InvoiceItemTypeController');

});
