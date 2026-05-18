@extends('layouts.admin')

@section('content')
<div class="text-center mb-5">
    <h1 class="title-gradient mb-3">Selecciona la dificultad</h1>
    <p class="subtitle-text">Elige un nivel para comenzar una nueva partida en LexiSpeed.</p>
</div>

<div class="row g-4 justify-content-center">
    <div class="col-md-4">
        <div class="panel-card p-4 h-100 text-center">
            <h2 class="mb-3 text-success fw-bold">Fácil</h2>
            <p class="subtitle-text">10 palabras. Ideal para empezar.</p>
            <ul class="list-unstyled mb-4" style="color:#cbd5e1;">
                <li>10 palabras</li>
                <li>Palabras simples</li>
                <li>Menor presión</li>
            </ul>

            <form action="{{ route('game.start') }}" method="POST">
                @csrf
                <input type="hidden" name="difficulty" value="easy">
                <button class="btn btn-success btn-game w-100">Jugar fácil</button>
            </form>
        </div>
    </div>

    <div class="col-md-4">
        <div class="panel-card p-4 h-100 text-center">
            <h2 class="mb-3 text-warning fw-bold">Intermedio</h2>
            <p class="subtitle-text">15 palabras. Un reto equilibrado.</p>
            <ul class="list-unstyled mb-4" style="color:#cbd5e1;">
                <li>15 palabras</li>
                <li>Mayor dificultad</li>
                <li>Más ritmo</li>
            </ul>

            <form action="{{ route('game.start') }}" method="POST">
                @csrf
                <input type="hidden" name="difficulty" value="medium">
                <button class="btn btn-warning btn-game w-100">Jugar intermedio</button>
            </form>
        </div>
    </div>

    <div class="col-md-4">
        <div class="panel-card p-4 h-100 text-center">
            <h2 class="mb-3 text-danger fw-bold">Difícil</h2>
            <p class="subtitle-text">20 palabras. Solo para los más rápidos.</p>
            <ul class="list-unstyled mb-4" style="color:#cbd5e1;">
                <li>20 palabras</li>
                <li>Palabras complejas</li>
                <li>Máxima exigencia</li>
            </ul>

            <form action="{{ route('game.start') }}" method="POST">
                @csrf
                <input type="hidden" name="difficulty" value="hard">
                <button class="btn btn-danger btn-game w-100">Jugar difícil</button>
            </form>
        </div>
    </div>
</div>
@endsection