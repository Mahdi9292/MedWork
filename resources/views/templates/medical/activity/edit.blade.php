@extends('layouts.app')

@section('content')

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <x-template.breadcrumb :activePage="$activity->name" :links="[['key' => config('constants.APPLICATIONS.MEDICAL.TITLE'), 'url' => url('medical')]]" >
                <li class="breadcrumb-item"><a href="{{ route('medical.activities.index') }}">{{ __('Tätigkeit') }}</a></li>
            </x-template.breadcrumb>
            <h2 class="h4">{{ __('Tätigkeit bearbeiten') }}</h2>
            <p class="mb-0"></p>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group">
                <a href="{{ route("medical.activities.index") }}" class="btn btn-sm btn-outline-primary">{{ __('Alle') }}</a>
            </div>
        </div>
    </div>
    <x-template.notification />
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card border-light shadow-sm components-section">
                <div class="card-body">
                    <div class="col-lg-8 col-sm-12">
                        <x-form.form :action="route('medical.activities.update', $activity->id)" method="PUT" novalidate hasJsValidation>

                            <x-form.input name="name" :label="__('Tätigkeit')" :value="$activity->name" :labelClass="'col-sm-3'"  required />
                            <x-form.input name="code" :label="__('Code')" :value="$activity->code" :labelClass="'col-sm-3'" required />

                            <button type="submit" class="btn btn-secondary">{{ __('Speichern') }}</button>
                        </x-form.form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
