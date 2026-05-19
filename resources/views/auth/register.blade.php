<x-guest-layout>
    <div class="auth-page">
        <div class="auth-card">
            <div class="text-center mb-4">
                <div class="auth-badge">LexiSpeed</div>
                <h1 class="auth-title">Crear cuenta</h1>
                <p class="auth-subtitle">Regístrate para guardar tus partidas y puntuaciones.</p>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-3">
                    <label for="name" class="auth-label">Nombre</label>
                    <input id="name" class="form-control auth-input" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name">
                    <x-input-error :messages="$errors->get('name')" class="mt-2 text-danger" />
                </div>

                <div class="mb-3">
                    <label for="email" class="auth-label">Correo electrónico</label>
                    <input id="email" class="form-control auth-input" type="email" name="email" value="{{ old('email') }}" required autocomplete="username">
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger" />
                </div>

                <div class="mb-3">
                    <label for="password" class="auth-label">Contraseña</label>
                    <input id="password" class="form-control auth-input" type="password" name="password" required autocomplete="new-password">
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger" />
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="auth-label">Confirmar contraseña</label>
                    <input id="password_confirmation" class="form-control auth-input" type="password" name="password_confirmation" required autocomplete="new-password">
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-danger" />
                </div>

                <button type="submit" class="btn btn-success auth-button w-100">
                    Registrarme
                </button>

                <div class="text-center mt-4">
                    <a class="auth-link" href="{{ route('login') }}">
                        Ya tengo cuenta
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
