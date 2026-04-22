<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Finance\BaseFinanceController;
use App\Http\Requests\InvoiceItemTypeRequest;
use App\Models\Finance\InvoiceItemType;

class InvoiceItemTypeController extends BaseFinanceController
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
        $this->authorize('viewAny', InvoiceItemType::class);
        return view('templates.finance.invoice_item_type.index');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', InvoiceItemType::class);
        return view('templates.finance.invoice_item_type.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InvoiceItemTypeRequest $request)
    {
        $this->authorize('create', InvoiceItemType::class);

        InvoiceItemType::create($request->validated());
        return redirect()->route('finance.invoiceItemTypes.index')->with('success', 'Invoice Item Type Created');
    }

    /**
     * Display the specified resource.
     */
    public function show(InvoiceItemType $invoiceItemType)
    {
        $this->authorize('view', $invoiceItemType);
        return view('templates.finance.invoice_item_type.show', compact('invoiceItemType'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InvoiceItemType $invoiceItemType)
    {
        $this->authorize('update', $invoiceItemType);

        return view('templates.finance.invoice_item_type.edit', compact('invoiceItemType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InvoiceItemTypeRequest $request, InvoiceItemType $invoiceItemType)
    {
        $this->authorize('update', $invoiceItemType);

        $invoiceItemType->update($request->validated());
        return redirect()->route('finance.invoiceItemTypes.index')->with('success', __('Speichern erfolgreich'));

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InvoiceItemType $invoiceItemType)
    {
        $this->authorize('delete', $invoiceItemType);
        $invoiceItemType->delete();
        return redirect()->route('finance.invoiceItemTypes.index')->with('info', __('Erfolgreich gelöscht'));
    }

}
