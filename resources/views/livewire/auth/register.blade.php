<x-layouts::auth>
    <div class="d-flex flex-column gap-4">
        <x-auth-header :title="__('Create an account')" :description="__('Enter your details below to create your account')" />

        <form method="POST" action="{{ route('register.store') }}" class="d-flex flex-column gap-3">
            @csrf

            <div class="form-group">
                <label for="name" class="form-label">{{ __('Name') }}</label>
                <input id="name" type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="{{ __('Full name') }}">
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label for="email" class="form-label">{{ __('Email address') }}</label>
                <input id="email" type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="email" placeholder="email@example.com">
                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label for="password" class="form-label">{{ __('Password') }}</label>
                <input id="password" type="password" name="password" class="form-control @error('password') is-invalid @enderror" required autocomplete="new-password" placeholder="{{ __('Password') }}">
                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
                <input id="password_confirmation" type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" required autocomplete="new-password" placeholder="{{ __('Confirm password') }}">
                @error('password_confirmation') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="d-grid mt-2">
                <button type="submit" class="btn btn-primary">{{ __('Create account') }}</button>
            </div>
        </form>

        <div class="text-center small text-muted">
            {{ __('Already have an account?') }}
            <a href="{{ route('login') }}" class="text-decoration-none" wire:navigate>{{ __('Log in') }}</a>
        </div>
    </div>
</x-layouts::auth>
