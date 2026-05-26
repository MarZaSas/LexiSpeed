<section>
    <header>
        <h2 class="profile-section-title">Información del perfil</h2>
        <p class="profile-section-text">
            Actualiza el nombre y el correo electrónico asociados a tu cuenta.
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-4">
        @csrf
        @method('patch')

        <div class="mb-4">
            <label for="name" class="profile-label d-block">Nombre</label>
            <input id="name" name="name" type="text" class="form-control profile-input" value="{{ old('name', $user->name) }}" required  autocomplete="name">
            @error('name')
                <div class="text-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="email" class="profile-label d-block">Correo electrónico</label>
            <input id="email" name="email" type="email" class="form-control profile-input" value="{{ old('email', $user->email) }}" required autocomplete="username">
            @error('email')
                <div class="text-danger mt-2">{{ $message }}</div>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-3">
                    <p class="profile-helper mb-2">
                        Tu dirección de correo todavía no está verificada.
                    </p>

                    <button form="send-verification" class="btn btn-outline-info btn-game">
                        Reenviar email de verificación
                    </button>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-3 profile-save-text">
                            Se ha enviado un nuevo enlace de verificación a tu correo.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="d-flex align-items-center gap-3 flex-wrap">
            <button type="submit" class="btn btn-info btn-game text-white">Guardar cambios</button>

            @if (session('status') === 'profile-updated')
                <span class="profile-save-text">Guardado correctamente.</span>
            @endif
        </div>
    </form>
</section>
