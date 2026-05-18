@extends('layouts.admin')

@section('content')
<div class="text-center mb-5">
    <h1 class="title-gradient mb-3">Elige modo de juego</h1>
    <p class="subtitle-text">Selecciona cómo quieres jugar en LexiSpeed.</p>
</div>

<div class="row g-4 justify-content-center">
    <div class="col-md-5">
        <div class="panel-card p-4 h-100 text-center">
            <h2 class="mb-3 text-info fw-bold">Modo Clásico</h2>
            <p class="subtitle-text">
                Escribe palabras a contrarreloj y consigue la máxima puntuación.
            </p>

            <ul class="list-unstyled mb-4" style="color:#cbd5e1;">
                <li>Palabras individuales</li>
                <li>Dificultad fácil, media y difícil</li>
                <li>Puntuación según rapidez</li>
            </ul>

            <a href="{{ route('game.difficulty') }}" class="btn btn-info btn-game w-100 text-white">
                Jugar clásico
            </a>
        </div>
    </div>

    <div class="col-md-5">
        <div class="panel-card p-4 h-100 text-center">
            <h2 class="mb-3 text-warning fw-bold">Modo Fantasma</h2>
            <p class="subtitle-text">
                Memoriza una frase durante 3 segundos y escríbela de memoria.
            </p>

            <ul class="list-unstyled mb-4" style="color:#cbd5e1;">
                <li>3 frases por partida</li>
                <li>Sin dificultad</li>
                <li>Hasta 100 puntos por frase</li>
            </ul>

            <form action="{{ route('ghost.start') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-warning btn-game w-100 text-dark">
                    Jugar fantasma
                </button>
            </form>
        </div>

        <div class="col-md-5">
            <div class="panel-card p-4 h-100 text-center">
                <h2 class="mb-3 text-danger fw-bold">Modo Ruleta</h2>
                <p class="subtitle-text">
                    Gira la ruleta, compra letras y resuelve la frase antes de perder tus vidas.
                </p>

                <ul class="list-unstyled mb-4" style="color:#cbd5e1;">
                    <li>1 frase oculta</li>
                    <li>3 vidas</li>
                    <li>Premios y castigos aleatorios</li>
                </ul>

                <form action="{{ route('roulette.start') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-game w-100">
                        Jugar ruleta
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
