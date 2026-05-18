@extends('layouts.admin')

@section('content')
<div class="panel-card overflow-hidden" style="max-width: 760px; margin: 0 auto;">
    <div class="p-4 p-md-5" style="background: linear-gradient(90deg, rgba(56,189,248,0.18), rgba(234,179,8,0.18), rgba(168,85,247,0.18)); border-bottom: 1px solid rgba(255,255,255,0.08);">
        <h1 class="title-gradient mb-2">Editar palabra</h1>
        <p class="mb-0 subtitle-text">Modifica la palabra, su dificultad o su estado dentro del sistema.</p>
    </div>

    <div class="p-4 p-md-5">
        @if($errors->any())
            <div class="alert alert-danger rounded-4">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('words.update', $word) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="form-label fw-bold">Palabra</label>
                <input
                    type="text"
                    name="text"
                    class="form-control"
                    value="{{ old('text', $word->text) }}"
                    placeholder="Ejemplo: desarrollador"
                    required
                >
                <div class="mt-2" style="color:#94a3b8;">
                    Modifica la palabra que se utilizará dentro del juego.
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold">Dificultad</label>
                <select name="difficulty" id="difficulty" class="form-select difficulty-select" required>
                    <option value="">Selecciona una dificultad</option>
                    <option value="easy" {{ old('difficulty', $word->difficulty) == 'easy' ? 'selected' : '' }}>Fácil</option>
                    <option value="medium" {{ old('difficulty', $word->difficulty) == 'medium' ? 'selected' : '' }}>Intermedio</option>
                    <option value="hard" {{ old('difficulty', $word->difficulty) == 'hard' ? 'selected' : '' }}>Difícil</option>
                </select>
            </div>

            <div class="form-check mb-4">
                <input
                    type="checkbox"
                    name="is_active"
                    class="form-check-input"
                    id="is_active"
                    {{ old('is_active', $word->is_active) ? 'checked' : '' }}
                >
                <label class="form-check-label" for="is_active">Palabra activa</label>
            </div>

            <div class="d-flex flex-wrap gap-2">
                <button type="submit" class="btn btn-warning btn-game">Guardar cambios</button>
                <a href="{{ route('words.index') }}" class="btn btn-outline-light btn-game">Volver al listado</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
    .form-control,
    .form-select {
        background: rgba(255,255,255,0.08);
        border: 1px solid rgba(255,255,255,0.16);
        color: #fff;
        border-radius: 14px;
        padding: 12px 14px;
        min-height: 54px;
        transition: 0.2s ease;
    }

    .form-control::placeholder {
        color: #94a3b8;
    }

    .form-control:focus,
    .form-select:focus {
        background: rgba(255,255,255,0.12);
        color: #fff;
        border-color: #38bdf8;
        box-shadow: 0 0 0 0.25rem rgba(56,189,248,0.2);
    }

    .form-select {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        cursor: pointer;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='18' height='18' fill='none' viewBox='0 0 24 24'%3E%3Cpath stroke='%23cbd5e1' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m6 9 6 6 6-6'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 14px center;
        background-size: 18px;
        padding-right: 44px;
    }

    .form-select:hover {
        border-color: rgba(56,189,248,0.45);
        background-color: rgba(255,255,255,0.10);
    }

    .form-select option {
        color: #000;
    }

    .difficulty-select.easy-selected {
        border-color: rgba(34, 197, 94, 0.8);
        box-shadow: 0 0 0 0.2rem rgba(34, 197, 94, 0.15);
    }

    .difficulty-select.medium-selected {
        border-color: rgba(234, 179, 8, 0.8);
        box-shadow: 0 0 0 0.2rem rgba(234, 179, 8, 0.15);
    }

    .difficulty-select.hard-selected {
        border-color: rgba(239, 68, 68, 0.8);
        box-shadow: 0 0 0 0.2rem rgba(239, 68, 68, 0.15);
    }
</style>
@endpush

@push('scripts')
<script>
    const difficultySelect = document.getElementById('difficulty');

    function updateDifficultyStyle() {
        difficultySelect.classList.remove('easy-selected', 'medium-selected', 'hard-selected');

        if (difficultySelect.value === 'easy') {
            difficultySelect.classList.add('easy-selected');
        } else if (difficultySelect.value === 'medium') {
            difficultySelect.classList.add('medium-selected');
        } else if (difficultySelect.value === 'hard') {
            difficultySelect.classList.add('hard-selected');
        }
    }

    difficultySelect.addEventListener('change', updateDifficultyStyle);
    updateDifficultyStyle();
</script>
@endpush