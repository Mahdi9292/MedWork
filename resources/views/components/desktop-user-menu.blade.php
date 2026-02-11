<div class="dropdown">
    <button
        class="btn btn-link text-decoration-none dropdown-toggle d-flex align-items-center gap-2 p-0 border-0"
        type="button"
        data-bs-toggle="dropdown"
        aria-expanded="false"
    >
        <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-size: 0.8rem;">
            {{ auth()->user()->initials() }}
        </div>
        <span class="text-dark small d-none d-md-inline">{{ auth()->user()->name }}</span>
    </button>

    <ul class="dropdown-menu dropdown-menu-end shadow-sm">
        <li>
            <div class="dropdown-item-text d-flex align-items-center gap-2 py-2">
                <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                    {{ auth()->user()->initials() }}
                </div>
                <div class="overflow-hidden">
                    <p class="mb-0 fw-bold small text-truncate">{{ auth()->user()->name }}</p>
                    <p class="mb-0 text-muted small text-truncate">{{ auth()->user()->email }}</p>
                </div>
            </div>
        </li>
        <li><hr class="dropdown-divider"></li>
        <li>
            <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('profile.edit') }}" wire:navigate>
                <i class="bi bi-gear"></i> {{ __('Settings') }}
            </a>
        </li>
        <li>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="dropdown-item d-flex align-items-center gap-2 text-danger">
                    <i class="bi bi-box-arrow-right"></i> {{ __('Log Out') }}
                </button>
            </form>
        </li>
    </ul>
</div>
