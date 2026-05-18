@extends('layouts.admin')

@section('content')
@if(auth()->user()->isAdmin())
    <div class="mb-5 text-center">
        <h1 class="title-gradient mb-3">Panel de administración</h1>
        <p class="subtitle-text">Gestiona palabras, controla el sistema y accede a las funciones principales de LexiSpeed.</p>
    </div>

    <div class="row g-4">
        <div class="col-md-6 col-xl-3">
            <div class="panel-card p-4 h-100 text-center">
                <div class="mb-3" style="font-size: 2.2rem;">🎮</div>
                <h3 class="fw-bold mb-2 text-info">Jugar</h3>
                <p class="subtitle-text mb-4">Empieza una partida nueva y elige tu nivel de dificultad.</p>
                <a href="{{ route('game.difficulty') }}" class="btn btn-info btn-game w-100 text-white">Ir a jugar</a>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="panel-card p-4 h-100 text-center">
                <div class="mb-3" style="font-size: 2.2rem;">📝</div>
                <h3 class="fw-bold mb-2 text-success">Palabras</h3>
                <p class="subtitle-text mb-4">Gestiona las palabras disponibles del juego desde el panel admin.</p>
                <a href="{{ route('words.index') }}" class="btn btn-success btn-game w-100">Ver palabras</a>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="panel-card p-4 h-100 text-center">
                <div class="mb-3" style="font-size: 2.2rem;">➕</div>
                <h3 class="fw-bold mb-2 text-warning">Nueva palabra</h3>
                <p class="subtitle-text mb-4">Añade nuevas palabras y clasifícalas por dificultad.</p>
                <a href="{{ route('words.create') }}" class="btn btn-warning btn-game w-100 text-dark">Crear palabra</a>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="panel-card p-4 h-100 text-center">
                <div class="mb-3" style="font-size: 2.2rem;">🏠</div>
                <h3 class="fw-bold mb-2 text-light">Inicio</h3>
                <p class="subtitle-text mb-4">Vuelve a la pantalla principal pública del proyecto.</p>
                <a href="{{ url('/') }}" class="btn btn-outline-light btn-game w-100">Ir al inicio</a>
            </div>
        </div>
    </div>
@else
    <div class="text-center mb-5">
        <h1 class="title-gradient mb-3">Bienvenido a LexiSpeed</h1>
        <p class="subtitle-text">Selecciona una dificultad y empieza a jugar.</p>
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
@endif
@endsection