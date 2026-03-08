<!DOCTYPE html>
<html lang="en">

<head>
    @include('sections.default._head')
</head>
<body>
<main>
    <section class="d-flex align-items-center my-5 mt-lg-6 mb-lg-5">
        <div class="container">
            <div class="row justify-content-center form-bg-image" data-background-lg="">
                <div class="col-12 d-flex align-items-center justify-content-center">
                    <div class="bg-white shadow-lg border-0 rounded-4 p-4 p-md-5 w-100" style="max-width: 480px;">
                        <div class="text-center mb-4">
                            <h1 class="fw-bold h3 mb-1 text-dark">MedWork - APP</h1>
                            <p class="text-muted small">Willkommen zurück! Bitte geben Sie Ihre Daten ein.</p>
                        </div>

                        <x-auth-session-status class="mb-3 text-center" :status="session('status')" />

                        <form method="POST" action="{{ route('login.store') }}" class="needs-validation">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold small">{{ __('E-Mail-Adresse') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fas fa-envelope text-muted"></i>
                                    </span>
                                    <input id="email" type="email" name="email"
                                           class="form-control bg-light border-start-0 ps-0 @error('email') is-invalid @enderror"
                                           value="{{ old('email') }}" required autofocus
                                           placeholder="name@company.com">
                                    @error('email') <div class="invalid-feedback">{{ __('E-Mail oder Passwort ungültig') }}</div> @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <label for="password" class="form-label fw-semibold small mb-0">{{ __('Passwort') }}</label>
                                    @if (Route::has('password.request'))
                                        <a href="{{ route('password.request') }}" class="text-primary text-decoration-none" style="font-size: 0.75rem;" wire:navigate>
                                            {{ __('Passwort vergessen?') }}
                                        </a>
                                    @endif
                                </div>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fas fa-lock text-muted"></i>
                                    </span>
                                    <input id="password" type="password" name="password"
                                           class="form-control bg-light border-start-0 border-end-0 ps-0"
                                           required >
                                    <button class="btn btn-light border border-start-0" type="button" id="togglePassword">
                                        <i class="fas fa-eye text-muted" id="eyeIcon"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="form-check mb-4">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label small text-secondary" for="remember">
                                    {{ __('Angemeldet bleiben') }}
                                </label>
                            </div>

                            <div class="d-grid mb-4">
                                <button type="submit" class="btn btn-outline-primary btn-lg py-2 fw-bold" style="letter-spacing: 0.5px;">
                                    {{ __('Anmelden') }}
                                </button>
                            </div>
                        </form>

                        @if (Route::has('register'))
                            <div class="text-center">
                                <span class="small text-muted">{{ __('Haben Sie noch kein Konto?') }}</span>
                                <a href="{{ route('register') }}" class="small fw-bold text-primary text-decoration-none ms-1" wire:navigate>
                                    {{ __('Konto erstellen') }}
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

@include('sections.default._scripts')

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleBtn = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const icon = document.getElementById('eyeIcon');

        if (toggleBtn) {
            toggleBtn.addEventListener('click', function (e) {
                // Prevent any default behavior
                e.preventDefault();

                // Toggle the type attribute
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);

                // Toggle the icon classes
                if (type === 'text') {
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        }
    });
</script>



</body>
</html>
