<x-layouts::auth>
    <div class="d-flex flex-column gap-4">
        <x-auth-header :title="__('Reset password')" :description="__('Please enter your new password below')" />

        <form method="POST" action="{{ route('password.store') }}" class="d-flex flex-column gap-3">
            @csrf
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="form-group">
                <label for="email" class="form-label">{{ __('Email address') }}</label>
                <input id="email" type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $request->email) }}" required autocomplete="email">
                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label for="password" class="form-label">{{ __('Password') }}</label>
                <input id="password" type="password" name="password" class="form-control @error('password') is-invalid @enderror" required autocomplete="new-password">
                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
                <input id="password_confirmation" type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" required autocomplete="new-password">
                @error('password_confirmation') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="d-grid mt-2">
                <button type="submit" class="btn btn-primary">{{ __('Reset password') }}</button>
            </div>
        </form>
    </div>
</x-layouts::auth>
