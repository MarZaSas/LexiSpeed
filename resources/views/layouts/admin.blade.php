<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Panel Admin' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #0f172a, #111827, #020617);
            color: #f8fafc;
            font-family: Arial, sans-serif;
        }

        .admin-navbar {
            background: rgba(15, 23, 42, 0.75);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }

        .brand-gradient {
            font-weight: 800;
            font-size: 1.4rem;
            background: linear-gradient(90deg, #38bdf8, #22c55e, #a855f7);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .nav-link-custom {
            color: #cbd5e1 !important;
            font-weight: 600;
            padding: 8px 14px;
            border-radius: 12px;
            transition: 0.2s ease;
        }

        .nav-link-custom:hover {
            color: #fff !important;
            background: rgba(255,255,255,0.08);
        }

        .panel-card {
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.12);
            backdrop-filter: blur(12px);
            border-radius: 24px;
            box-shadow: 0 14px 40px rgba(0,0,0,0.35);
        }

        .page-wrapper {
            padding: 40px 0;
        }

        .title-gradient {
            font-size: 2rem;
            font-weight: 800;
            background: linear-gradient(90deg, #38bdf8, #22c55e, #a855f7);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .subtitle-text {
            color: #cbd5e1;
        }

        .btn-game {
            border-radius: 14px;
            padding: 11px 18px;
            font-weight: 700;
            transition: 0.2s ease;
        }

        .btn-game:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 18px rgba(0,0,0,0.25);
        }

        .table-custom {
            color: #f8fafc;
        }

        .table-custom th,
        .table-custom td {
            border-color: rgba(255,255,255,0.08);
        }

        .table-custom thead th {
            background: rgba(255,255,255,0.06);
            color: #e2e8f0;
        }
        .nav-avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;

            display: flex;
            align-items: center;
            justify-content: center;

            font-weight: 900;
            font-size: 1.1rem;
            color: #fff;

            background: linear-gradient(135deg, #38bdf8, #22c55e, #a855f7);

            box-shadow: 0 6px 18px rgba(0,0,0,0.3);
        }

        .nav-username {
            font-weight: 800;
            color: #f8fafc;
            font-size: 0.95rem;
        }

        .nav-role {
            font-size: 0.75rem;
            opacity: 0.8;
        }
    </style>

    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg admin-navbar">
        <div class="container d-flex justify-content-between align-items-center flex-wrap gap-3">
            <a href="{{ auth()->user()->isAdmin() ? route('dashboard') : route('game.difficulty') }}"
            class="d-flex align-items-center gap-2 text-decoration-none">

                <div class="nav-avatar">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>

                <div class="d-flex flex-column lh-sm">
                    @if(auth()->user()->isAdmin())
                        <span class="nav-username">Admin</span>
                        <small class="nav-role text-warning">Administrador</small>
                    @else
                        <span class="nav-username">
                            {{ \Illuminate\Support\Str::limit(auth()->user()->name, 14, '') }}
                        </span>
                        <small class="nav-role text-info">Jugador</small>
                    @endif
                </div>

            </a>

            <div class="d-flex gap-3 flex-wrap align-items-center">
                <a href="{{ url('/') }}" class="nav-link nav-link-custom">Inicio</a>
                <a href="{{ route('game.modes') }}" class="nav-link nav-link-custom">Jugar</a>

                @if(auth()->user()->isAdmin())
                    <a href="{{ route('dashboard') }}" class="nav-link nav-link-custom">Panel</a>
                    <a href="{{ route('words.index') }}" class="nav-link nav-link-custom">Palabras</a>
                    <a href="{{ route('words.create') }}" class="nav-link nav-link-custom">Nueva palabra</a>
                    <a href="{{ route('phrases.index') }}" class="nav-link nav-link-custom">Frases</a>
                @endif

                <a href="{{ route('profile.edit') }}" class="nav-link nav-link-custom">Perfil</a>

                <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3">
                        Cerrar sesión
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container page-wrapper">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
