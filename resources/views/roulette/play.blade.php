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
            <div class="wheel-label label-2">+50</div>
            <div class="wheel-label label-3">+50</div>
            <div class="wheel-label label-4">+100</div>
            <div class="wheel-label label-5">+100</div>
            <div class="wheel-label label-6">-50</div>
            <div class="wheel-label label-7">-50</div>
            <div class="wheel-label label-8">Comodín</div>
            <div class="wheel-label label-9">-1 Vida</div>
        </div>

        <form id="spinForm" action="{{ route('roulette.spin', $game) }}" method="POST" class="mt-4">
            @csrf
            <input type="hidden" name="result" id="wheelResult">

            <button type="submit" class="btn btn-danger btn-game px-5" id="spinButton">
                Girar ruleta
            </button>
        </form>
        @if($roulette->status === 'playing')
    <div class="row g-4 mt-4">
        <div class="col-md-6">
            <div class="p-4 rounded-4" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.08);">
                <h3 class="fw-bold text-warning mb-3">Acciones de turno</h3>

                <form action="{{ route('roulette.save-points', $game) }}" method="POST" class="mb-3">
                    @csrf
                    <button type="submit" class="btn btn-success btn-game w-100" {{ $roulette->turn_points <= 0 ? 'disabled' : '' }}>
                        Ahorrar puntos de tirada
                    </button>
                </form>

                <form action="{{ route('roulette.buy-letter', $game) }}" method="POST">
                    @csrf

                    <label class="form-label fw-bold">Comprar letra</label>
                    <div class="d-flex gap-2">
                        <input
                            type="text"
                            name="letter"
                            maxlength="1"
                            class="form-control roulette-input text-center"
                            placeholder="A"
                            required
                        >

                        <button type="submit" class="btn btn-warning btn-game text-dark">
                            Comprar
                        </button>
                    </div>

                    <small style="color:#94a3b8;">
                        Vocal: 100 puntos · Consonante: 50 puntos
                    </small>
                </form>
            </div>
        </div>

        <div class="col-md-6">
            <div class="p-4 rounded-4" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.08);">
                <h3 class="fw-bold text-info mb-3">Resolver frase</h3>

                <form action="{{ route('roulette.solve', $game) }}" method="POST">
                    @csrf

                    <textarea
                        name="solution"
                        class="form-control roulette-input mb-3"
                        rows="3"
                        placeholder="Escribe la frase completa..."
                        required
                    ></textarea>

                    <button type="submit" class="btn btn-info btn-game text-white w-100">
                        Resolver
                    </button>
                </form>
            </div>
        </div>
    </div>
@else
    <div class="text-center mt-5">
        @if($roulette->status === 'won')
            <h2 class="text-success fw-bold">¡Has ganado!</h2>
        @else
            <h2 class="text-danger fw-bold">Has perdido</h2>
        @endif

        <p class="subtitle-text">
            Frase correcta: <strong>{{ $roulette->phrase->text }}</strong>
        </p>

        <a href="{{ route('game.modes') }}" class="btn btn-success btn-game">
            Volver a modos
        </a>
    </div>
@endif
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
    padding: 12px;
}

.roulette-input:focus {
    background: rgba(255,255,255,0.12);
    color: #fff;
    border-color: #facc15;
    box-shadow: 0 0 0 0.25rem rgba(250,204,21,0.18);
}
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
    }

    .roulette-wheel {
        width: 310px;
        height: 310px;
        border-radius: 50%;
        position: relative;
        border: 8px solid rgba(255,255,255,0.18);
        box-shadow: 0 0 35px rgba(239,68,68,0.28);
        overflow: hidden;
        transition: transform 3s cubic-bezier(.15,.85,.25,1);
        background:
            conic-gradient(
                #22c55e 0deg 40deg,
                #16a34a 40deg 80deg,
                #15803d 80deg 120deg,
                #38bdf8 120deg 160deg,
                #0284c7 160deg 200deg,
                #ef4444 200deg 240deg,
                #b91c1c 240deg 280deg,
                #facc15 280deg 320deg,
                #a855f7 320deg 360deg
            );
    }

    .roulette-wheel::after {
        content: "";
        position: absolute;
        inset: 95px;
        border-radius: 50%;
        background: #0f172a;
        border: 5px solid rgba(255,255,255,0.15);
    }

    .wheel-label {
        position: absolute;
        z-index: 3;
        color: white;
        font-weight: 900;
        font-size: 0.82rem;
        text-shadow: 0 2px 5px rgba(0,0,0,0.65);
    }

    .label-1 { top: 38px; left: 185px; }
    .label-2 { top: 92px; left: 230px; }
    .label-3 { top: 165px; left: 230px; }
    .label-4 { bottom: 45px; left: 180px; }
    .label-5 { bottom: 45px; left: 82px; }
    .label-6 { top: 165px; left: 35px; }
    .label-7 { top: 92px; left: 42px; }
    .label-8 { top: 38px; left: 92px; }
    .label-9 { top: 138px; left: 120px; }
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
    const wheelResult = document.getElementById('wheelResult');

    const segments = [
        { label: '+50', value: 'plus_50' },
        { label: '+50', value: 'plus_50' },
        { label: '+50', value: 'plus_50' },
        { label: '+100', value: 'plus_100' },
        { label: '+100', value: 'plus_100' },
        { label: '-50', value: 'minus_50' },
        { label: '-50', value: 'minus_50' },
        { label: 'Comodín', value: 'joker' },
        { label: '-1 Vida', value: 'lose_life' },
    ];

    let currentRotation = 0;

    if (spinForm && spinButton && rouletteWheel && wheelResult) {
        spinForm.addEventListener('submit', function (event) {
            event.preventDefault();

            spinButton.disabled = true;
            spinButton.textContent = 'Girando...';

            const selectedIndex = Math.floor(Math.random() * segments.length);
            const selectedSegment = segments[selectedIndex];

            wheelResult.value = selectedSegment.value;

            const segmentAngle = 360 / segments.length;
            const segmentCenter = selectedIndex * segmentAngle + segmentAngle / 2;

            const targetAngle = 360 - segmentCenter;
            const fullTurns = 5 * 360;

            currentRotation += fullTurns + targetAngle;

            rouletteWheel.style.transform = `rotate(${currentRotation}deg)`;

            setTimeout(() => {
                spinForm.submit();
            }, 3000);
        });
    }
</script>
@endpush
