<!--

=========================================================
* Volt Free - Bootstrap 5 Dashboard
=========================================================

* Product Page: https://themesberg.com/product/admin-dashboard/volt-bootstrap-5-dashboard
* Copyright 2021 Themesberg (https://www.themesberg.com)
* License (https://themesberg.com/licensing)

* Designed and coded by https://themesberg.com

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software. Please contact us to request a removal.

-->

@extends('layouts.app')

@section('content')

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <x-template.breadcrumb :activePage="__('neuer Arbeitgeber')" :links="[
                ['key' => config('constants.APPLICATIONS.MEDICAL.TITLE'), 'url' => url('medical')],
                ['key' => __('Arbeitgeber'), 'url' => route('medical.employers.index')]
            ]" />
            <h2 class="h4">{{ __('Arbeitgeber Erstellen') }}</h2>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('medical.employers.create') }}" class="btn btn-sm btn-outline-primary">Zurück setzen</a>
            <a href="javascript:" onclick="document.getElementById('btnFormSubmit').click();" class="btn btn-sm btn-secondary mx-2">{{ __('Erstellen') }}</a>
        </div>
    </div>

    <x-template.notification />

    <x-form.form :action="route('medical.employers.store')" id="createEmployerForm" novalidate hasJsValidation>
        <div class="row">
            <div class="col-12 mb-4">
                <div class="card border-light shadow-sm components-section">
                    <div class="card-header">
                        {{ __('Arbeitgeber') }}
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <x-form.input name="name" :label="__('Arbeitgeber')" :labelClass="'col-sm-3'" />
                                <x-form.input name="contact_person" :label="__('Ansprechpartner')" :labelClass="'col-sm-3'" />
                                <x-form.input name="address" :label="__('Voll Adresse')" :labelClass="'col-sm-3'" />
                                <x-form.input name="street" :label="__('Straße')" :labelClass="'col-sm-3'" />
                                <x-form.input name="house_number" :label="__('Hausnummer')" :labelClass="'col-sm-3'" />
                            </div>

                            <div class="col-sm-6">
                                <x-form.input name="city" :label="__('Ort')" :labelClass="'col-sm-3'" />
                                <x-form.input name="postcode" :label="__('PLZ')" :labelClass="'col-sm-3'" />
                                <x-form.input name="phone" :label="__('Telefonnummer')" :labelClass="'col-sm-3'" />
                                <x-form.input name="mobile" :label="__('Mobilnummer')" :labelClass="'col-sm-3'" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 mb-4">
                <div class="card border-light shadow-sm components-section">
                    <div class="card-footer border-success p-2 footer-light">
                        <button type="submit" id="btnFormSubmit" class="btn btn-secondary float-end">{{ __('Erstellen') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </x-form.form>

@endsection



