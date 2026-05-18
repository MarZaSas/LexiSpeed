@extends('layouts.admin')

@section('content')
<div class="row g-4 justify-content-center">
    <div class="col-xl-10">
        <div class="panel-card p-4 p-md-5">
            <div class="text-center mb-5">
                <div class="mb-2" style="color:#94a3b8;">Modo Fantasma</div>
                <h1 class="title-gradient mb-3">Memoriza la frase</h1>
                <p class="subtitle-text mb-0">
                    La frase aparecerá durante 3 segundos. Después tendrás que escribirla de memoria.
                </p>
            </div>

            @if(!$isFinished && $currentAttempt)
                <div class="game-area text-center" id="ghost-area">
                    <div class="mb-3" style="color:#94a3b8;">
                        Frase {{ $currentAttempt->phrase_order }} de 3
                    </div>

                    <div id="memoryPhase">
                        <div class="timer-circle mx-auto mb-4">
                            <span id="memoryTimer">3</span>s
                        </div>

                        <div class="phrase-box mb-4">
                            {{ $currentAttempt->phrase->text }}
                        </div>

                        <p class="subtitle-text">Memoriza la frase antes de que desaparezca.</p>
                    </div>

                    <form id="ghostForm" action="{{ route('ghost.attempt', $game) }}" method="POST" class="d-none">
                        @csrf

                        <div class="mb-4">
                            <label class="form-label fw-bold">Escribe la frase de memoria</label>
                            <textarea
                                name="typed_phrase"
                                id="typedPhrase"
                                rows="4"
                                class="form-control ghost-input"
                                placeholder="Escribe aquí lo que recuerdes..."
                                required
                            ></textarea>
                        </div>

                        <div class="d-flex justify-content-center gap-3 flex-wrap">
                            <button type="submit" class="btn btn-warning btn-game text-dark">
                                Enviar frase
                            </button>

                            <a href="{{ route('game.modes') }}" class="btn btn-outline-light btn-game">
                                Salir
                            </a>
                        </div>
                    </form>
                </div>
            @else
                <div class="text-center py-5">
                    <h2 class="text-success fw-bold mb-3">¡Modo Fantasma completado!</h2>
                    <p class="subtitle-text mb-4">Has terminado las 3 frases.</p>

                    <div class="game-stat-card text-center mx-auto mb-4" style="max-width: 300px;">
                        <div class="stat-label">Puntuación final</div>
                        <div class="stat-value text-warning">{{ $game->total_score }} / 300</div>
                    </div>

                    <a href="{{ route('game.modes') }}" class="btn btn-success btn-game">
                        Volver a modos
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .game-area {
        background: rgba(255,255,255,0.04);
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 24px;
        padding: 32px 24px;
    }

    .timer-circle {
        width: 110px;
        height: 110px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: radial-gradient(circle, rgba(234,179,8,0.22), rgba(234,179,8,0.08));
        border: 3px solid rgba(234,179,8,0.65);
        color: #fde68a;
        font-weight: 900;
        font-size: 2rem;
    }

    .phrase-box {
        background: rgba(255,255,255,0.08);
        border: 1px solid rgba(255,255,255,0.12);
        border-radius: 20px;
        padding: 28px;
        font-size: 1.6rem;
        font-weight: 800;
        color: #f8fafc;
    }

    .ghost-input {
        background: rgba(255,255,255,0.08);
        border: 1px solid rgba(255,255,255,0.14);
        color: #fff;
        border-radius: 18px;
        padding: 16px;
        font-size: 1.1rem;
    }

    .ghost-input:focus {
        background: rgba(255,255,255,0.12);
        color: #fff;
        border-color: #facc15;
        box-shadow: 0 0 0 0.25rem rgba(250,204,21,0.18);
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
</style>
@endpush

@push('scripts')
@if(!$isFinished && $currentAttempt)
<script>
    const memoryTimer = document.getElementById('memoryTimer');
    const memoryPhase = document.getElementById('memoryPhase');
    const ghostForm = document.getElementById('ghostForm');
    const typedPhrase = document.getElementById('typedPhrase');
    const ghostArea = document.getElementById('ghost-area');

    let timeLeft = 3;

    window.addEventListener('load', () => {
        ghostArea.scrollIntoView({ behavior: 'auto', block: 'center' });

        const interval = setInterval(() => {
            timeLeft--;
            memoryTimer.textContent = timeLeft;

            if (timeLeft <= 0) {
                clearInterval(interval);
                memoryPhase.classList.add('d-none');
                ghostForm.classList.remove('d-none');
                typedPhrase.focus();
            }
        }, 1000);
    });
</script>
@endif
@endpush
