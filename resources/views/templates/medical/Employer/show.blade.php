@extends('layouts.app')

@section('content')

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <x-template.breadcrumb :activePage="$activity->name" :links="[['key' => config('constants.APPLICATIONS.MEDICAL.TITLE'), 'url' => url('medical')]]" >
                <li class="breadcrumb-item"><a href="{{ route('medical.employers.index') }}">{{ __('Arbeitgeber') }}</a></li>
            </x-template.breadcrumb>
            <h2 class="h4">{{ __('Arbeitgeber') }}</h2>
            <p class="mb-0"></p>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group">
                <a href="{{ route("medical.employers.index") }}" class="btn btn-sm btn-outline-primary">{{ __('Alle') }}</a>
            </div>
        </div>
    </div>
    <x-template.notification />
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card border-light shadow-sm components-section">
                <div class="card-body">
                    <div class="col-lg-8 col-sm-12">
                        <div class="row">
                            <div class="col-12 mb-4">
                                <div class="card border-light shadow-sm components-section">
                                    <div class="card-header">
                                        {{ __('Arbeitgeber') }}
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <x-form.show name="name" :value="$employer->name" :label="__('Arbeitgeber')" :labelClass="'col-sm-3'" />
                                                <x-form.show name="Contact_person" :value="$employer->Contact_person" :label="__('Ansprechpartner')" :labelClass="'col-sm-3'" />
                                                <x-form.show name="address" :value="$employer->address" :label="__('Voll Adresse')" :labelClass="'col-sm-3'" />
                                                <x-form.show name="street" :value="$employer->street" :label="__('Straße')" :labelClass="'col-sm-3'" />
                                                <x-form.show name="house_number" :value="$employer->house_number" :label="__('Hausnummer')" :labelClass="'col-sm-3'" />
                                            </div>

                                            <div class="col-sm-6">
                                                <x-form.show name="city" :value="$employer->city" :label="__('Ort')" :labelClass="'col-sm-3'" />
                                                <x-form.show name="postcode" :value="$employer->postcode" :label="__('PLZ')" :labelClass="'col-sm-3'" />
                                                <x-form.show name="phone" :value="$employer->phone" :label="__('Telefonnummer')" :labelClass="'col-sm-3'" />
                                                <x-form.show name="mobile" :value="$employer->mobile" :label="__('Mobilnummer')" :labelClass="'col-sm-3'" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <a href="{{ route('medical.employers.index') }}" class="btn btn-primary">{{ __('Zurück zur Übersicht') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
