<?php

namespace App\Http\Controllers\Medical;

use App\Enums\Medical\PreventionType;
use App\Enums\Medical\SalutationType;
use App\Http\Requests\CertificateRequest;
use App\Models\Medical\Activity;
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

        $certificate = new Certificate;

        return view('templates.medical.certificate.create', compact('certificate'));
    }

    /**
     * @deprecated - due to Livewire
     * Store a newly created resource in storage.
     */
    public function store(CertificateRequest $request)
    {
        $this->authorize('create', Certificate::class);

        $validated = $request->validated();

        // Remove services from certificate data
        $certificateData = collect($validated)->except('preventions')->toArray();

        $certificate = Certificate::create($certificateData);

        foreach ($validated['preventions'] as $prevention) {
            $certificate->preventions()->create($prevention);
        }

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
     * @deprecated - due to Livewire
     * Update the specified resource in storage.
     */
    public function update(CertificateRequest $request, Certificate $certificate)
    {
        $this->authorize('update', $certificate);

        $validated = $request->validated();

        // Update certificate main data
        $certificateData = collect($validated)->except('preventions')->toArray();
        $certificate->update($certificateData);

        $existingPreventionIds = [];

        foreach ($validated['preventions'] as $preventionData) {

            // Normalize empty ID
            $preventionId = $preventionData['id'] ?? null;

            if (!empty($preventionId)) {
                // Update existing prevention (safely scoped to this certificate)
                $prevention = $certificate->preventions()
                    ->where('id', $preventionId)
                    ->first();

                if ($prevention) {
                    $prevention->update($preventionData);
                    $existingPreventionIds[] = $prevention->id;
                }
            } else {
                // Create new prevention
                $prevention = $certificate->preventions()->create($preventionData);
                $existingPreventionIds[] = $prevention->id;
            }
        }

        // Delete removed preventions
        $certificate->preventions()->whereNotIn('id', $existingPreventionIds)->delete();

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
     * show certificate pdf
     */
    public function printCertificate(Certificate $certificate = null)
    {
//        $this->authorize('print', Offer::class);
        try {
            $this->certificateService->printCertificate($certificate);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
