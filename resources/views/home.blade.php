@extends('layouts.app.noside')

@section('content')

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-3 mb-md-0">
{{--            <x-template.breadcrumb :activePage="config('constants.APPLICATIONS.TWAP.TITLE')" />--}}
{{--            <h2 class="h4">{{ config('constants.APPLICATIONS.TWAP.TITLE') }}</h2>--}}
{{--            <p class="mb-0"></p>--}}
        </div>
    </div>

    <div class="row">
        <x-template.landing-page-tile
            title="Rechnungen" :url="url('/invoice')"
            :version="'1.1'"
            :sub-title="__('neuen Bestelleingänge')"
            :short-info="__('Übersicht und Erfassung der Bestelleingänge zu neuen Maschinen')"
            :permissions="['manager', 'user']"
            {{--            :version="config('constants.app_version.OrderBook')"--}}
        />

        <x-template.landing-page-tile
            title="Medizin" :url="url('/medical')"
            :version="'1.1'"
            :sub-title="__('VorsorgeBescheinigungen')"
            :short-info="__('Übersicht und Erfassung den VorsorgeBescheinigungen')"
            :permissions="['manager', 'user']"
            {{--            :version="config('constants.app_version.OrderBook')"--}}
        />
    </div>

    <hr>

    <div class="row">
        <div class="row">
            <x-template.landing-page-tile
                title="Administration" :url="route('users.roles.edit', Auth::user())"
                :version="'1.1'"
                :sub-title="__('Rolle bearbeiten')"
                :short-info="__('Übersicht für Administration')"
                :permissions="['']"
                {{--            :version="config('constants.app_version.OrderBook')"--}}
            />
        </div>
    </div>

@endsection
