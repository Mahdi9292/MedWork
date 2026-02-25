@extends('templates.orderbook.base')

@section('content')

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <x-template.breadcrumb :activePage="__('Verantwortlicher')" :links="[['key' => config('constants.APPLICATIONS.ORDERBOOK.TITLE'), 'url' => url('orderbook')]]" />
            <h2 class="h4">{{ __('Verantwortlicher') }}</h2>
            <p class="mb-0"></p>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            @can(config('perm.orderbook.responsibles.create'))
                <div class="btn-group">
                    <a href="{{ route('orderbook.responsibles.create') }}" type="button" class="btn btn-sm btn-gray-800"><span class="fas fa-plus me-2"></span> {{ __('Neu') }}</a>
                </div>
            @endcan
            <div class="btn-group ms-2 ms-lg-3">
                <button class="btn btn-sm btn-outline-primary" title="{{ __('alle verwendeten Filters zurücksetzen') }}" onclick="resetFilters('orderbook-responsible-table')"><i class="fas fa-times-circle"></i> {{ __('Filter') }}</button>
            </div>
        </div>
    </div>
    <x-template.notification />
    <div class="card card-body shadow-sm table-wrapper table-responsive table-power-grid">
        <livewire:order-book.data-tables.system.responsible-table />
    </div>

@endsection

