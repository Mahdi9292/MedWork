<?php

namespace App\Http\Controllers\Finance;

use App\Enums\Finance\Quantity;
use App\Http\Requests\InvoiceRequest;
use App\Models\Finance\Invoice;
use App\Services\InvoiceService;
use Exception;

class InvoiceController extends BaseFinanceController
{

    protected InvoiceService $invoiceService;

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct(InvoiceService $invoiceService)
    {
        parent::__construct();
        $this->invoiceService = $invoiceService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Invoice::class);
        return view('templates.finance.invoice.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Invoice::class);
        $invoice = new Invoice;
        return view('templates.finance.invoice.create', compact('invoice'));
    }


    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        $this->authorize('view', $invoice);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        $this->authorize('update', $invoice);

        return view('templates.finance.invoice.edit', compact('invoice'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        $this->authorize('delete', $invoice);

        $invoiceNumber = $invoice->invoice_number;
        $invoice->services()->delete();
        $invoice->delete();

        return redirect()
            ->route('finance.invoices.index')
            ->with('success', 'Rechnung Nr. ' . $invoiceNumber . ' wurde erfolgreich gelöcht');
    }

    /**
     * show invoice pdf
     */
    public function printInvoice(Invoice $invoice)
    {
//        $this->authorize('print', Offer::class);
        try {
            $this->invoiceService->printInvoice($invoice);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
