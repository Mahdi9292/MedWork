@extends('layouts.app')

@section('content')

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <x-template.breadcrumb :activePage="config('constants.APPLICATIONS.FINANCE.TITLE')" />
            <h2 class="h4">{{ config('constants.APPLICATIONS.FINANCE.TITLE') }}</h2>
            <p class="mb-0"></p>
        </div>
    </div>
    <div class="card">
        <h5 class="card-header">Dashboard</h5>
        <div class="card-body">
            <h5 class="card-title"> Übersicht und Erfassung der Bestelleingänge zu neuen Maschinen. </h5>

            <table class="table table-centered table-nowrap mb-0 rounded table-striped">

                <tbody>
                    <tr>
                        <td>
                            {{ __('Sponsor') }}
                        </td>
                        <td>
                            <a class="small fw-bold" href="mailto:Oliver.Glaser@de.toyota-industries.eu">Dr. Majid Taghvaei</a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {{ __('Manager') }}
                        </td>
                        <td>
                            <a class="small fw-bold" href="mailto:andre.storch@de.toyota-industries.eu">Dr. Majid Taghvaei</a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {{ __('Support') }}
                        </td>
                        <td>
                            <a class="small fw-bold" href="mailto:servicedesk.tmhd@de.toyota-industries.eu">Mahdi Shaker</a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {{ __('Entwickler') }}
                        </td>
                        <td>
                            <a class="small fw-bold" href="mailto:Mahdi.Shaker@de.toyota-industries.eu">Mahdi Shaker</a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {{ __('Version:') }}
                        </td>
                        <td>
                            {{ config('constants.app_version.MEDICAL') }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

@endsection
