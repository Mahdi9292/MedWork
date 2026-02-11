<div class="card border rounded-3 bg-light" x-data="{ showRecoveryCodes: false }" wire:cloak>
    <div class="card-body p-4">
        <div class="d-flex align-items-start gap-3 mb-3">
            <div class="bg-white p-2 rounded border shadow-sm">
                <i class="bi bi-lock fs-5"></i>
            </div>
            <div>
                <h6 class="mb-1 fw-bold">{{ __('2FA Recovery Codes') }}</h6>
                <p class="text-muted small mb-0">
                    {{ __('Recovery codes let you regain access if you lose your 2FA device. Store them in a secure password manager.') }}
                </p>
            </div>
        </div>

        <div class="d-flex flex-wrap gap-2 mb-3">
            <button
                type="button"
                class="btn btn-sm btn-white border shadow-sm d-flex align-items-center gap-2"
                @click="showRecoveryCodes = !showRecoveryCodes"
            >
                <i :class="showRecoveryCodes ? 'bi bi-eye-slash' : 'bi bi-eye'"></i>
                <span x-text="showRecoveryCodes ? '{{ __('Hide Codes') }}' : '{{ __('View Recovery Codes') }}'"></span>
            </button>

            <button
                type="button"
                class="btn btn-sm btn-white border shadow-sm d-flex align-items-center gap-2"
                wire:click="regenerate"
                wire:loading.attr="disabled"
            >
                <i class="bi bi-arrow-repeat"></i>
                {{ __('Regenerate') }}
            </button>
        </div>

        <div x-show="showRecoveryCodes" x-transition class="mt-3">
            @if (filled($recoveryCodes))
                <div class="bg-dark text-white p-3 rounded font-monospace small mb-2">
                    <div class="row g-2">
                        @foreach($recoveryCodes as $code)
                            <div class="col-6" wire:loading.class="opacity-50">
                                {{ $code }}
                            </div>
                        @endforeach
                    </div>
                </div>
                <p class="text-muted" style="font-size: 0.75rem;">
                    {{ __('Each code can be used once. After use, it is invalidated.') }}
                </p>
            @endif
        </div>

        @error('recoveryCodes')
        <div class="alert alert-danger py-2 small mt-2">{{ $message }}</div>
        @enderror
    </div>
</div>
