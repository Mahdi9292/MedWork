<section class="mt-5">
    <div class="mb-3">
        <h5 class="text-danger">{{ __('Delete account') }}</h5>
        <p class="text-muted small">{{ __('Delete your account and all of its resources') }}</p>
    </div>

    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmUserDeletion">
        {{ __('Delete account') }}
    </button>

    <div wire:ignore.self class="modal fade" id="confirmUserDeletion" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" wire:submit="deleteUser" class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title">{{ __('Are you sure you want to delete your account?') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted small">
                        {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm.') }}
                    </p>
                    <div class="mt-3">
                        <label class="form-label">{{ __('Password') }}</label>
                        <input wire:model="password" type="password" class="form-control">
                        @error('password') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="submit" class="btn btn-danger">{{ __('Delete account') }}</button>
                </div>
            </form>
        </div>
    </div>
</section>
