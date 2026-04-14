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
    <livewire:finance.invoice-manage-screen :invoice="$invoice" :update-mode="false" />

    <x-form.select data-name="service_type" data-skip-name="false" name="service_type" class="" :label="__('Leistungstyp')" :options="$serviceTypeOptions" :labelClass="'col-sm-3'" />
    <x-form.input data-name="service_title" data-skip-name="false" name="service_title" :label="__('Andere Leistung')" class="" :labelClass="'col-sm-3'" />
    <x-form.textarea data-name="description" data-skip-name="false" name="description" :label="__('Beschreibung')" class="" :labelClass="'col-sm-3'" />
    <x-form.vanilla-datepicker data-name="service_date" name="service_date" :label="__('Leistungsdatum')" :value="now()->format('d.m.Y')" :labelClass="'col-sm-3'" required />
    <x-form.select data-name="quantity" data-skip-name="false" name="quantity" class="" :label="__('Menge')" :options="$quantityOptions" :labelClass="'col-sm-3'" />
    <x-form.input data-name="unit_price" data-skip-name="false" name="unit_price" :trailingAddon="'€'" :label="__('Basis-Preis in €')" class="" :labelClass="'col-sm-3'" required />



@endsection

@section('pageScripts')
    @parent
    <script>
        document.addEventListener('livewire:init', function () {
            Livewire.on('invoiceItemAdded', (params) => {
                closeAll();
                setTimeout(() => {
                    openOne(params.lastIndex);
                }, 300);
            })

            Livewire.on('invoiceItemCopied', params => {
                closeAll();
                setTimeout(() => {
                    openOne(params.lastIndex);
                }, 300);
            })
        })
    </script>
@endsection

