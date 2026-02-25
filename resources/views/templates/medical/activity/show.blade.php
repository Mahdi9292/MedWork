@extends('templates.orderbook.base')

@section('content')

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <x-template.breadcrumb :activePage="$responsible->lastname" :links="[['key' => config('constants.APPLICATIONS.ORDERBOOK.TITLE'), 'url' => url('orderbook')]]" >
                <li class="breadcrumb-item"><a href="{{ route('orderbook.responsibles.index') }}">{{ __('Verantwortlicher') }}</a></li>
            </x-template.breadcrumb>
            <h2 class="h4">{{ __('Auftragsbuch') }}</h2>
            <p class="mb-0"></p>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group">
                <a href="{{ route("orderbook.responsibles.index") }}" class="btn btn-sm btn-outline-primary">{{ __('Alle') }}</a>
            </div>
        </div>
    </div>
    <x-template.notification />
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card border-light shadow-sm components-section">
                <div class="card-body">

                    <div class="col-lg-8 col-sm-12">


                        <x-form.show name="lastname" :label="__('Nachname')"  :value="$responsible->lastname" :labelClass="'col-sm-3'"   />
                        <x-form.show name="firstname" :label="__('Vorname')" :value="$responsible->firstname" :labelClass="'col-sm-3'"   />
                        <x-form.show name="street" :label="__('Strasse')" :value="$responsible->street" :labelClass="'col-sm-3'"   />
                        <x-form.show name="city" :label="__('Stadt')" :value="$responsible->city" :labelClass="'col-sm-3'"   />
                        <x-form.show name="email" :label="__('E-mail')" :value="$responsible->email" :labelClass="'col-sm-3'"   />
                        <x-form.show name="phone" :label="__('Phone')" :value="$responsible->phone" :labelClass="'col-sm-3'"   />
                        <x-form.show name="region_id" :label="__('Region')" :value="$responsible->region->region" :labelClass="'col-sm-3'"  />
                        <x-form.show name="postcode" :label="__('Postleitzahl')" :value="$responsible->postcode" :labelClass="'col-sm-3'"   />
                        <x-form.show name="fax" :label="__('Fax')" :value="$responsible->fax" :labelClass="'col-sm-3'"/>
                        <x-form.checkbox name="active" :label="__('Aktiv')" :switch="true" :checked="$responsible->active" disabled :labelClass="'col-sm-3'"/>


                        <a href="{{ route('orderbook.responsibles.index') }}" class="btn btn-primary">{{ __('Zurück zur Übersicht') }}</a>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
