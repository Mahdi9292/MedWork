@extends('templates.orderbook.base')

@section('content')

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <x-template.breadcrumb :activePage="__('neuer Verantwortlicher')" :links="[
                ['key' => config('constants.APPLICATIONS.ORDERBOOK.TITLE'), 'url' => url('orderbook')],
                ['key' => __('Verantwortlicher'), 'url' => route('orderbook.responsibles.index')]
            ]" />
            <h2 class="h4">{{ __('Verantwortlicher') }}</h2>
        </div>
    </div>

    <x-template.notification />

    <div class="row">
        <div class="col-12 mb-4">
            <div class="card border-light shadow-sm components-section">
                <div class="card-body">
                    <div class="col-lg-9 col-sm-12">
                        <x-form.form :action="route('orderbook.responsibles.store')" novalidate hasJsValidation>

                            <x-form.input name="lastname" :label="__('Nachname')"  required  />
                            <x-form.input name="firstname" :label="__('Vorname')" required  />
                            <x-form.input name="street" :label="__('Strasse')" required  />
                            <x-form.input name="city" :label="__('Stadt')" required  />
                            <x-form.input name="email" :label="__('E-mail')" required  />
                            <x-form.input name="phone" :label="__('Telefon')" required  />
                            <x-form.select name="region_id" :label="__('Region')" :options="$regions" required />
                            <x-form.input name="postcode" :label="__('Postleitzahl')" required  />
                            <x-form.input name="fax" :label="__('Fax')" />
                            <x-form.checkbox name="active" :label="__('Aktiv')" :switch="true" checked/>
                            <button type="submit" class="btn btn-secondary">{{ __('Speichern') }}</button>

                        </x-form.form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
