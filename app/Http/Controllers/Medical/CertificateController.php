<?php

namespace App\Http\Controllers\Medical;

use App\Http\Requests\CertificateRequest;
use App\Models\Medical\Certificate;
use App\Services\CertificateService;
use Exception;

class CertificateController extends BaseMedicalController
{
    protected CertificateService $certificateService;

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct(CertificateService $certificateService)
    {
        parent::__construct();
        $this->certificateService = $certificateService;
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
        return view('templates.medical.certificate.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CertificateRequest $request)
    {
        $this->authorize('create', Certificate::class);

        Certificate::create($request->all());
        return redirect()->route('medical.certificates.index')->with('success', 'Responsible Created');

    }

    /**
     * Display the specified resource.
     */
    public function show(Certificate $certificate)
    {
        $this->authorize('view', $certificate);
        return view('templates.medical.activity.show', compact('certificate'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Certificate $certificate)
    {
        $this->authorize('update', $certificate);
        return view('templates.medical.certificate.edit', compact('certificate'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CertificateRequest $request, Certificate $certificate)
    {
        $this->authorize('update', $certificate);

        $certificate->update($request->all());
        return redirect()->route('medical.certificates.index')->with('success', __('Speichern erfolgreich'));

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Certificate $certificate)
    {
        $this->authorize('delete', $certificate);
        $certificate->delete();
        return redirect()->route('medical.certificates.index')->with('info', __('Erfolgreich gelöscht'));

    }

    /**
     * show invoice pdf
     */
    public function printInvoice(Certificate $certificate)
    {
//        $this->authorize('print', Offer::class);
        try {
            $this->certificateService->printCertificate($certificate);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
