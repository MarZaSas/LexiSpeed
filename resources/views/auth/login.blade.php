<x-guest-layout>
    <div class="auth-page">
        <div class="auth-card">
            <div class="text-center mb-4">
                <div class="auth-badge">LexiSpeed</div>
                <h1 class="auth-title">Iniciar sesión</h1>
                <p class="auth-subtitle">Accede a tu cuenta y continúa jugando.</p>
            </div>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label for="email" class="auth-label">Correo electrónico</label>
                    <input id="email" class="form-control auth-input" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger" />
                </div>

                <div class="mb-3">
                    <label for="password" class="auth-label">Contraseña</label>
                    <input id="password" class="form-control auth-input" type="password" name="password" required autocomplete="current-password">
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger" />
                </div>

                <div class="form-check mb-4">
                    <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                    <label class="form-check-label auth-small" for="remember_me">Recordarme</label>
                </div>

                <button type="submit" class="btn btn-info auth-button w-100 text-white">
                    Entrar
                </button>

                <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap gap-2">
                    @if (Route::has('password.request'))
                        <a class="auth-link" href="{{ route('password.request') }}">
                            ¿Olvidaste tu contraseña?
                        </a>
                    @endif

                    <a class="auth-link" href="{{ route('register') }}">
                        Crear cuenta
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
