@extends('layouts.app')

@section('content')

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <x-template.breadcrumb :activePage="$comment->id" :links="[['key' => config('constants.APPLICATIONS.MEDICAL.TITLE'), 'url' => url('medical')]]" >
                <li class="breadcrumb-item"><a href="{{ route('medical.comments.index') }}">{{ __('Kommentar') }}</a></li>
            </x-template.breadcrumb>
            <h2 class="h4">{{ __('Kommentar') }}</h2>
            <p class="mb-0"></p>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group">
                <a href="{{ route("medical.comments.index") }}" class="btn btn-sm btn-outline-primary">{{ __('Alle') }}</a>
            </div>
        </div>
    </div>
    <x-template.notification />
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card border-light shadow-sm components-section">
                <div class="card-body">

                    <div class="col-lg-8 col-sm-12">
                        <x-form.show name="type" :label="__('Typ')"  :value="$comment->type->label()" :labelClass="'col-sm-3'"   />
                        <x-form.show name="content" :label="__('Ehemalig')" :value="$comment->content" :labelClass="'col-sm-3'"   />

                        <a href="{{ route('medical.comments.index') }}" class="btn btn-primary">{{ __('Zurück zur Übersicht') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
