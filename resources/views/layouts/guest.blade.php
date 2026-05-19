<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'LexiSpeed') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            margin: 0;
            min-height: 100vh;
            background:
                radial-gradient(circle at top left, rgba(56,189,248,0.18), transparent 30%),
                radial-gradient(circle at top right, rgba(168,85,247,0.18), transparent 30%),
                linear-gradient(135deg, #020617, #0f172a, #111827);
            color: #f8fafc;
            font-family: Arial, sans-serif;
        }

        .auth-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 32px 16px;
        }

        .auth-card {
            width: 100%;
            max-width: 460px;
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.12);
            backdrop-filter: blur(14px);
            border-radius: 26px;
            padding: 36px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.35);
        }

        .auth-badge {
            display: inline-block;
            padding: 7px 15px;
            border-radius: 999px;
            background: rgba(56,189,248,0.14);
            color: #7dd3fc;
            font-weight: 800;
            margin-bottom: 14px;
        }

        .auth-title {
            font-size: 2rem;
            font-weight: 900;
            background: linear-gradient(90deg, #38bdf8, #22c55e, #a855f7);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .auth-subtitle {
            color: #cbd5e1;
            margin-bottom: 0;
        }

        .auth-label {
            color: #e2e8f0;
            font-weight: 700;
            margin-bottom: 8px;
            display: block;
        }

        .auth-input {
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.16);
            color: #fff;
            border-radius: 14px;
            min-height: 52px;
            padding: 12px 14px;
        }

        .auth-input:focus {
            background: rgba(255,255,255,0.12);
            color: #fff;
            border-color: #38bdf8;
            box-shadow: 0 0 0 0.25rem rgba(56,189,248,0.18);
        }

        .auth-small {
            color: #cbd5e1;
        }

        .auth-link {
            color: #7dd3fc;
            text-decoration: none;
            font-weight: 700;
        }

        .auth-link:hover {
            color: #fff;
            text-decoration: underline;
        }

        .auth-button {
            border-radius: 14px;
            padding: 12px 18px;
            font-weight: 800;
            transition: 0.2s ease;
        }

        .auth-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 18px rgba(0,0,0,0.25);
        }
    </style>
</head>
<body>
    {{ $slot }}
</body>
</html>
