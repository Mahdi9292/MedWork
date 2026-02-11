<x-layouts::auth>
    <div class="d-flex flex-column gap-4">
        <x-auth-header :title="__('Forgot password')" :description="__('Email us a password reset link')" />

        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}" class="d-flex flex-column gap-3">
            @csrf

            <div class="form-group">
                <label for="email" class="form-label">{{ __('Email address') }}</label>
                <input id="email" type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus placeholder="email@example.com">
                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary">
                    {{ __('Email password reset link') }}
                </button>
            </div>
        </form>

        <div class="text-center small">
            <a href="{{ route('login') }}" class="text-decoration-none" wire:navigate>{{ __('Back to login') }}</a>
        </div>
    </div>
</x-layouts::auth>
