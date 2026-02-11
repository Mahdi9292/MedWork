<x-layouts::auth>
    <div class="d-flex flex-column gap-4 text-center">
        <x-auth-header :title="__('Verify email')" :description="__('Please verify your email address by clicking the link we just emailed to you.')" />

        @if (session('status') == 'verification-link-sent')
            <div class="alert alert-success small" role="alert">
                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
            </div>
        @endif

        <div class="d-flex flex-column gap-3">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="btn btn-primary w-100">
                    {{ __('Resend verification email') }}
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-link text-decoration-none small">
                    {{ __('Log out') }}
                </button>
            </form>
        </div>
    </div>
</x-layouts::auth>
