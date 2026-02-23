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
            :permissions="['']"
            {{--            :version="config('constants.app_version.OrderBook')"--}}
        />
    </div>



    <hr>

{{--    <div class="row">--}}
{{--        <x-template.landing-page-tile title="Administration" :url="url('/administration')" :sub-title="__('T-WAP Administration')" />--}}
{{--        <x-template.landing-page-tile title="Management" :url="url('/management')" :sub-title="__('T-WAP Entities Management')" :permissions="['DETWapManagementAdmins']" />--}}
{{--    </div>--}}

@endsection
