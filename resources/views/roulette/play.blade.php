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

    @if(session('roulette_result'))
        <div class="alert alert-info rounded-4 border-0 text-center mb-4">
            {{ session('roulette_result') }}
        </div>
    @endif
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

    <div class="roulette-wheel-wrapper text-center my-5">
        <div class="wheel-pointer"></div>

        <div class="roulette-wheel" id="rouletteWheel">
            <div class="wheel-label label-1">+50</div>
            <div class="wheel-label label-2">+100</div>
            <div class="wheel-label label-3">Comodín</div>
            <div class="wheel-label label-4">-50</div>
            <div class="wheel-label label-5">-1 Vida</div>
        </div>

        <form id="spinForm" action="{{ route('roulette.spin', $game) }}" method="POST" class="mt-4">
            @csrf

            <button type="submit" class="btn btn-danger btn-game px-5" id="spinButton">
                Girar ruleta
            </button>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
    .roulette-wheel-wrapper {
    position: relative;
    display: flex;
    flex-direction: column;
    align-items: center;
    }

    .wheel-pointer {
        width: 0;
        height: 0;
        border-left: 18px solid transparent;
        border-right: 18px solid transparent;
        border-top: 34px solid #facc15;
        margin-bottom: -10px;
        z-index: 5;
        filter: drop-shadow(0 4px 8px rgba(0,0,0,0.4));
    }

    .roulette-wheel {
        width: 280px;
        height: 280px;
        border-radius: 50%;
        position: relative;
        border: 8px solid rgba(255,255,255,0.18);
        box-shadow: 0 0 35px rgba(239,68,68,0.28);
        overflow: hidden;
        transition: transform 3s cubic-bezier(.15,.85,.25,1);
        background:
            conic-gradient(
                #22c55e 0deg 72deg,
                #38bdf8 72deg 144deg,
                #facc15 144deg 216deg,
                #ef4444 216deg 288deg,
                #a855f7 288deg 360deg
            );
    }

    .roulette-wheel::after {
        content: "";
        position: absolute;
        inset: 82px;
        border-radius: 50%;
        background: #0f172a;
        border: 5px solid rgba(255,255,255,0.15);
        box-shadow: inset 0 0 18px rgba(0,0,0,0.5);
    }

    .wheel-label {
        position: absolute;
        z-index: 3;
        color: white;
        font-weight: 900;
        font-size: 0.95rem;
        text-shadow: 0 2px 5px rgba(0,0,0,0.65);
    }

    .label-1 {
        top: 50px;
        left: 175px;
    }

    .label-2 {
        top: 120px;
        left: 195px;
    }

    .label-3 {
        bottom: 50px;
        left: 105px;
    }

    .label-4 {
        top: 120px;
        left: 35px;
    }

    .label-5 {
        top: 50px;
        left: 65px;
    }

    .roulette-wheel.spinning {
        transform: rotate(1440deg);
    }
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
@push('scripts')
<script>
    const spinForm = document.getElementById('spinForm');
    const spinButton = document.getElementById('spinButton');
    const rouletteWheel = document.getElementById('rouletteWheel');

    if (spinForm && spinButton && rouletteWheel) {
        spinForm.addEventListener('submit', function (event) {
            event.preventDefault();

            spinButton.disabled = true;
            spinButton.textContent = 'Girando...';

            const randomExtraRotation = Math.floor(Math.random() * 360);
            const totalRotation = 1440 + randomExtraRotation;

            rouletteWheel.style.transform = `rotate(${totalRotation}deg)`;

            setTimeout(() => {
                spinForm.submit();
            }, 3000);
        });
    }
</script>
@endpush
