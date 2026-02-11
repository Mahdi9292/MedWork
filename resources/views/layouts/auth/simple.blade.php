<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('sections.default.head')
</head>
<body class="bg-white antialiased">
<div class="container">
    <div class="row min-vh-100 align-items-center justify-content-center p-3">
        <div class="col-12 col-sm-9 col-md-7 col-lg-5 col-xl-4">

            <div class="text-center mb-5">
                <a href="{{ route('home') }}" class="text-decoration-none d-inline-flex flex-column align-items-center" wire:navigate>
                    <x-app-logo-icon style="width: 48px; height: 48px;" class="text-dark mb-2" />
                    <span class="visually-hidden">{{ config('app.name', 'Laravel') }}</span>
                </a>
            </div>

            <div class="px-2">
                {{ $slot }}
            </div>

        </div>
    </div>
</div>
</body>
