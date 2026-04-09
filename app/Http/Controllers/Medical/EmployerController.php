<?php

namespace App\Http\Controllers\Medical;

use App\Http\Requests\EmployerRequest;
use App\Models\Medical\Employer;

class EmployerController extends BaseMedicalController
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
        $this->authorize('viewAny', Employer::class);
        return view('templates.medical.employer.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Employer::class);
        return view('templates.medical.employer.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EmployerRequest $request)
    {
        $this->authorize('create', Employer::class);

        Employer::create($request->validated());
        return redirect()->route('medical.employers.index')->with('success', 'Responsible Created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Employer $employer)
    {
        $this->authorize('view', $employer);
        return view('templates.medical.employer.show', compact('employer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employer $employer)
    {
        $this->authorize('update', $employer);
        return view('templates.medical.employer.edit', compact('employer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EmployerRequest $request, Employer $employer)
    {
        $this->authorize('update', $employer);
        $employer->update($request->validated());

        return redirect()->route('medical.employers.index')->with('success', __('Speichern erfolgreich'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employer $employer)
    {
        $this->authorize('delete', $employer);
        return redirect()->route('medical.employers.index')->with('info', __('Erfolgreich gelöscht'));

    }

    /**
     * show certificate pdf
     */
    public function printCertificate(Employer $employer)
    {

    }
}
