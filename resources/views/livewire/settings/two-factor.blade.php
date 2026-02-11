<section class="w-full">
    @include('sections.default.head')

    <x-settings.layout
        :heading="__('Two Factor Authentication')"
        :subheading="__('Manage your two-factor authentication settings')"
    >
        <div class="mt-4" wire:cloak>
            @if ($twoFactorEnabled)
                <div class="mb-4">
                    <span class="badge bg-success mb-3">{{ __('Enabled') }}</span>
                    <p class="text-muted small">
                        {{ __('With two-factor authentication enabled, you will be prompted for a secure, random pin during login, which you can retrieve from the TOTP-supported application on your phone.') }}
                    </p>
                </div>

                <livewire:settings.two-factor.recovery-codes :$requiresConfirmation/>

                <div class="mt-4">
                    <button
                        type="button"
                        class="btn btn-outline-danger d-inline-flex align-items-center gap-2"
                        wire:click="disable"
                    >
                        <i class="bi bi-shield-exclamation"></i>
                        {{ __('Disable 2FA') }}
                    </button>
                </div>
            @else
                <div class="mb-4">
                    <span class="badge bg-secondary mb-3">{{ __('Disabled') }}</span>
                    <p class="text-muted small">
                        {{ __('Two-factor authentication adds an additional layer of security to your account by requiring more than just a password to log in.') }}
                    </p>
                </div>

                <button
                    type="button"
                    class="btn btn-primary"
                    wire:click="enable"
                >
                    {{ __('Enable 2FA') }}
                </button>
            @endif
        </div>
    </x-settings.layout>

    <div wire:ignore.self class="modal fade" id="confirm-two-factor-setup" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Setup Two-Factor Authentication') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <p class="small text-muted">
                            {{ __('To finish enabling two-factor authentication, scan the following QR code using your phone\'s authenticator application.') }}
                        </p>

                        <div class="p-3 bg-white d-inline-block border rounded">
                            {!! $this->user->twoFactorQrCodeSvg() !!}
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">{{ __('Setup Key') }}</label>
                        <div class="input-group">
                            <input type="text" class="form-control bg-light" readonly value="{{ $manualSetupKey }}">
                            <button class="btn btn-outline-secondary" type="button" x-data="{ copied: false }" @click="navigator.clipboard.writeText('{{ $manualSetupKey }}'); copied = true; setTimeout(() => copied = false, 2000)">
                                <i x-show="!copied" class="bi bi-clipboard"></i>
                                <i x-show="copied" class="bi bi-check text-success"></i>
                            </button>
                        </div>
                    </div>

                    <div class="mt-4">
                        <label class="form-label">{{ __('Confirmation Code') }}</label>
                        <input type="text" wire:model="code" class="form-control" placeholder="000000">
                        @error('code') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="button" class="btn btn-primary" wire:click="confirm">{{ __('Confirm') }}</button>
                </div>
            </div>
        </div>
    </div>
</section>

@script
<script>
    $wire.on('show-two-factor-setup', () => {
        new bootstrap.Modal(document.getElementById('confirm-two-factor-setup')).show();
    });
    $wire.on('two-factor-enabled', () => {
        bootstrap.Modal.getInstance(document.getElementById('confirm-two-factor-setup')).hide();
    });
</script>
@endscript
