@extends('layouts.admin')

@section('content')
<div class="text-center mb-5">
    <h1 class="title-gradient mb-3">Tu perfil</h1>
    <p class="subtitle-text">Gestiona tu información personal, tu contraseña y la seguridad de tu cuenta.</p>
</div>

<div class="row justify-content-center mb-4">
    <div class="col-lg-8">
        <div class="profile-hero-card text-center p-4 p-md-5">

            <div class="profile-avatar mb-3">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>

            <h2 class="fw-bold text-light mb-1">
                {{ auth()->user()->name }}
            </h2>

            <div class="text-secondary mb-3">
                {{ auth()->user()->email }}
            </div>

            <div class="d-flex justify-content-center gap-2 flex-wrap">
                @if(auth()->user()->isAdmin())
                    <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold">
                        Administrador
                    </span>
                @else
                    <span class="badge bg-info px-3 py-2 rounded-pill fw-bold">
                        Jugador
                    </span>
                @endif

                <span class="badge bg-success px-3 py-2 rounded-pill fw-bold">
                    Activo
                </span>
            </div>

        </div>
    </div>
</div>

<div class="row g-4 justify-content-center mb-4">
    <div class="col-lg-10">
        <div class="panel-card p-4">
            <h2 class="profile-section-title mb-3">Filtrar estadísticas</h2>

            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('profile.edit', ['mode' => 'all']) }}"
                   class="btn btn-game {{ $selectedMode === 'all' ? 'btn-info text-white' : 'btn-outline-light' }}">
                    Todas
                </a>

                <a href="{{ route('profile.edit', ['mode' => 'classic']) }}"
                   class="btn btn-game {{ $selectedMode === 'classic' ? 'btn-info text-white' : 'btn-outline-light' }}">
                    Clásico
                </a>

                <a href="{{ route('profile.edit', ['mode' => 'ghost']) }}"
                   class="btn btn-game {{ $selectedMode === 'ghost' ? 'btn-warning text-dark' : 'btn-outline-light' }}">
                    Fantasma
                </a>

                <a href="{{ route('profile.edit', ['mode' => 'roulette']) }}"
                   class="btn btn-game {{ $selectedMode === 'roulette' ? 'btn-danger' : 'btn-outline-light' }}">
                    Ruleta
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 justify-content-center mb-4">
    <div class="col-lg-10">
        <div class="panel-card p-4 p-md-5">
            <h2 class="profile-section-title mb-4">
                Estadísticas de juego
                @if($selectedMode !== 'all')
                    <span class="text-info text-capitalize">· {{ $selectedMode }}</span>
                @endif
            </h2>

            <div class="row g-3">
                <div class="col-md-3">
                    <div class="profile-stat-card text-center">
                        <div class="stat-label">Partidas</div>
                        <div class="stat-value text-info">{{ $stats['total_games'] }}</div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="profile-stat-card text-center">
                        <div class="stat-label">Mejor puntuación</div>
                        <div class="stat-value text-success">{{ $stats['best_score'] }}</div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="profile-stat-card text-center">
                        <div class="stat-label">Media</div>
                        <div class="stat-value text-warning">{{ $stats['average_score'] }}</div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="profile-stat-card text-center">
                        <div class="stat-label">Errores</div>
                        <div class="stat-value text-danger">{{ $stats['total_errors'] }}</div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>
<div class="row g-4 justify-content-center mb-4">
    <div class="col-lg-10">
        <div class="panel-card p-4 p-md-5">
            <h2 class="profile-section-title mb-4">Últimas partidas</h2>

            <div class="table-responsive">
                <table class="table table-custom align-middle">
                    <thead>
                        <tr>
                            <th>Modo</th>
                            <th>Dificultad</th>
                            <th>Puntuación</th>
                            <th>Errores</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($latestGames as $game)
                            <tr>
                                <td class="fw-bold text-capitalize">{{ $game->mode }}</td>
                                <td class="text-capitalize">{{ $game->difficulty }}</td>
                                <td class="fw-bold text-success">{{ $game->total_score }}</td>
                                <td class="text-danger fw-bold">{{ $game->total_errors }}</td>
                                <td>{{ $game->ended_at ? $game->ended_at->format('d/m/Y H:i') : '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    Todavía no hay partidas registradas.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 justify-content-center">
    <div class="col-lg-10">
        <div class="panel-card p-4 p-md-5">
            <div class="mb-4">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>
    </div>

    <div class="col-lg-10">
        <div class="panel-card p-4 p-md-5">
            <div class="mb-4">
                @include('profile.partials.update-password-form')
            </div>
        </div>
    </div>

    <div class="col-lg-10">
        <div class="panel-card p-4 p-md-5 border border-danger-subtle">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .profile-stat-card {
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
    font-size: 1.45rem;
    font-weight: 900;
}
    .profile-hero-card {
        background: rgba(255,255,255,0.06);
        border: 1px solid rgba(255,255,255,0.12);
        backdrop-filter: blur(12px);
        border-radius: 24px;
        box-shadow: 0 15px 40px rgba(0,0,0,0.35);
    }

    .profile-avatar {
        width: 70px;
        height: 70px;
        margin: 0 auto;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;

        font-size: 1.8rem;
        font-weight: 900;
        color: #fff;

        background: linear-gradient(135deg, #38bdf8, #22c55e, #a855f7);
        box-shadow: 0 8px 20px rgba(0,0,0,0.3);
    }

    .profile-section-title {
        font-size: 1.4rem;
        font-weight: 800;
        color: #f8fafc;
        margin-bottom: 8px;
    }

    .profile-section-text {
        color: #94a3b8;
        margin-bottom: 24px;
    }

    .profile-label {
        color: #e2e8f0;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .profile-input {
        background: rgba(255,255,255,0.08);
        border: 1px solid rgba(255,255,255,0.14);
        color: #fff;
        border-radius: 14px;
        padding: 12px 14px;
        min-height: 52px;
    }

    .profile-input:focus {
        background: rgba(255,255,255,0.12);
        color: #fff;
        border-color: #38bdf8;
        box-shadow: 0 0 0 0.25rem rgba(56,189,248,0.18);
    }

    .profile-input::placeholder {
        color: #94a3b8;
    }

    .profile-helper {
        color: #94a3b8;
        font-size: 0.95rem;
    }

    .profile-danger-box {
        background: rgba(239, 68, 68, 0.08);
        border: 1px solid rgba(239, 68, 68, 0.18);
        border-radius: 18px;
        padding: 20px;
    }

    .profile-save-text {
        color: #86efac;
        font-weight: 600;
    }
</style>
@endpush
