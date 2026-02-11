<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('sections.default.head')
    <style>
        @media (min-width: 992px) {
            .sidebar { width: 280px; height: 100vh; position: fixed; top: 0; left: 0; z-index: 1000; overflow-y: auto; }
            .main-content { margin-left: 280px; }
        }
    </style>
</head>
<body class="bg-light">

<header class="navbar navbar-white bg-white border-bottom d-lg-none sticky-top p-2">
    <div class="container-fluid">
        <button class="btn border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar">
            <i class="bi bi-list fs-3"></i>
        </button>
        <x-app-logo href="{{ route('dashboard') }}" wire:navigate />
        <x-desktop-user-menu />
    </div>
</header>

<div class="container-fluid">
    <div class="row">
        <nav id="mobileSidebar" class="offcanvas-lg offcanvas-start sidebar bg-white border-end" tabindex="-1">
            <div class="offcanvas-header border-bottom">
                <x-app-logo href="{{ route('dashboard') }}" wire:navigate />
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#mobileSidebar" aria-label="Close"></button>
            </div>

            <div class="offcanvas-body d-flex flex-column p-3 h-100">
                <h6 class="text-uppercase text-muted small fw-bold mb-3 px-2">{{ __('Platform') }}</h6>
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}"
                           class="nav-link d-flex align-items-center gap-2 {{ request()->routeIs('dashboard') ? 'active' : 'text-dark' }}"
                           wire:navigate>
                            <i class="bi bi-house"></i> {{ __('Dashboard') }}
                        </a>
                    </li>
                </ul>

                <hr>

                <ul class="nav nav-pills flex-column mb-4">
                    <li class="nav-item">
                        <a href="https://laravel.com/docs" target="_blank" class="nav-link text-dark d-flex align-items-center gap-2">
                            <i class="bi bi-book"></i> {{ __('Documentation') }}
                        </a>
                    </li>
                </ul>

                <div class="mt-auto d-none d-lg-block pt-3 border-top">
                    <x-desktop-user-menu />
                </div>
            </div>
        </nav>

        <main class="main-content col p-0">
            <div class="p-4 p-md-5">
                {{ $slot }}
            </div>
        </main>
    </div>
</div>

@stack('scripts')
</body>
</html>
