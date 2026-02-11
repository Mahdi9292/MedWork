<x-layouts::auth>
    <div class="d-flex flex-column gap-4">
        <x-auth-header :title="__('Confirm password')" :description="__('This is a secure area of the application. Please confirm your password before continuing.')" />

        <form method="POST" action="{{ route('password.confirm') }}" class="d-flex flex-column gap-3">
            @csrf

            <div class="form-group">
                <label for="password" class="form-label">{{ __('Password') }}</label>
                <input id="password" type="password" name="password" class="form-control @error('password') is-invalid @enderror" required autocomplete="current-password">
                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary">
                    {{ __('Confirm') }}
                </button>
            </div>
        </form>
    </div>
</x-layouts::auth>
