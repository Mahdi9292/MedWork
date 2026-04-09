<?php

namespace App\Http\Controllers\Medical;

use App\Http\Requests\PreventionTypeRequest;
use App\Models\Medical\PreventionType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PreventionTypeController extends BaseMedicalController
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
        $this->authorize('viewAny', PreventionType::class);
        return view('templates.medical.prevention_type.index');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', PreventionType::class);
        return view('templates.medical.prevention_type.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PreventionTypeRequest $request)
    {
        $this->authorize('create', PreventionType::class);

        PreventionType::create($request->validated());
        return redirect()->route('medical.preventionTypes.index')->with('success', 'Responsible Created');
    }

    /**
     * Display the specified resource.
     */
    public function show(PreventionType $preventionType)
    {
        $this->authorize('view', $preventionType);
        return view('templates.medical.prevention_type.show', compact('preventionType'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PreventionType $preventionType)
    {
        $this->authorize('update', $preventionType);

        return view('templates.medical.prevention_type.edit', compact('preventionType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PreventionTypeRequest $request, PreventionType $preventionType)
    {
        $this->authorize('update', $preventionType);

        $preventionType->update($request->validated());
        return redirect()->route('medical.preventionTypes.index')->with('success', __('Speichern erfolgreich'));

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PreventionType $preventionType)
    {
        $this->authorize('delete', $preventionType);
        $preventionType->delete();
        return redirect()->route('medical.preventionTypes.index')->with('info', __('Erfolgreich gelöscht'));
    }

}
