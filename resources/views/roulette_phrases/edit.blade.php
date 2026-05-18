@extends('layouts.admin')

@section('content')
<div class="panel-card overflow-hidden" style="max-width: 760px; margin: 0 auto;">
    <div class="p-4 p-md-5" style="background: linear-gradient(90deg, rgba(234,179,8,0.18), rgba(168,85,247,0.18)); border-bottom: 1px solid rgba(255,255,255,0.08);">
        <h1 class="title-gradient mb-2">Editar frase de ruleta</h1>
        <p class="mb-0 subtitle-text">Modifica la frase utilizada en el modo ruleta.</p>
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

        <form action="{{ route('roulette-phrases.update', $roulettePhrase) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="form-label fw-bold">Frase</label>
                <textarea
                    name="text"
                    class="form-control roulette-input"
                    rows="4"
                    required
                >{{ old('text', $roulettePhrase->text) }}</textarea>
            </div>

            <div class="form-check mb-4">
                <input
                    type="checkbox"
                    name="is_active"
                    class="form-check-input"
                    id="is_active"
                    {{ old('is_active', $roulettePhrase->is_active) ? 'checked' : '' }}
                >
                <label class="form-check-label" for="is_active">Frase activa</label>
            </div>

            <div class="d-flex flex-wrap gap-2">
                <button type="submit" class="btn btn-warning btn-game text-dark">Guardar cambios</button>
                <a href="{{ route('roulette-phrases.index') }}" class="btn btn-outline-light btn-game">Volver</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
    .roulette-input {
        background: rgba(255,255,255,0.08);
        border: 1px solid rgba(255,255,255,0.16);
        color: #fff;
        border-radius: 14px;
        padding: 14px;
        resize: vertical;
    }

    .roulette-input:focus {
        background: rgba(255,255,255,0.12);
        color: #fff;
        border-color: #facc15;
        box-shadow: 0 0 0 0.25rem rgba(250,204,21,0.18);
    }
</style>
@endpush
