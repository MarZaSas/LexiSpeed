@extends('layouts.admin')

@section('content')
<div class="panel-card p-4 p-md-5">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h1 class="title-gradient mb-2">Frases Fantasma</h1>
            <p class="subtitle-text mb-0">Gestiona las frases que aparecerán en el modo fantasma.</p>
        </div>

        <a href="{{ route('phrases.create') }}" class="btn btn-success btn-game">
            + Nueva frase
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success rounded-4 border-0 shadow-sm mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-custom align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Frase</th>
                    <th>Estado</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($phrases as $phrase)
                    <tr>
                        <td>{{ $phrase->id }}</td>
                        <td class="fw-bold">{{ $phrase->text }}</td>
                        <td>
                            @if($phrase->is_active)
                                <span class="text-success fw-bold">Activa</span>
                            @else
                                <span class="text-danger fw-bold">Inactiva</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex flex-wrap gap-2 justify-content-center">
                                <a href="{{ route('phrases.edit', $phrase) }}" class="btn btn-sm btn-outline-info rounded-pill px-3">
                                    Editar
                                </a>

                                <form action="{{ route('phrases.toggle', $phrase) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-sm {{ $phrase->is_active ? 'btn-outline-warning' : 'btn-outline-success' }} rounded-pill px-3">
                                        {{ $phrase->is_active ? 'Desactivar' : 'Activar' }}
                                    </button>
                                </form>

                                <form action="{{ route('phrases.destroy', $phrase) }}" method="POST" onsubmit="return confirm('¿Seguro que quieres eliminar esta frase?');">
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
                        <td colspan="4" class="text-center py-4 text-light">
                            Todavía no hay frases registradas.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $phrases->links() }}
    </div>
</div>
@endsection
