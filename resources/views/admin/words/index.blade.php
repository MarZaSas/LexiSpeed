@extends('layouts.admin')

@section('content')
<div class="panel-card p-4 p-md-5">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h1 class="title-gradient mb-2">Panel de Palabras</h1>
            <p class="subtitle-text mb-0">Gestiona las palabras del juego de forma visual, rápida y ordenada.</p>
        </div>

        <a href="{{ route('words.create') }}" class="btn btn-success btn-game">+ Nueva palabra</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success rounded-4 border-0 shadow-sm mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-3" style="color:#94a3b8;">
        Total de palabras registradas: <strong>{{ $words->count() }}</strong>
    </div>

    <div class="table-responsive">
        <table class="table table-custom align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Palabra</th>
                    <th>Dificultad</th>
                    <th>Longitud</th>
                    <th>Estado</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($words as $word)
                    <tr>
                        <td>{{ $word->id }}</td>
                        <td class="fw-bold">{{ $word->text }}</td>
                        <td>
                            @if($word->difficulty === 'easy')
                                <span class="badge rounded-pill text-bg-success">Fácil</span>
                            @elseif($word->difficulty === 'medium')
                                <span class="badge rounded-pill text-bg-warning">Intermedio</span>
                            @else
                                <span class="badge rounded-pill text-bg-danger">Difícil</span>
                            @endif
                        </td>
                        <td>{{ $word->length }}</td>
                        <td>
                            @if($word->is_active)
                                <span class="text-success fw-bold">Activa</span>
                            @else
                                <span class="text-danger fw-bold">Inactiva</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex flex-wrap gap-2 justify-content-center">
                                <a href="{{ route('words.edit', $word) }}" class="btn btn-sm btn-outline-info rounded-pill px-3">
                                    Editar
                                </a>

                                <form action="{{ route('words.toggle', $word) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-sm {{ $word->is_active ? 'btn-outline-warning' : 'btn-outline-success' }} rounded-pill px-3">
                                        {{ $word->is_active ? 'Desactivar' : 'Activar' }}
                                    </button>
                                </form>

                                <form action="{{ route('words.destroy', $word) }}" method="POST" onsubmit="return confirm('¿Seguro que quieres eliminar esta palabra?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                                        Borrar
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-light">
                            Todavía no hay palabras registradas.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection