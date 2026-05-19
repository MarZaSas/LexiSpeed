<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LexiSpeed</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background:
                radial-gradient(circle at top left, rgba(56,189,248,0.18), transparent 30%),
                radial-gradient(circle at top right, rgba(168,85,247,0.18), transparent 30%),
                linear-gradient(135deg, #020617, #0f172a, #111827);
            color: #f8fafc;
        }

        .hero-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .hero-card {
            background: rgba(255,255,255,0.07);
            border: 1px solid rgba(255,255,255,0.12);
            backdrop-filter: blur(14px);
            border-radius: 28px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.35);
            overflow: hidden;
        }

        .brand-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 999px;
            background: rgba(56,189,248,0.12);
            color: #7dd3fc;
            font-weight: 700;
            font-size: 0.9rem;
            letter-spacing: 0.5px;
            margin-bottom: 18px;
        }

        .hero-title {
            font-size: clamp(2.5rem, 6vw, 4.8rem);
            font-weight: 900;
            line-height: 1.05;
            margin-bottom: 20px;
            background: linear-gradient(90deg, #38bdf8, #22c55e, #a855f7);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-text {
            color: #cbd5e1;
            font-size: 1.08rem;
            max-width: 700px;
            margin: 0 auto 30px auto;
        }

        .btn-game {
            border-radius: 16px;
            padding: 12px 22px;
            font-weight: 700;
            transition: 0.2s ease;
        }

        .btn-game:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 24px rgba(0,0,0,0.22);
        }

        .feature-card {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 20px;
            padding: 24px;
            height: 100%;
        }

        .feature-icon {
            font-size: 2rem;
            margin-bottom: 12px;
        }

        .feature-title {
            font-weight: 800;
            margin-bottom: 8px;
        }

        .feature-text {
            color: #cbd5e1;
            margin-bottom: 0;
        }

        .mini-panel {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 18px;
            padding: 18px;
            text-align: center;
        }

        .mini-label {
            color: #94a3b8;
            font-size: 0.9rem;
        }

        .mini-value {
            font-size: 1.2rem;
            font-weight: 800;
            margin-top: 4px;
        }

        .footer-note {
            color: #94a3b8;
            font-size: 0.95rem;
        }
    </style>
</head>
<body>
<div class="container hero-wrapper py-5">
    <div class="hero-card w-100 p-4 p-md-5">
        <div class="text-center mb-5">
            <div class="brand-badge">Proyecto DAW · LexiSpeed</div>
            <h1 class="hero-title">Entrena tu velocidad.<br>Domina cada palabra.</h1>
            <p class="hero-text">
                LexiSpeed es una aplicación web gamificada en la que el jugador debe escribir palabras correctamente
                en el menor tiempo posible, mejorando su precisión y rapidez mientras compite por obtener la mejor puntuación.
            </p>

            <div class="d-flex flex-wrap justify-content-center gap-3">
                @auth
                    <a href="{{ route('game.modes') }}" class="btn btn-success btn-game">Jugar ahora</a>

                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('dashboard') }}" class="btn btn-info btn-game text-white">Panel admin</a>
                    @else
                        <a href="{{ route('profile.edit') }}" class="btn btn-outline-light btn-game">Perfil</a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn btn-info btn-game text-white">Iniciar sesión</a>
                    <a href="{{ route('register') }}" class="btn btn-success btn-game">Registrarse</a>
                @endauth

                <a href="#features" class="btn btn-outline-light btn-game">Ver más</a>
            </div>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="mini-panel">
                    <div class="mini-label">Dificultades</div>
                    <div class="mini-value text-success">3 niveles</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mini-panel">
                    <div class="mini-label">Modo principal</div>
                    <div class="mini-value text-info">Escritura rápida</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mini-panel">
                    <div class="mini-label">Objetivo</div>
                    <div class="mini-value text-warning">Máxima puntuación</div>
                </div>
            </div>
        </div>

        <div id="features" class="row g-4">
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">⚡</div>
                    <h3 class="feature-title text-info">Velocidad</h3>
                    <p class="feature-text">
                        Cuanto más rápido completes cada palabra, mayor será tu puntuación final.
                    </p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">🎯</div>
                    <h3 class="feature-title text-success">Precisión</h3>
                    <p class="feature-text">
                        Los errores penalizan tu tiempo, así que no solo importa correr, también acertar.
                    </p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">🏆</div>
                    <h3 class="feature-title text-warning">Progreso</h3>
                    <p class="feature-text">
                        Juega, mejora tus resultados y prepara el terreno para rankings e historial de partidas.
                    </p>
                </div>
            </div>
        </div>

        <div class="text-center mt-5 footer-note">
            Proyecto web desarrollado con Laravel, Blade, Bootstrap, JavaScript y MySQL.
        </div>
    </div>
</div>
</body>
</html>
