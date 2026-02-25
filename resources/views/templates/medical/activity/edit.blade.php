@extends('templates.orderbook.base')

@section('content')

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <x-template.breadcrumb :activePage="$responsible->lastname" :links="[['key' => config('constants.APPLICATIONS.ORDERBOOK.TITLE'), 'url' => url('orderbook')]]" >
                <li class="breadcrumb-item"><a href="{{ route('orderbook.responsibles.index') }}">{{ __('Verantwortlicher') }}</a></li>
            </x-template.breadcrumb>
            <h2 class="h4">{{ __('Verantwortlicher') }}</h2>
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

                        <x-form.form :action="route('orderbook.responsibles.update', $responsible->id)" method="PUT" novalidate hasJsValidation>

                            <x-form.input name="lastname" :label="__('Nachname')" :value="$responsible->lastname" :labelClass="'col-sm-3'"  required  />
                            <x-form.input name="firstname" :label="__('Vorname')" :value="$responsible->firstname" :labelClass="'col-sm-3'"  />
                            <x-form.input name="street" :label="__('Strasse')" :value="$responsible->street" :labelClass="'col-sm-3'"  />
                            <x-form.input name="city" :label="__('Stadt')" :value="$responsible->city" :labelClass="'col-sm-3'"  />
                            <x-form.input name="email" :label="__('E-mail')" :value="$responsible->email" :labelClass="'col-sm-3'"  />
                            <x-form.input name="phone" :label="__('Telefon')" :value="$responsible->phone" :labelClass="'col-sm-3'"  />
                            <x-form.select name="region_id" :label="__('Region')" :options="$regions" :value="$responsible->region_id" :labelClass="'col-sm-3'" />
                            <x-form.input name="postcode" :label="__('Postleitzahl')" :value="$responsible->postcode" :labelClass="'col-sm-3'"  />
                            <x-form.input name="fax" :label="__('Fax')" :value="$responsible->fax" :labelClass="'col-sm-3'" />
                            <x-form.checkbox name="active" :label="__('Aktiv')" :switch="true" :value="$responsible->active" :labelClass="'col-sm-3'" checked/>

                            <button type="submit" class="btn btn-secondary">{{ __('Speichern') }}</button>

                        </x-form.form>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
