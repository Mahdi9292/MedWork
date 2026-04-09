@extends('layouts.app')

@section('content')

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <x-template.breadcrumb :activePage="__('neuer Vorsorgeart')" :links="[
                ['key' => config('constants.APPLICATIONS.MEDICAL.TITLE'), 'url' => url('medical')],
                ['key' => __('Vorsorgeart'), 'url' => route('medical.preventionTypes.index')]
            ]" />
            <h2 class="h4">{{ __('Vorsorgeart Erstellen') }}</h2>
        </div>
    </div>

    <x-template.notification />

    <div class="row">
        <div class="col-12 mb-4">
            <div class="card border-light shadow-sm components-section">
                <div class="card-body">
                    <div class="col-lg-9 col-sm-12">
                        <x-form.form :action="route('medical.preventionTypes.store')" novalidate hasJsValidation>

                            <x-form.input name="name" :label="__('Vorsorgeart')" required  />
                            <x-form.input name="comment" :label="__('Kommentar')"  />

                            <button type="submit" class="btn btn-secondary">{{ __('Speichern') }}</button>
                        </x-form.form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
