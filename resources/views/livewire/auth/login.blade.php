<x-layouts::auth>
    <div class="d-flex flex-column gap-4">
        <x-auth-header :title="__('Log in to your account')" :description="__('Enter your email and password below to log in')" />

        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('login.store') }}" class="d-flex flex-column gap-3">
            @csrf

            <div class="form-group">
                <label for="email" class="form-label">{{ __('Email address') }}</label>
                <input id="email" type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus autocomplete="email" placeholder="email@example.com">
                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <label for="password" class="form-label mb-0">{{ __('Password') }}</label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="small text-decoration-none" wire:navigate>{{ __('Forgot your password?') }}</a>
                    @endif
                </div>
                <input id="password" type="password" name="password" class="form-control @error('password') is-invalid @enderror" required autocomplete="current-password" placeholder="{{ __('Password') }}">
                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label" for="remember">{{ __('Remember me') }}</label>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary" data-test="login-button">{{ __('Log in') }}</button>
            </div>
        </form>

        @if (Route::has('register'))
            <div class="text-center small text-muted">
                {{ __('Don\'t have an account?') }}
                <a href="{{ route('register') }}" class="text-decoration-none" wire:navigate>{{ __('Sign up') }}</a>
            </div>
        @endif
    </div>
</x-layouts::auth>
