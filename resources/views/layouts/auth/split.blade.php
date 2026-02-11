<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('sections.default.head')
</head>
<body class="bg-white antialiased">
<div class="container-fluid p-0">
    <div class="row g-0 min-vh-100">

        <div class="col-lg-6 d-none d-lg-flex flex-column justify-content-between p-5 bg-dark text-white position-relative">
            <div class="position-absolute inset-0 opacity-25">
                {{-- Optional: You could place your <x-subtle-pattern /> here --}}
            </div>

            <div class="position-relative z-1">
                <a href="{{ route('home') }}" class="d-flex align-items-center text-white text-decoration-none h4 fw-bold" wire:navigate>
                    <x-app-logo-icon style="width: 32px; height: 32px;" class="me-2" />
                    {{ config('app.name', 'Laravel') }}
                </a>
            </div>

            @php
                [$message, $author] = str(Illuminate\Foundation\Inspiring::quotes()->random())->explode('-');
            @endphp

            <div class="position-relative z-1 mt-auto">
                <blockquote class="blockquote">
                    <h2 class="display-6 fw-normal mb-3">&ldquo;{{ trim($message) }}&rdquo;</h2>
                    <footer class="blockquote-footer text-white-50">{{ trim($author) }}</footer>
                </blockquote>
            </div>
        </div>

        <div class="col-12 col-lg-6 d-flex align-items-center justify-content-center p-4 p-md-5">
            <div class="w-100" style="max-width: 400px;">

                <div class="d-lg-none text-center mb-4">
                    <a href="{{ route('home') }}" wire:navigate>
                        <x-app-logo-icon style="width: 48px; height: 48px;" class="text-dark" />
                    </a>
                </div>

                {{ $slot }}
            </div>
        </div>

    </div>
</div>
</body>
</html>
