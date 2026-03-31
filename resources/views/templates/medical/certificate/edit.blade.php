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
    <livewire:medical.certificate-manage-screen :certificate="$certificate" :update-mode="true" />
@endsection

@section('pageScripts')
    @parent
    <script>
        document.addEventListener('livewire:init', function () {
            Livewire.on('preventionAdded', (params) => {
                closeAll();
                setTimeout(() => {
                    openOne(params.lastIndex);
                }, 300);
            })

            Livewire.on('preventionCopied', params => {
                closeAll();
                setTimeout(() => {
                    openOne(params.lastIndex);
                }, 300);
            })
        })
    </script>
@endsection


