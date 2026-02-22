<?php

namespace App\Http\Controllers\Invoice;

use App\Enums\Invoice\HourAmount;
use App\Enums\Invoice\ServiceType;
use App\Http\Controllers\Controller;
use App\Http\Requests\InvoiceRequest;
use App\Models\Invoice;
use App\Services\InvoiceService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\In;

class InvoiceController extends Controller
{

    protected InvoiceService $invoiceService;

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct(InvoiceService $invoiceService)
    {
//        parent::__construct();
        $this->invoiceService = $invoiceService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('templates.invoice.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        // Dropdown options
        $data['serviceTypeOptions']    = ServiceType::options();
        $data['quantityOptions']       = HourAmount::options();
        $invoice = new Invoice;

        return view('templates.invoice.create', compact('invoice'), $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InvoiceRequest $request)
    {
        $validated = $request->validated();
        // Remove services from invoice data
        $invoiceData = collect($validated)->except('services')->toArray();

        $invoice = Invoice::create($invoiceData);

        foreach ($validated['services'] as $service) {
            $invoice->services()->create($service);
        }

        return redirect()->route('invoices.index')->with('success', 'Rechnung wurde erfolgreich erstellt');
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        // Dropdown options
        $data['serviceTypeOptions']    = ServiceType::options();
        $data['quantityOptions']       = HourAmount::options();
        return view('templates.invoice.edit', compact('invoice'), $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InvoiceRequest $request, Invoice $invoice)
    {
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
            ->route('invoices.index')
            ->with('success', 'Rechnung Nr. ' . $invoice->invoice_number . ' wurde erfolgreich aktualisiert');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        $invoiceNumber = $invoice->invoice_number;
        $invoice->services()->delete();
        $invoice->delete();

        return redirect()
            ->route('invoices.index')
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
