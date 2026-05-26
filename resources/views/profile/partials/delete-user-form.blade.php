<section>
    <header>
        <h2 class="profile-section-title text-danger">Eliminar cuenta</h2>
        <p class="profile-section-text">
            Una vez eliminada tu cuenta, todos tus datos se borrarán permanentemente. Esta acción no se puede deshacer.
        </p>
    </header>

    <form method="POST" action="{{ route('profile.destroy') }}"
          onsubmit="return confirm('¿Seguro que quieres eliminar tu cuenta? Esta acción no se puede deshacer.');">
        @csrf
        @method('delete')

        <div class="mb-4">
            <label for="password" class="profile-label d-block">Introduce tu contraseña para confirmar</label>
            <input
                id="password"
                name="password"
                type="password"
                class="form-control profile-input"
                placeholder="Contraseña actual"
                required
            >

            @error('password', 'userDeletion')
                <div class="text-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-danger btn-game">
            Eliminar cuenta
        </button>
    </form>
</section>
