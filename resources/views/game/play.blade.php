@extends('layouts.admin')

@section('content')
<div class="row g-4 justify-content-center">
    <div class="col-xl-10">
        <div class="panel-card p-4 p-md-5">
            <div class="text-center mb-5">
                <div class="mb-2" style="color:#94a3b8;">Partida en curso</div>
                <h1 class="title-gradient mb-3">LexiSpeed</h1>
                <p class="subtitle-text mb-0">
                    Escribe la palabra correctamente antes de que se agote el tiempo.
                </p>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="game-stat-card text-center">
                        <div class="stat-label">Dificultad</div>
                        <div class="stat-value text-info text-capitalize">{{ $game->difficulty }}</div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="game-stat-card text-center">
                        <div class="stat-label">Palabra</div>
                        <div class="stat-value text-light">
                            {{ $currentAttempt ? $currentAttempt->word_order : $game->total_words }}
                            / {{ $game->total_words }}
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="game-stat-card text-center">
                        <div class="stat-label">Puntuación</div>
                        <div class="stat-value text-success">{{ $game->total_score }}</div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="game-stat-card text-center">
                        <div class="stat-label">Errores</div>
                        <div class="stat-value text-danger">{{ $game->total_errors }}</div>
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <div class="d-flex justify-content-between mb-2">
                    <span style="color:#cbd5e1;">Progreso de la partida</span>
                    <span style="color:#94a3b8;">
                        {{ $game->attempts->where('is_completed', true)->count() }} / {{ $game->total_words }}
                    </span>
                </div>

                <div class="progress progress-custom">
                    <div
                        class="progress-bar progress-bar-custom"
                        role="progressbar"
                        style="width: {{ $game->total_words > 0 ? (($game->attempts->where('is_completed', true)->count()) / $game->total_words) * 100 : 0 }}%;"
                    ></div>
                </div>
            </div>

            @if(!$isFinished && $currentAttempt)
                <div class="game-area text-center" id="game-area">
                    <div class="timer-wrapper mb-4">
                        <div class="timer-circle">
                            <span id="timerValue">0</span>s
                        </div>
                        <div class="timer-label">Tiempo restante</div>
                    </div>

                    <div class="mb-2" style="color:#94a3b8;">
                        Palabra {{ $currentAttempt->word_order }} de {{ $game->total_words }}
                    </div>

                    <h2 class="current-word mb-4">
                        {{ $currentAttempt->word->text }}
                    </h2>

                    <form id="attemptForm" action="{{ route('game.attempt', $game) }}" method="POST">
                        @csrf

                        <input type="hidden" name="typed_word" id="typedWordHidden">
                        <input type="hidden" name="time_spent" id="timeSpentHidden">
                        <input type="hidden" name="errors_count" id="errorsCountHidden" value="0">
                        <input type="hidden" name="penalty_time" id="penaltyTimeHidden" value="0">

                        <div class="mx-auto" style="max-width: 520px;">
                            <input
                                type="text"
                                id="wordInput"
                                class="form-control game-input text-center"
                                placeholder="Escribe aquí la palabra..."
                                autocomplete="off"
                            >
                        </div>

                        <div class="mt-3" id="feedbackMessage" style="min-height: 24px; color:#94a3b8;">
                            Empieza a escribir cuando quieras.
                        </div>

                        <div class="d-flex flex-wrap justify-content-center gap-3 mt-4">
                            <button type="submit" class="btn btn-success btn-game px-4" id="submitButton">
                                Enviar palabra
                            </button>

                            <a href="{{ route('game.difficulty') }}" class="btn btn-outline-light btn-game px-4">
                                Salir
                            </a>
                        </div>
                    </form>
                </div>
            @else
                <div class="text-center py-5">
                    <h2 class="text-success fw-bold mb-3">¡Partida completada!</h2>
                    <p class="subtitle-text mb-4">Has terminado todas las palabras de esta partida.</p>

                    <div class="row g-3 justify-content-center mb-4">
                        <div class="col-md-4">
                            <div class="game-stat-card text-center">
                                <div class="stat-label">Puntuación final</div>
                                <div class="stat-value text-success">{{ $game->total_score }}</div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="game-stat-card text-center">
                                <div class="stat-label">Errores totales</div>
                                <div class="stat-value text-danger">{{ $game->total_errors }}</div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="game-stat-card text-center">
                                <div class="stat-label">Tiempo penalizado</div>
                                <div class="stat-value text-warning">{{ $game->total_penalty_time }}s</div>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('game.difficulty') }}" class="btn btn-success btn-game">Jugar otra vez</a>
                </div>
            @endif
        </div>
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
        height: 100%;
    }

    .stat-label {
        color: #94a3b8;
        font-size: 0.9rem;
        margin-bottom: 6px;
    }

    .stat-value {
        font-size: 1.35rem;
        font-weight: 800;
    }

    .progress-custom {
        height: 14px;
        border-radius: 999px;
        background: rgba(255,255,255,0.08);
        overflow: hidden;
    }

    .progress-bar-custom {
        background: linear-gradient(90deg, #38bdf8, #22c55e, #a855f7);
        border-radius: 999px;
    }

    .game-area {
        background: rgba(255,255,255,0.04);
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 24px;
        padding: 32px 24px;
    }

    .timer-wrapper {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .timer-circle {
        width: 110px;
        height: 110px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: radial-gradient(circle, rgba(56,189,248,0.20), rgba(56,189,248,0.08));
        border: 3px solid rgba(56,189,248,0.55);
        color: #7dd3fc;
        font-weight: 900;
        font-size: 2rem;
        box-shadow: 0 0 25px rgba(56,189,248,0.18);
    }

    .timer-label {
        margin-top: 10px;
        color: #94a3b8;
        font-size: 0.95rem;
    }

    .current-word {
        font-size: clamp(2rem, 5vw, 3.5rem);
        font-weight: 900;
        color: #f8fafc;
        letter-spacing: 1px;
        text-transform: lowercase;
    }

    .game-input {
        background: rgba(255,255,255,0.08);
        border: 1px solid rgba(255,255,255,0.14);
        color: #fff;
        border-radius: 18px;
        padding: 16px 20px;
        min-height: 60px;
        font-size: 1.2rem;
        font-weight: 700;
    }

    .game-input::placeholder {
        color: #94a3b8;
        font-weight: 500;
    }

    .game-input:focus {
        background: rgba(255,255,255,0.12);
        color: #fff;
        border-color: #38bdf8;
        box-shadow: 0 0 0 0.25rem rgba(56,189,248,0.18);
    }

    .game-input.error-state {
        border-color: rgba(239, 68, 68, 0.9);
        box-shadow: 0 0 0 0.25rem rgba(239,68,68,0.14);
    }

    .game-input.success-state {
        border-color: rgba(34, 197, 94, 0.9);
        box-shadow: 0 0 0 0.25rem rgba(34,197,94,0.14);
    }
</style>
@endpush

@push('scripts')
@if(!$isFinished && $currentAttempt)
<script>
    const targetWord = @json(strtolower($currentAttempt->word->text));
    const difficulty = @json($game->difficulty);

    const timeLimits = {
        easy: 5,
        medium: 7,
        hard: 8
    };

    const input = document.getElementById('wordInput');
    const feedback = document.getElementById('feedbackMessage');
    const timerValue = document.getElementById('timerValue');
    const form = document.getElementById('attemptForm');

    const typedWordHidden = document.getElementById('typedWordHidden');
    const timeSpentHidden = document.getElementById('timeSpentHidden');
    const errorsCountHidden = document.getElementById('errorsCountHidden');
    const penaltyTimeHidden = document.getElementById('penaltyTimeHidden');

    let timeLeft = timeLimits[difficulty] || 8;
    let timeLimit = timeLeft;
    let errorsCount = 0;
    let penaltyTime = 0;
    let timerInterval = null;
    let previousValue = '';

    timerValue.textContent = timeLeft;

    function startTimer() {
        timerInterval = setInterval(() => {
            timeLeft -= 1;
            timerValue.textContent = Math.max(0, timeLeft);

            if (timeLeft <= 0) {
                clearInterval(timerInterval);
                submitAttempt();
            }
        }, 1000);
    }

    function submitAttempt() {
        clearInterval(timerInterval);

        typedWordHidden.value = input.value.trim().toLowerCase();
        timeSpentHidden.value = Math.max(0, timeLimit - timeLeft);
        errorsCountHidden.value = errorsCount;
        penaltyTimeHidden.value = penaltyTime.toFixed(2);

        form.submit();
    }

    function validateWord() {
        const value = input.value.toLowerCase();

        input.classList.remove('error-state', 'success-state');

        if (value === '') {
            feedback.textContent = 'Empieza a escribir la palabra.';
            feedback.style.color = '#94a3b8';
            previousValue = value;
            return;
        }

        if (targetWord.startsWith(value)) {
            feedback.textContent = 'Vas bien, sigue escribiendo.';
            feedback.style.color = '#7dd3fc';
        } else {
            input.classList.add('error-state');
            feedback.textContent = 'Hay un error en lo que has escrito.';
            feedback.style.color = '#fca5a5';

            if (value !== previousValue) {
                errorsCount += 1;
                penaltyTime += 0.5;
                timeLeft = Math.max(0, timeLeft - 0.5);
                timerValue.textContent = Math.max(0, Math.ceil(timeLeft));
            }
        }

        if (value === targetWord) {
            input.classList.add('success-state');
            feedback.textContent = '¡Correcta! Pasando a la siguiente palabra...';
            feedback.style.color = '#86efac';

            setTimeout(() => {
                submitAttempt();
            }, 500);
        }

        previousValue = value;
    }

    input.addEventListener('input', validateWord);

    window.addEventListener('load', () => {
    const gameArea = document.getElementById('game-area');

    if (gameArea) {
        gameArea.scrollIntoView({
            behavior: 'smooth',
            block: 'center'
        });
    }

    setTimeout(() => {
        input.focus();
        startTimer();
    }, 400);
});
</script>
@endif
@endpush
