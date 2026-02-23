@extends('layouts.app')

@section('content')

<h2>Assign Roles to {{ $user->name }}</h2>

<x-form.form action="{{ route('users.roles.update', $user) }}">
    @foreach($roles as $role)
        <div>
            <x-form.checkbox name="roles[]" :value="$role->name" :label="$role->name" :switch="true" :checked="$user->hasRole($role->name)" :labelClass="'col-sm-3'" />
        </div>
    @endforeach

        <div class="card-footer border-success p-2 footer-light">
            <button type="submit" id="btnFormSubmit" class="btn btn-secondary">{{ __('Speichern') }}</button>
        </div>
</x-form.form>
@endsection
