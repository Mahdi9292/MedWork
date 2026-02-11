<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('sections.default.head')
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-white bg-white border-bottom sticky-top">
    <div class="container">
        <button class="navbar-toggler border-0 shadow-none ps-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <i class="bi bi-list fs-3"></i>
        </button>

        <x-app-logo href="{{ route('dashboard') }}" wire:navigate class="navbar-brand me-4" />

        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active fw-bold border-bottom border-primary' : '' }}"
                       href="{{ route('dashboard') }}" wire:navigate>
                        {{ __('Dashboard') }}
                    </a>
                </li>
            </ul>

            <div class="d-flex align-items-center gap-3">
                <a href="#" class="text-muted text-decoration-none">
                    <i class="bi bi-search fs-5"></i>
                </a>
                <x-desktop-user-menu />
            </div>
        </div>
    </div>
</nav>

<main class="container py-4">
    {{ $slot }}
</main>

@stack('scripts')
</body>
</html>
