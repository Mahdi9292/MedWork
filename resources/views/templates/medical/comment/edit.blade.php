@extends('layouts.app')

@section('content')

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <x-template.breadcrumb :activePage="$comment->id" :links="[['key' => config('constants.APPLICATIONS.MEDICAL.TITLE'), 'url' => url('medical')]]" >
                <li class="breadcrumb-item"><a href="{{ route('medical.comments.index') }}">{{ __('Kommentar') }}</a></li>
            </x-template.breadcrumb>
            <h2 class="h4">{{ __('Kommentar bearbeiten') }}</h2>
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
                        <x-form.form :action="route('medical.comments.update', $comment->id)" method="PUT" novalidate hasJsValidation>

                            <x-form.select data-name="type" name="type" data-skip-name="false" :value="$comment->type" :label="__('Typ')" :options="$commentTypeOptions" required />
                            <x-form.textarea name="content" :value="$comment->content" :label="__('Inhalt')" required />

                            <button type="submit" class="btn btn-secondary">{{ __('Speichern') }}</button>
                        </x-form.form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
