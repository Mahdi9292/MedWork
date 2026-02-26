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
            <x-template.breadcrumb :activePage="__('Rechnungen')" :links="[['key' => config('constants.APPLICATIONS.FINANCE.TITLE'), 'url' => url('finance')]]" />
            <h2 class="h4">{{ __('Rechnungen') }}</h2>
            <p class="mb-0"></p>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group">
                <a href="{{ route('finance.invoices.create') }}" type="button" class="btn btn-sm btn-gray-800"><span class="fas fa-plus me-2"></span> {{ __('Neu') }}</a>
            </div>
            <div class="btn-group ms-2 ms-lg-3">
                <button class="btn btn-sm btn-outline-primary" title="{{ __('alle verwendeten Filters zurücksetzen') }}" onclick="resetFilters('finance-invoice-table')"><i class="fas fa-times-circle"></i> {{ __('Filter') }}</button>
            </div>
        </div>
    </div>

    <x-template.notification />
    <div class="card card-body shadow-sm table-wrapper table-responsive table-power-grid">
        <livewire:finance.invoices-table />
    </div>

@endsection



