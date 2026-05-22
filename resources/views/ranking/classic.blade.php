@extends('layouts.admin')

@section('content')
<div class="panel-card p-4 p-md-5">
    <div class="text-center mb-5">
        <h1 class="title-gradient mb-3">Ranking Clásico</h1>
        <p class="subtitle-text">
            Mejores puntuaciones del modo clásico de LexiSpeed.
        </p>
    </div>

    <div class="table-responsive">
        <table class="table table-custom align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Jugador</th>
                    <th>Dificultad</th>
                    <th>Puntuación</th>
                    <th>Errores</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                @forelse($games as $index => $game)
                    <tr>
                        <td class="fw-bold">
                            {{ $index + 1 }}
                        </td>

                        <td class="fw-bold">
                            {{ $game->user->name ?? 'Usuario eliminado' }}
                        </td>

                        <td>
                            <span class="badge rounded-pill bg-info text-dark">
                                {{ ucfirst($game->difficulty) }}
                            </span>
                        </td>

                        <td class="fw-bold text-success">
                            {{ $game->total_score }}
                        </td>

                        <td class="text-danger fw-bold">
                            {{ $game->total_errors }}
                        </td>

                        <td>
                            {{ $game->ended_at ? $game->ended_at->format('d/m/Y H:i') : '-' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">
                            Todavía no hay partidas clásicas completadas.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
