@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-3 mb-md-0">
{{--            <x-template.breadcrumb :activePage="config('constants.APPLICATIONS.TWAP.TITLE')" />--}}
{{--            <h2 class="h4">{{ config('constants.APPLICATIONS.TWAP.TITLE') }}</h2>--}}
{{--            <p class="mb-0"></p>--}}
        </div>
    </div>

    <div class="row row-cols-1 row-cols-md-4 row-cols-lg-4 g-4">
        <x-template.landing-page-tile
            wrapClass="col"
            title="Finanz" :url="url('/finance')"
            :version="'1.1'"
            :sub-title="__('Finanzmanagement')"
            :short-info="__('Übersicht und Erfassung der Rechnungen')"
            :permissions="['manager', 'user']"
            {{--            :version="config('constants.app_version.OrderBook')"--}}
        />
        <x-template.landing-page-tile
            wrapClass="col"
            title="Medizin" :url="url('/medical')"
            :version="'1.1'"
            :sub-title="__('Vorsorge Bescheinigungen')"
            :short-info="__('Übersicht und Erfassung den Vorsorge Bescheinigungen')"
            :permissions="['manager', 'user']"
            {{--            :version="config('constants.app_version.OrderBook')"--}}
        />
    </div>
    <hr>
    <div class="row row-cols-1 row-cols-md-4 row-cols-lg-4 g-4">
        <x-template.landing-page-tile
            wrapClass="col"
            title="Administration" :url="route('users.roles.edit', Auth::user())"
            :version="'1.1'"
            :sub-title="__('Rolle bearbeiten')"
            :short-info="__('Übersicht für Administration')"
            :permissions="['']"
            {{--            :version="config('constants.app_version.OrderBook')"--}}
        />
    </div>
@endsection
