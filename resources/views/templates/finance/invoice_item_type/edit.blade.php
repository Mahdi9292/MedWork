@extends('layouts.app')

@section('content')

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <x-template.breadcrumb :activePage="$invoiceItemType->name" :links="[['key' => config('constants.APPLICATIONS.FINANCE.TITLE'), 'url' => url('finance')]]" >
                <li class="breadcrumb-item"><a href="{{ route('finance.invoiceItemTypes.index') }}">{{ __('Leistungstyp') }}</a></li>
            </x-template.breadcrumb>
            <h2 class="h4">{{ __('Leistungstyp bearbeiten') }}</h2>
            <p class="mb-0"></p>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group">
                <a href="{{ route("finance.invoiceItemTypes.index") }}" class="btn btn-sm btn-outline-primary">{{ __('Alle') }}</a>
            </div>
        </div>
    </div>
    <x-template.notification />
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card border-light shadow-sm components-section">
                <div class="card-body">
                    <div class="col-lg-8 col-sm-12">
                        <x-form.form :action="route('finance.invoiceItemTypes.update', $invoiceItemType->id)" method="PUT" novalidate hasJsValidation>

                            <x-form.input name="name" :label="__('Leistungstyp')" :value="$invoiceItemType->name" :labelClass="'col-sm-3'"  required />
                            <x-form.input name="comment" :label="__('Kommentar')" :value="$invoiceItemType->comment" :labelClass="'col-sm-3'" />

                            <button type="submit" class="btn btn-secondary">{{ __('Speichern') }}</button>
                        </x-form.form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
