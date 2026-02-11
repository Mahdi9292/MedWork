<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('sections.default.head')
</head>
<body class="bg-light antialiased">
<div class="container">
    <div class="row min-vh-100 align-items-center justify-content-center p-3">
        <div class="col-12 col-sm-10 col-md-8 col-lg-5 col-xl-4">

            <div class="text-center mb-4">
                <a href="{{ route('home') }}" class="text-decoration-none d-inline-flex flex-column align-items-center" wire:navigate>
                    <x-app-logo-icon style="width: 48px; height: 48px;" class="text-primary mb-2" />
                    <span class="visually-hidden">{{ config('app.name', 'Laravel') }}</span>
                </a>
            </div>

            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4 p-md-5">
                    {{ $slot }}
                </div>
            </div>

            <div class="text-center mt-4">
                <p class="small text-muted">&copy; {{ date('Y') }} {{ config('app.name') }}</p>
            </div>

        </div>
    </div>
</div>
</body>
</html>
