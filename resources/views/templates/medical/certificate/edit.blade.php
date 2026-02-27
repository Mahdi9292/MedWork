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

{{--    <livewire:invoice.invoice-manage-screen :invoice="$certificate"/>--}}

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
    <div class="d-block mb-4 mb-md-0">
        <x-template.breadcrumb :activePage="$certificate->id" :links="[['key' => config('constants.APPLICATIONS.MEDICAL.TITLE'), 'url' => url('medical')]]" >
            <li class="breadcrumb-item"><a href="{{ route('medical.certificates.index') }}">{{ __('Bescheinigungen') }}</a></li>
        </x-template.breadcrumb>
        <h2 class="h4">{{ __('Bescheinigungen bearbeiten') }}</h2>
        <p class="mb-0"></p>
    </div>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group">
            <a href="{{ route("medical.certificates.index") }}" class="btn btn-sm btn-outline-primary">{{ __('Zu Bescheinigung Liste') }}</a>
        </div>
        <a href="javascript:" onclick="document.getElementById('btnFormSubmit').click();" class="btn btn-sm btn-secondary mx-2">{{ __('Speichern') }}</a>
    </div>

</div>

    <x-form.form :action="route('medical.certificates.update', $certificate->id)" method="PUT" id="editInvoiceForm" novalidate hasJsValidation>
        <div class="row">
            <div class="col-12 mb-4">
                <div class="card border-light shadow-sm components-section">
                    <div class="card-header">
                        {{ __('Rechnung Empfänger') }}
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <x-form.input name="certificate_number" :value="$certificate->certificate_number" :label="__('Bescheinigung Nr.')" :labelClass="'col-sm-3'" disabled />
                                <x-form.flat-pickr name="issue_date" :value="$certificate->issue_date" :label="__('Erstellungsdatum')" :labelClass="'col-sm-3'" :week-numbers="true" :allow-input="true" required />
                                <x-form.flat-pickr name="examination_date" :value="$certificate->examination_date" :label="__('Untersuchungsdatum')" :labelClass="'col-sm-3'" :week-numbers="true" :allow-input="true" required />

                                <x-form.select data-name="salutation" :value="$certificate->salutation" data-skip-name="false" name="salutation" class="" :label="__('Anrede')" :options="$salutationTypeOptions" :labelClass="'col-sm-3'" required />
                                <x-form.input name="title" :value="$certificate->title" :label="__('Titel')" :labelClass="'col-sm-3'" />
                                <x-form.input name="first_name" :value="$certificate->first_name" :label="__('Vorname')" :labelClass="'col-sm-3'" required />
                                <x-form.input name="middle_name" :value="$certificate->middle_name" :label="__('Zweiter Vorname')" :labelClass="'col-sm-3'" />
                                <x-form.input name="last_name" :value="$certificate->last_name" :label="__('Nachname')" :labelClass="'col-sm-3'" required />
                                <x-form.flat-pickr name="birthday" :value="$certificate->birthday" :label="__('Geburtsdatum')" :labelClass="'col-sm-3'" :week-numbers="true" :allow-input="true" required />

                            </div>
                            <div class="col-sm-6">
                                <x-form.input name="employed_at" :value="$certificate->employed_at" :label="__('Arbeitgeber')" :labelClass="'col-sm-3'" />
                                <x-form.input name="employer_street" :value="$certificate->employer_street" :label="__('Straße (Arbeitgeber)')" :labelClass="'col-sm-3'" required />
                                <x-form.input name="employer_house_number" :value="$certificate->employer_house_number" :label="__('Hausnummer (Arbeitgeber)')" :labelClass="'col-sm-3'" required />
                                <x-form.input name="employer_city" :value="$certificate->employer_city" :label="__('Ort (Arbeitgeber)')" :labelClass="'col-sm-3'" required />
                                <x-form.input name="employer_postcode" :value="$certificate->employer_postcode" :label="__('PLZ (Arbeitgeber)')" :labelClass="'col-sm-3'" />
                                <x-form.input name="phone" :value="$certificate->phone" :label="__('Telefonnummer')" :labelClass="'col-sm-3'" />
                                <x-form.input name="mobile" :value="$certificate->mobile" :label="__('Mobilnummer')" :labelClass="'col-sm-3'" />
                                <x-form.checkbox :row="'row mb-3 border rounded-3 border-gray-300 p-2'" name="is_employer" :checked="$certificate->is_employer" :switch="true" :label="__('Arbeitgeber')" :labelClass="'col-sm-3 mt-1'" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 mb-4">
                <div class="card border-light shadow-sm components-section">
                    <div class="card-header">
                        {{ __('Vorsorgen') }}
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <x-form.clone-repeater id="repeaterPanel" name="preventions" :label="__('Vorsorgen')" :labelClass="'col-sm-3'" :heading="'Vorsorgen'" >
                                    @if($certificate->preventions?->count() > 0)
                                        <x-slot name="existingItems">
                                            @foreach($certificate->preventions as $key => $prevention)
                                                <div class="items" data-group="preventions" id="preventions">
                                                    <div class="row">
                                                        <div class="col-12 mb-2">
                                                            <div class="card border-light shadow-sm components-section">
                                                                <div class="card-body">
                                                                    <div class="item-content col-12">
                                                                        <x-form.input data-name="id" data-skip-name="false" type="hidden" name="preventions.{{ $key }}.id" :value="$prevention->id" />
                                                                        <x-form.select data-name="activity_id" data-skip-name="false" name="preventions.{{ $key }}.activity_id" class="" :label="__('Tätigkeit/ Anlass')" :value="$prevention->activity?->id" :options="$activityOptions" :labelClass="'col-sm-3'" required />
                                                                        <x-form.select data-name="prevention_type" data-skip-name="false" name="preventions.{{ $key }}.prevention_type" class="" :label="__('Art der Vorsorge')" :value="$prevention->prevention_type->value" :options="$preventionTypeOptions" :labelClass="'col-sm-3'" required />
                                                                        <x-form.vanilla-datepicker
                                                                            data-name="next_appointment_date"
                                                                            name="next_appointment_date"
                                                                            :label="__('Nächster Termin')"
                                                                            :value="formatDate($prevention->next_appointment_date)"
                                                                            :labelClass="'col-sm-3'"
                                                                            required
                                                                        />
                                                                    </div>
                                                                </div>
                                                                <div class="card-footer">
                                                                    <div class="float-end repeater-remove-btn">
                                                                        <button type="button" class="btn btn-danger remove-btn" title="{{ __('Löschen') }}">
                                                                            <i class="fas fa-trash"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </x-slot>
                                   @endif
                                   @if(is_null($certificate->preventions) || $certificate->preventions?->count() === 0)
                                        <x-slot name="customItems">
                                            <div class="items" data-group="preventions" id="preventions">
                                                <div class="row">
                                                    <div class="col-12 mb-2">
                                                        <div class="card border-light shadow-sm components-section">
                                                            <div class="card-body">
                                                                <div class="item-content col-12">
                                                                    <x-form.select data-name="activity_id" data-skip-name="false" name="activity_id" class="" :label="__('Tätigkeit/ Anlass')" :options="$activityOptions" :labelClass="'col-sm-3'" required />
                                                                    <x-form.select data-name="prevention_type" data-skip-name="false" name="prevention_type" class="" :label="__('Art der Vorsorge')" :options="$preventionTypeOptions" :labelClass="'col-sm-3'" required />
                                                                    <x-form.vanilla-datepicker data-name="next_appointment_date" name="next_appointment_date" :label="__('Nächster Termin')" :value="now()->format('d.m.Y')" :labelClass="'col-sm-3'" required />
                                                                </div>
                                                            </div>
                                                            <div class="card-footer">
                                                                <div class="float-end repeater-remove-btn">
                                                                    <button type="button" class="btn btn-danger remove-btn" title="{{ __('Löschen') }}">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </x-slot>
                                   @endif
                                </x-form.clone-repeater>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer border-success p-2 footer-light">
                        <button type="submit" id="btnFormSubmit" class="btn btn-secondary float-end">{{ __('Speichern') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </x-form.form>
@endsection



