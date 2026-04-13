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

{{--    <livewire:finance.invoice-manage-screen :invoice="$invoice" :update-mode="false" />--}}

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <x-template.breadcrumb :activePage="__('neuer Rechnung')" :links="[
                ['key' => config('constants.APPLICATIONS.FINANCE.TITLE'), 'url' => url('finance')],
                ['key' => __('Rechnung'), 'url' => route('finance.invoices.index')]
            ]" />
            <h2 class="h4">{{ __('Rechnung Erstellen') }}</h2>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('finance.invoices.create') }}" class="btn btn-sm btn-gray-800 d-inline-flex align-items-center">Zurück setzen</a>
            <a href="javascript:" onclick="document.getElementById('btnFormSubmit').click();" class="btn btn-sm btn-secondary mx-2">{{ __('Erstellen') }}</a>
        </div>
    </div>

    <x-template.notification />

    <x-form.form :action="route('finance.invoices.store')" id="createOfferForm" novalidate hasJsValidation>
        <div class="row">
            <div class="col-12 mb-4">
                <div class="card border-light shadow-sm components-section">
                    <div class="card-header">
                        {{ __('Rechnung Empfänger') }}
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <x-form.input name="invoice_number" :label="__('Rechnung Nr.')" :labelClass="'col-sm-3'" required />
                                <x-form.input name="street" :label="__('Straße')" :labelClass="'col-sm-3'" required />
                                <x-form.input name="city" :label="__('Stadt')" :labelClass="'col-sm-3'" required />
                                <x-form.input name="phone" :label="__('Tel.')" :labelClass="'col-sm-3'" />
                                <x-form.flat-pickr name="invoice_date" :label="__('Rechnungsdatum')" :value="Carbon\Carbon::now()" :labelClass="'col-sm-3'" :week-numbers="true" :allow-input="true" required />
                            </div>
                            <div class="col-sm-6">
                                <x-form.input name="name" :label="__('Name')" :labelClass="'col-sm-3'" required />
                                <x-form.input name="house_number" :label="__('Haus Nr.')" :labelClass="'col-sm-3'" required />
                                <x-form.input name="postcode" :label="__('PLZ')" :labelClass="'col-sm-3'" required />
                                <x-form.input name="mobile" :label="__('Mobil')" :labelClass="'col-sm-3'" />
                                <x-form.input name="value_added_tax" :label="__('MwSt in %')" :trailingAddon="'%'" :labelClass="'col-sm-3'" />
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
                                <x-form.clone-repeater id="repeaterPanel" name="services" :label="__('Leistungen')" :labelClass="'col-sm-2'" :heading="'Leistungen'" >
                                    <x-slot name="customItems">
                                        <div class="items" data-group="services" id="services">
                                            <div class="row">
                                                <div class="col-12 mb-2">
                                                    <div class="card border-light shadow-sm components-section">
                                                        <div class="card-body">
                                                            <div class="item-content col-12">
                                                                <x-form.select data-name="service_type" data-skip-name="false" name="service_type" class="" :label="__('Leistungstyp')" :options="$serviceTypeOptions" :labelClass="'col-sm-3'" />
                                                                <x-form.input data-name="service_title" data-skip-name="false" name="service_title" :label="__('Andere Leistung')" class="" :labelClass="'col-sm-3'" />
                                                                <x-form.textarea data-name="description" data-skip-name="false" name="description" :label="__('Beschreibung')" class="" :labelClass="'col-sm-3'" />
                                                                <x-form.vanilla-datepicker data-name="service_date" name="service_date" :label="__('Leistungsdatum')" :value="now()->format('d.m.Y')" :labelClass="'col-sm-3'" required />
                                                                <x-form.select data-name="quantity" data-skip-name="false" name="quantity" class="" :label="__('Menge')" :options="$quantityOptions" :labelClass="'col-sm-3'" />
                                                                <x-form.input data-name="unit_price" data-skip-name="false" name="unit_price" :trailingAddon="'€'" :label="__('Basis-Preis in €')" class="" :labelClass="'col-sm-3'" required />
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
                                </x-form.clone-repeater>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer border-success p-2 footer-light">
                        <button type="submit" id="btnFormSubmit" class="btn btn-secondary float-end">{{ __('Erstellen') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </x-form.form>
@endsection

@section('pageScripts')
    @parent
    <script>
        document.addEventListener('livewire:init', function () {
            Livewire.on('invoiceItemAdded', (params) => {
                closeAll();
                setTimeout(() => {
                    openOne(params.lastIndex);
                }, 300);
            })

            Livewire.on('invoiceItemCopied', params => {
                closeAll();
                setTimeout(() => {
                    openOne(params.lastIndex);
                }, 300);
            })
        })
    </script>
@endsection

