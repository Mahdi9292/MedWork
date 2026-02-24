<?php

namespace App\Http\Controllers\Medical;

use App\Enums\Certificate\HourAmount;
use App\Enums\Certificate\ServiceType;

use App\Http\Requests\CertificateRequest;
use App\Models\Certificate;
use Exception;

class CertificateController extends BaseMedicalController
{

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Certificate::class);

        return view('templates.medical.certificate.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Certificate::class);

        // Dropdown options
        $data['serviceTypeOptions']    = ServiceType::options();
        $data['quantityOptions']       = HourAmount::options();
        $invoice = new Certificate;

        return view('templates.medical.certificate.create', compact('invoice'), $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CertificateRequest $request)
    {
        $this->authorize('create', Certificate::class);

        $validated = $request->validated();
        // Remove services from invoice data
        $invoiceData = collect($validated)->except('services')->toArray();

        $invoice = Certificate::create($invoiceData);

        foreach ($validated['services'] as $service) {
            $invoice->services()->create($service);
        }

        return redirect()->route('invoices.index')->with('success', 'Rechnung wurde erfolgreich erstellt');
    }

    /**
     * Display the specified resource.
     */
    public function show(Certificate $invoice)
    {
        $this->authorize('view', $invoice);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Certificate $invoice)
    {
        $this->authorize('update', $invoice);

        // Dropdown options
        $data['serviceTypeOptions']    = ServiceType::options();
        $data['quantityOptions']       = HourAmount::options();
        return view('templates.medical.certificate.edit', compact('invoice'), $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CertificateRequest $request, Certificate $invoice)
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
            ->route('invoices.index')
            ->with('success', 'Rechnung Nr. ' . $invoice->invoice_number . ' wurde erfolgreich aktualisiert');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Certificate $invoice)
    {
        $this->authorize('delete', $invoice);

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
    public function printInvoice(Certificate $invoice)
    {
//        $this->authorize('print', Offer::class);
        try {
            $this->invoiceService->printInvoice($invoice);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
