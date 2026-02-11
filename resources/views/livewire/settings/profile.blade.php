Moving the Settings section to Bootstrap 5 involves replacing the Flux layout system with Bootstrap cards and standard form components. I've also swapped the Segmented Radio for a standard Bootstrap button group for the appearance settings.

1. profile.blade.php (General Settings)
HTML
<section class="w-full">
    @include('sections.default.head')

    <x-settings.layout :heading="__('Profile')" :subheading="__('Update your name and email address')">
        <form wire:submit="updateProfileInformation" class="mt-4">
            <div class="mb-3">
                <label class="form-label">{{ __('Name') }}</label>
                <input wire:model="name" type="text" class="form-control @error('name') is-invalid @enderror" required autofocus autocomplete="name">
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('Email') }}</label>
                <input wire:model="email" type="email" class="form-control @error('email') is-invalid @enderror" required autocomplete="email">
                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror

                @if ($this->hasUnverifiedEmail)
                    <div class="mt-2 small">
                        <p class="text-muted mb-1">{{ __('Your email address is unverified.') }}</p>
                        <button type="button" class="btn btn-link p-0 small text-decoration-none" wire:click.prevent="resendVerificationNotification">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>

                        @if (session('status') === 'verification-link-sent')
                            <div class="text-success mt-1 fw-medium">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </div>
                        @endif
                    </div>
                @endif
            </div>

            <div class="d-flex align-items-center gap-3">
                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                <x-action-message on="profile-updated" class="text-success small" />
            </div>
        </form>

        @if ($this->showDeleteUser)
            <hr class="my-5">
            <livewire:settings.delete-user-form />
        @endif
    </x-settings.layout>
</section>
