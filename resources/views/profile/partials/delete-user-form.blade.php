<section class="space-y-6">
    <header>
        <h2 class="profile-section-title text-danger">Eliminar cuenta</h2>
        <p class="profile-section-text">
            Una vez eliminada tu cuenta, todos tus datos se borrarán permanentemente. Esta acción no se puede deshacer.
        </p>
    </header>

    <div class="profile-danger-box">
        <button
            class="btn btn-danger btn-game"
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        >
            Eliminar cuenta
        </button>
    </div>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-4">
            @csrf
            @method('delete')

            <h2 class="profile-section-title text-dark">¿Seguro que quieres eliminar tu cuenta?</h2>

            <p class="mt-3 text-muted">
                Introduce tu contraseña para confirmar que deseas eliminar tu cuenta de forma permanente.
            </p>

            <div class="mt-4">
                <label for="password" class="form-label fw-bold text-dark">Contraseña</label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    class="form-control"
                    placeholder="Tu contraseña actual"
                >
                @error('password', 'userDeletion')
                    <div class="text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="mt-4 d-flex justify-content-end gap-2">
                <button type="button" class="btn btn-secondary" x-on:click="$dispatch('close')">
                    Cancelar
                </button>

                <button type="submit" class="btn btn-danger">
                    Eliminar cuenta
                </button>
            </div>
        </form>
    </x-modal>
</section>