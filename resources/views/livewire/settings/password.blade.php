<section class="w-full">
    @include('sections.default.head')

    <x-settings.layout :heading="__('Update password')" :subheading="__('Ensure your account is using a long, random password to stay secure')">
        <form wire:submit="updatePassword" class="mt-4">
            <div class="mb-3">
                <label class="form-label">{{ __('Current password') }}</label>
                <input wire:model="current_password" type="password" class="form-control" required autocomplete="current-password">
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('New password') }}</label>
                <input wire:model="password" type="password" class="form-control" required autocomplete="new-password">
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('Confirm Password') }}</label>
                <input wire:model="password_confirmation" type="password" class="form-control" required autocomplete="new-password">
            </div>

            <div class="d-flex align-items-center gap-3">
                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                <x-action-message on="password-updated" class="text-success small" />
            </div>
        </form>
    </x-settings.layout>
</section>
