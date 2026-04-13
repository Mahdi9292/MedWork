<?php

namespace App\Http\Controllers\Finance;

use App\Enums\Finance\Quantity;
use App\Enums\Finance\InvoiceItemType;
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
        // Dropdown options
        $data['serviceTypeOptions']    = InvoiceItemType::options();
        $data['quantityOptions']       = Quantity::options();
        return view('templates.finance.invoice.create', compact('invoice'), $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InvoiceRequest $request)
    {
        $this->authorize('create', Invoice::class);

        $validated = $request->validated();
        // Remove services from invoice data
        $invoiceData = collect($validated)->except('services')->toArray();

        $invoice = Invoice::create($invoiceData);

        foreach ($validated['services'] as $service) {
            $invoice->services()->create($service);
        }

        return redirect()->route('finance.invoices.index')->with('success', 'Rechnung wurde erfolgreich erstellt');
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

        // Dropdown options
        $data['serviceTypeOptions']    = InvoiceItemType::options();
        $data['quantityOptions']       = Quantity::options();
        return view('templates.finance.invoice.edit', compact('invoice'), $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InvoiceRequest $request, Invoice $invoice)
    {
        $this->authorize('update', $invoice);

        $validated = $request->validated();

        // Update invoice main data
        $invoiceData = collect($validated)->except('services')->toArray();
        $invoice->update($invoiceData);

        $existingServiceIds = [];

        foreach ($validated['services'] as $serviceData) {

            // Normalize empty ID
            $serviceId = $serviceData['id'] ?? null;

            if (!empty($serviceId)) {

                // Update existing service (safely scoped to this invoice)
                $service = $invoice->services()
                    ->where('id', $serviceId)
                    ->first();

                if ($service) {
                    $service->update($serviceData);
                    $existingServiceIds[] = $service->id;
                }

            } else {
                // Create new service
                $service = $invoice->services()->create($serviceData);
                $existingServiceIds[] = $service->id;
            }
        }

        // Delete removed services
        $invoice->services()->whereNotIn('id', $existingServiceIds)->delete();

        return redirect()
            ->route('finance.invoices.index')
            ->with('success', 'Rechnung Nr. ' . $invoice->invoice_number . ' wurde erfolgreich aktualisiert');
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
