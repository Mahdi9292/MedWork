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

{{--    <livewire:invoice.invoice-manage-screen :invoice="$invoice"/>--}}

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}">
                            <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('invoices.index') }}">Rechnungen</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Rechnung bearbeiten</li>
                </ol>
            </nav>
            <h2 class="h4">Rechnung bearbeiten</h2>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('invoices.index') }}" class="btn btn-sm btn-gray-800 d-inline-flex align-items-center">
                <svg class="icon icon-xs me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg> Zurück zur Übersicht</a>

        </div>
    </div>

    <x-form.form :action="route('invoices.update', $invoice->id)" method="PUT" id="createOfferForm" novalidate hasJsValidation>
        <div class="row">
            <div class="col-12 mb-4">
                <div class="card border-light shadow-sm components-section">
                    <div class="card-header">
                        {{ __('Rechnung Empfänger') }}
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <x-form.input name="invoice_number" :label="__('Rechnung Nr.')" :value="$invoice->invoice_number" :labelClass="'col-sm-3'" required />
                                <x-form.input name="street" :label="__('Straße')" :value="$invoice->street" :labelClass="'col-sm-3'" required />
                                <x-form.input name="city" :label="__('Stadt')" :value="$invoice->city" :labelClass="'col-sm-3'" required />
                                <x-form.input name="phone" :label="__('Tel.')" :value="$invoice->phone" :labelClass="'col-sm-3'" />
                            </div>

                            <div class="col-sm-6">
                                <x-form.input name="name" :label="__('Name')"  :value="$invoice->name" :labelClass="'col-sm-3'" required />
                                <x-form.input name="house_number" :label="__('Haus Nr.')" :value="$invoice->house_number" :labelClass="'col-sm-3'" required />
                                <x-form.input name="postcode" :label="__('PLZ')" :value="$invoice->postcode" :labelClass="'col-sm-3'" required />
                                <x-form.input name="mobile" :label="__('Mobil')" :value="$invoice->mobile" :labelClass="'col-sm-3'" />
                                <x-form.flat-pickr name="invoice_date" :label="__('Rechnungsdatum')" :value="$invoice->invoice_date" :labelClass="'col-sm-3'" :week-numbers="true" :allow-input="true" required />
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
                        {{ __('Leistungen') }}
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <x-form.clone-repeater id="repeaterPanel" name="services" :label="__('Leistungen')" :labelClass="'col-sm-3'" :heading="'Leistungen'" >
                                    @if($invoice->services?->count() > 0)
                                        <x-slot name="existingItems">
                                            @foreach($invoice->services as $key => $service)
                                                <div class="items" data-group="services" id="services">
                                                    <div class="row">
                                                        <div class="col-12 mb-2">
                                                            <div class="card border-light shadow-sm components-section">
                                                                <div class="card-body">
                                                                    <div class="item-content col-12">
                                                                        <x-form.input data-name="id" data-skip-name="false" type="hidden" name="services.{{ $key }}.id" :value="$service->id" />
                                                                        <x-form.select data-name="service_type" data-skip-name="false" name="services.{{ $key }}.service_type" class="" :label="__('Leistungstyp')" :value="$service->service_type->value" :options="$serviceTypeOptions" :labelClass="'col-sm-3'" required />
                                                                        <x-form.input data-name="service_title" data-skip-name="false" name="services.{{ $key }}.service_title" :label="__('Andere Leistung')" :value="$service->service_title" class="" :labelClass="'col-sm-3'" />
                                                                        <x-form.textarea data-name="description" data-skip-name="false" name="services.{{ $key }}.description" :label="__('Beschreibung')" :value="$service->description" class="" :labelClass="'col-sm-3'" />
                                                                        <x-form.vanilla-datepicker
                                                                            data-name="service_date"
                                                                            name="service_date"
                                                                            :label="__('Leistungsdatum')"
                                                                            :value="now()->format('d.m.Y')"
                                                                            :labelClass="'col-sm-3'"
                                                                            required
                                                                        />
                                                                        <x-form.select data-name="quantity" data-skip-name="false" name="services.{{ $key }}.quantity" class="" :label="__('Menge')" :value="$service->quantity->value" :options="$quantityOptions" :labelClass="'col-sm-3'" required />
                                                                        <x-form.input data-name="unit_price" data-skip-name="false" name="services.{{ $key }}.unit_price" :label="__('Basis-Preis')" :value="$service->unit_price" class="" :labelClass="'col-sm-3'" required />
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
                                   @if(is_null($invoice->services) || $invoice->services?->count() === 0)
                                        <x-slot name="customItems">
                                            <div class="items" data-group="services" id="services">
                                                <div class="row">
                                                    <div class="col-12 mb-2">
                                                        <div class="card border-light shadow-sm components-section">
                                                            <div class="card-body">
                                                                <div class="item-content col-12">
                                                                    <x-form.select data-name="service_type" data-skip-name="false" name="service_type" class="" :label="__('Leistungstyp')" :options="$serviceTypeOptions" :labelClass="'col-sm-3'" required />
                                                                    <x-form.input data-name="service_title" data-skip-name="false" name="service_title" :label="__('Andere Leistung')" class="" :labelClass="'col-sm-3'" />
                                                                    <x-form.textarea data-name="description" data-skip-name="false" name="description" :label="__('Beschreibung')" class="" :labelClass="'col-sm-3'" />
                                                                    {{--                                                                <x-form.flat-pickr name="service_date" :label="__('Leistungsdatum')" :value="Carbon\Carbon::now()" :labelClass="'col-sm-3'" :week-numbers="true" :allow-input="true" required />--}}
                                                                    <x-form.vanilla-datepicker
                                                                        data-name="service_date"
                                                                        name="service_date"
                                                                        :label="__('Leistungsdatum')"
                                                                        :value="now()->format('d.m.Y')"
                                                                        :labelClass="'col-sm-3'"
                                                                        required
                                                                    />
                                                                    <x-form.select data-name="quantity" data-skip-name="false" name="service_type" class="" :label="__('Menge')" :options="$quantityOptions" :labelClass="'col-sm-3'" required />
                                                                    <x-form.input data-name="unit_price" data-skip-name="false" name="unit_price" :label="__('Basis-Preis')" class="" :labelClass="'col-sm-3'" required />
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



