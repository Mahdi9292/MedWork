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
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                    <li class="breadcrumb-item">
                        <a href="#">
                            <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#">Volt</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Rechnungen</li>
                </ol>
            </nav>
            <h2 class="h4">All Invoices</h2>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('invoices.create') }}" class="btn btn-sm btn-gray-800 d-inline-flex align-items-center">
                <svg class="icon icon-xs me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg> New Plan</a>
            <div class="btn-group ms-2 ms-lg-3">
                <button type="button" class="btn btn-sm btn-outline-gray-600">Share</button>
                <button type="button" class="btn btn-sm btn-outline-gray-600">Export</button>
            </div>
        </div>
    </div>

    <x-form.form :action="route('toffer.offers.store')" id="createOfferForm" novalidate hasJsValidation>
        <div class="row">
            <div class="col-12 mb-4">
                <div class="card border-light shadow-sm components-section">
                    <div class="card-header">
                        {{ __('Kopfdaten') }}
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <x-form.tom-select name="creator_id" :label="__('Ersteller')" :options="$creatorOptions" :labelClass="'col-sm-3'" :value="Auth::user()->id"  required />
                                <x-form.show name="created_at" :label="__('Erstelldatum')"  :value="Carbon\Carbon::now()->format('d.m.Y')" :labelClass="'col-sm-3'" required />
                                <x-form.tom-select name="contract_type_id" :label="__('Vertragsart')" :options="$contractTypeOptions" :labelClass="'col-sm-3'" required />
                                <x-form.input name="rental_start" :label="__('Mietbeginn')" :labelClass="'col-sm-3'" />
                                <x-form.select name="transport_type_id" :label="__('Transportart')" :options="$transportTypeOptions" :labelClass="'col-sm-3'" />
                                <x-form.textarea name="internal_comment" :label="__(' Interner Kommentar')" :labelClass="'col-sm-3'" />
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
                        {{ __('Kunde') }}
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-8">
                                <div>
                                    <livewire:customers.search :fields="collect([
                                        'id'=> 'customer_id',
                                        'name' => 'customer_name',
                                        'first_name' => 'customer_first_name',
                                        'last_name' => 'customer_last_name',
                                        'street' => 'customer_street',
                                        'postcode' => 'customer_postcode',
                                        'city' => 'customer_city',
                                        'phone' => 'customer_phone',
                                        'mobile' => 'customer_mobile',
                                        'mail' => 'customer_mail',
                                        ])">
                                    </livewire:customers.search>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <x-form.input name="customer_id" :label="__('ID')" :labelClass="'col-sm-3'" />
                                    <x-form.input name="customer_name" :label="__('Name')" :labelClass="'col-sm-3'"  />
                                    <x-form.input name="customer_name_2" :label="__('Zusatz')" :labelClass="'col-sm-3'" />
                                    <x-form.input name="customer_first_name" :label="__('Vorname')" :labelClass="'col-sm-3'"  />
                                    <x-form.input name="customer_last_name" :label="__('Nachname')" :labelClass="'col-sm-3'"  />
                                    <x-form.input name="customer_mail" :label="__('eMail')" :labelClass="'col-sm-3'"  />
                                    <x-form.input name="salutation" :label="__('Anrede')" :labelClass="'col-sm-3'" required />
                                </div>
                                <div class="col-sm-6">
                                    <x-form.input name="customer_street" :label="__('Straße')" :labelClass="'col-sm-3'" />
                                    <x-form.input name="customer_postcode" :label="__('PLZ')" :labelClass="'col-sm-3'" />
                                    <x-form.input name="customer_city" :label="__('Stadt')" :labelClass="'col-sm-3'" />
                                    <x-form.input name="customer_phone" :label="__('Tel:')" :labelClass="'col-sm-3'"  />
                                    <x-form.input name="customer_mobile" :label="__('Mobil:')" :labelClass="'col-sm-3'"  />
                                    <x-form.textarea name="customer_location" :label="__('Einsatzort:')" :labelClass="'col-sm-3'"  />
                                </div>
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



