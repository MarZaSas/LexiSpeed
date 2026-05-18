<section>
    <header>
        <h2 class="profile-section-title">Cambiar contraseña</h2>
        <p class="profile-section-text">
            Utiliza una contraseña segura para proteger mejor tu cuenta.
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-4">
        @csrf
        @method('put')

        <div class="mb-4">
            <label for="update_password_current_password" class="profile-label d-block">Contraseña actual</label>
            <input id="update_password_current_password" name="current_password" type="password" class="form-control profile-input" autocomplete="current-password">
            @error('current_password', 'updatePassword')
                <div class="text-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="update_password_password" class="profile-label d-block">Nueva contraseña</label>
            <input id="update_password_password" name="password" type="password" class="form-control profile-input" autocomplete="new-password">
            @error('password', 'updatePassword')
                <div class="text-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="update_password_password_confirmation" class="profile-label d-block">Confirmar nueva contraseña</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-control profile-input" autocomplete="new-password">
            @error('password_confirmation', 'updatePassword')
                <div class="text-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex align-items-center gap-3 flex-wrap">
            <button type="submit" class="btn btn-warning btn-game text-dark">Actualizar contraseña</button>

            @if (session('status') === 'password-updated')
                <span class="profile-save-text">Contraseña actualizada.</span>
            @endif
        </div>
    </form>
</section>