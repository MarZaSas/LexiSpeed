@extends('layouts.admin')

@section('content')
@if(auth()->user()->isAdmin())
    <div class="text-center mb-5">
        <h1 class="title-gradient mb-3">Panel de administración</h1>
        <p class="subtitle-text">Gestiona los modos de juego, las palabras y las frases de LexiSpeed.</p>
    </div>

    <div class="row g-4">
        <div class="col-md-6 col-xl-4">
            <div class="panel-card p-4 h-100 text-center">
                <h3 class="fw-bold text-info mb-3">Jugar</h3>
                <p class="subtitle-text">Accede a los modos Clásico, Fantasma y Ruleta.</p>
                <a href="{{ route('game.modes') }}" class="btn btn-info btn-game text-white w-100">Ir a jugar</a>
            </div>
        </div>

        <div class="col-md-6 col-xl-4">
            <div class="panel-card p-4 h-100 text-center">
                <h3 class="fw-bold text-success mb-3">Palabras</h3>
                <p class="subtitle-text">Gestiona las palabras del modo clásico.</p>
                <a href="{{ route('words.index') }}" class="btn btn-success btn-game w-100">Gestionar palabras</a>
            </div>
        </div>

        <div class="col-md-6 col-xl-4">
            <div class="panel-card p-4 h-100 text-center">
                <h3 class="fw-bold text-warning mb-3">Nueva palabra</h3>
                <p class="subtitle-text">Añade nuevas palabras por dificultad.</p>
                <a href="{{ route('words.create') }}" class="btn btn-warning btn-game text-dark w-100">Crear palabra</a>
            </div>
        </div>

        <div class="col-md-6 col-xl-4">
            <div class="panel-card p-4 h-100 text-center">
                <h3 class="fw-bold text-primary mb-3">Frases Fantasma</h3>
                <p class="subtitle-text">Gestiona las frases del modo fantasma.</p>
                <a href="{{ route('phrases.index') }}" class="btn btn-primary btn-game w-100">Gestionar frases</a>
            </div>
        </div>

        <div class="col-md-6 col-xl-4">
            <div class="panel-card p-4 h-100 text-center">
                <h3 class="fw-bold text-danger mb-3">Frases Ruleta</h3>
                <p class="subtitle-text">Gestiona las frases del modo ruleta.</p>
                <a href="{{ route('roulette-phrases.index') }}" class="btn btn-danger btn-game w-100">Gestionar ruleta</a>
            </div>
        </div>

        <div class="col-md-6 col-xl-4">
            <div class="panel-card p-4 h-100 text-center">
                <h3 class="fw-bold text-light mb-3">Perfil</h3>
                <p class="subtitle-text">Gestiona los datos de tu cuenta.</p>
                <a href="{{ route('profile.edit') }}" class="btn btn-outline-light btn-game w-100">Ver perfil</a>
            </div>
        </div>
    </div>
@else
    <div class="text-center mb-5">
        <h1 class="title-gradient mb-3">Bienvenido a LexiSpeed</h1>
        <p class="subtitle-text">Selecciona un modo de juego para empezar.</p>
    </div>

    <div class="row g-4 justify-content-center">
        <div class="col-md-4">
            <div class="panel-card p-4 h-100 text-center">
                <h3 class="fw-bold text-info mb-3">Modo Clásico</h3>
                <p class="subtitle-text">Escribe palabras contra el tiempo.</p>
                <a href="{{ route('game.difficulty') }}" class="btn btn-info btn-game text-white w-100">Jugar clásico</a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="panel-card p-4 h-100 text-center">
                <h3 class="fw-bold text-warning mb-3">Modo Fantasma</h3>
                <p class="subtitle-text">Memoriza frases durante 3 segundos.</p>
                <a href="{{ route('game.modes') }}" class="btn btn-warning btn-game text-dark w-100">Ver modos</a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="panel-card p-4 h-100 text-center">
                <h3 class="fw-bold text-danger mb-3">Modo Ruleta</h3>
                <p class="subtitle-text">Gira la ruleta, compra letras y resuelve frases.</p>
                <a href="{{ route('game.modes') }}" class="btn btn-danger btn-game w-100">Ver modos</a>
            </div>
        </div>
    </div>
@endif
@endsection
