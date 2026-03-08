<div class="container-fluid py-4">
    <div class="row">
        <!-- Settings Navigation Sidebar -->
        <div class="col-12 col-md-3 col-lg-2 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-body p-0">
                    <div class="list-group list-group-flush rounded-3">
                        <a href="{{ route('profile.edit') }}" wire:navigate class="list-group-item list-group-item-action {{ request()->routeIs('profile.edit') ? 'active bg-primary text-white border-primary' : '' }}">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-person me-2"></i> {{ __('Profile') }}
                            </div>
                        </a>
                        <a href="{{ route('user-password.edit') }}" wire:navigate class="list-group-item list-group-item-action {{ request()->routeIs('user-password.edit') ? 'active bg-primary text-white border-primary' : '' }}">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-key me-2"></i> {{ __('Password') }}
                            </div>
                        </a>
                        @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                            <a href="{{ route('two-factor.show') }}" wire:navigate class="list-group-item list-group-item-action {{ request()->routeIs('two-factor.show') ? 'active bg-primary text-white border-primary' : '' }}">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-shield-lock me-2"></i> {{ __('Two-Factor Auth') }}
                                </div>
                            </a>
                        @endif
                        <a href="{{ route('appearance.edit') }}" wire:navigate class="list-group-item list-group-item-action {{ request()->routeIs('appearance.edit') ? 'active bg-primary text-white border-primary' : '' }}">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-palette me-2"></i> {{ __('Appearance') }}
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Settings Content Column -->
        <div class="col-12 col-md-9 col-lg-10">
            @if(isset($heading) || isset($subheading))
                <div class="mb-4">
                    @if(isset($heading))<h3 class="h4 mb-1">{{ $heading }}</h3>@endif
                    @if(isset($subheading))<p class="text-muted">{{ $subheading }}</p>@endif
                </div>
            @endif

            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</div>
