@extends('layouts.admin')

@section('content')
@php
    $roulette = $game->rouletteGame;
@endphp

<div class="panel-card p-4 p-md-5">
    <div class="text-center mb-5">
        <div class="mb-2" style="color:#94a3b8;">Modo Ruleta</div>
        <h1 class="title-gradient mb-3">La Ruleta de LexiSpeed</h1>
        <p class="subtitle-text mb-0">
            Gira la ruleta, compra letras y resuelve la frase oculta.
        </p>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="game-stat-card text-center">
                <div class="stat-label">Puntos</div>
                <div class="stat-value text-success">{{ $roulette->current_points }}</div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="game-stat-card text-center">
                <div class="stat-label">Puntos de tirada</div>
                <div class="stat-value text-warning">{{ $roulette->turn_points }}</div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="game-stat-card text-center">
                <div class="stat-label">Vidas</div>
                <div class="stat-value text-danger">{{ $roulette->lives }}</div>
            </div>
        </div>
    </div>

    <div class="roulette-panel text-center mb-4">
        @foreach(explode(' ', $roulette->revealed_text) as $word)
            <span class="roulette-word">
                @foreach(mb_str_split($word) as $letter)
                    <span class="roulette-letter">{{ $letter }}</span>
                @endforeach
            </span>
        @endforeach
    </div>

    <div class="text-center">
        <p class="subtitle-text">Siguiente paso: añadir giro de ruleta, compra de letras y resolver frase.</p>
    </div>
</div>
@endsection

@push('styles')
<style>
    .game-stat-card {
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 18px;
        padding: 18px;
    }

    .stat-label {
        color: #94a3b8;
        font-size: 0.9rem;
    }

    .stat-value {
        font-size: 1.5rem;
        font-weight: 800;
    }

    .roulette-panel {
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 24px;
        padding: 32px;
    }

    .roulette-word {
        display: inline-flex;
        gap: 6px;
        margin: 8px 14px;
    }

    .roulette-letter {
        width: 34px;
        height: 42px;
        border-radius: 10px;
        background: rgba(255,255,255,0.10);
        border: 1px solid rgba(255,255,255,0.16);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 900;
        font-size: 1.3rem;
        color: #f8fafc;
    }
</style>
@endpush
