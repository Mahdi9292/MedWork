<x-layouts::auth>
    <div x-data="{ recovery: false }" class="d-flex flex-column gap-4">
        <div x-show="! recovery">
            <x-auth-header :title="__('Two-factor confirmation')" :description="__('Please confirm access to your account by entering the authentication code provided by your authenticator application.')" />
        </div>

        <div x-show="recovery" style="display: none;">
            <x-auth-header :title="__('Two-factor confirmation')" :description="__('Please confirm access to your account by entering one of your emergency recovery codes.')" />
        </div>

        <form method="POST" action="{{ route('two-factor.login') }}" class="d-flex flex-column gap-3">
            @csrf

            <div class="form-group" x-show="! recovery">
                <label for="code" class="form-label">{{ __('Code') }}</label>
                <input id="code" type="text" name="code" class="form-control" inputmode="numeric" autofocus x-ref="code" autocomplete="one-time-code">
            </div>

            <div class="form-group" x-show="recovery" style="display: none;">
                <label for="recovery_code" class="form-label">{{ __('Recovery Code') }}</label>
                <input id="recovery_code" type="text" name="recovery_code" class="form-control" x-ref="recovery_code" autocomplete="one-time-code">
            </div>

            <div class="d-flex flex-column gap-2">
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">{{ __('Log in') }}</button>
                </div>

                <button type="button" class="btn btn-link text-decoration-none small"
                        x-show="! recovery"
                        x-on:click="recovery = true; $nextTick(() => { $refs.recovery_code.focus() })">
                    {{ __('Use a recovery code') }}
                </button>

                <button type="button" class="btn btn-link text-decoration-none small"
                        x-show="recovery"
                        style="display: none;"
                        x-on:click="recovery = false; $nextTick(() => { $refs.code.focus() })">
                    {{ __('Use an authentication code') }}
                </button>
            </div>
        </form>
    </div>
</x-layouts::auth>
