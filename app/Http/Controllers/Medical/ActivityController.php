<?php

namespace App\Http\Controllers\Medical;

use App\Http\Requests\ActivityRequest;
use App\Models\Medical\Activity;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ActivityController extends BaseMedicalController
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
        $this->authorize('viewAny', Activity::class);
        return view('templates.medical.activity.index');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Activity::class);
        return view('templates.medical.activity.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ActivityRequest $request)
    {
        $this->authorize('create', Activity::class);

        Activity::create($request->validated());
        return redirect()->route('medical.activities.index')->with('success', 'Responsible Created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Activity $activity)
    {
        $this->authorize('view', $activity);
        return view('templates.medical.activity.show', compact('activity'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Activity $activity)
    {
        $this->authorize('update', $activity);

        return view('templates.medical.activity.edit', compact('activity'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ActivityRequest $request, Activity $activity)
    {
        $this->authorize('update', $activity);

        $activity->update($request->validated());
        return redirect()->route('medical.activities.index')->with('success', __('Speichern erfolgreich'));

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Activity $activity)
    {
        $this->authorize('delete', $activity);
        $activity->delete();
        return redirect()->route('medical.activities.index')->with('info', __('Erfolgreich gelöscht'));
    }

}
