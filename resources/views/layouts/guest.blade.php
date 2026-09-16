<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'HexaHub') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body, html {
            width: 100%;
            height: 100%;
            font-family: 'Figtree', sans-serif;
            background-color: #05051a;
            color: #ffffff;
            overflow-x: hidden;
        }

        /* Fullscreen Video Background */
        .bg-video-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            z-index: -2;
            overflow: hidden;
        }
        .bg-video-container video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .bg-overlay {
            position: fixed;
            inset: 0;
            background: rgba(5, 5, 25, 0.45);
            z-index: -1;
        }

        /* Center Layout Structure */
        .auth-container {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 2rem 1rem;
        }

        /* Brand Header */
        .brand-logo {
            margin-bottom: 1.25rem;
            text-align: center;
        }
        .brand-logo img {
            height: 52px;
            width: auto;
            display: block;
        }

        /* Translucent Glass Card */
        .auth-card {
            width: 100%;
            max-width: 420px;
            background: rgba(255, 255, 255, 0.09);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 16px;
            padding: 2rem 2.25rem 1.75rem;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.6);
        }

        /* Form Fields */
        .form-group {
            margin-bottom: 1rem;
        }
        .form-label {
            display: block;
            font-size: 0.825rem;
            font-weight: 500;
            color: #f1f5f9;
            margin-bottom: 0.35rem;
            text-align: left;
        }
        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }
        .input-icon {
            position: absolute;
            left: 14px;
            color: #334155;
            display: flex;
            align-items: center;
            justify-content: center;
            pointer-events: none;
            z-index: 2;
        }
        .form-input {
            width: 100%;
            padding: 0.7rem 1rem 0.7rem 2.5rem;
            background-color: #e2e8f0;
            border: 1px solid transparent;
            border-radius: 8px;
            color: #0f172a;
            font-size: 0.85rem;
            outline: none;
            transition: all 0.2s ease;
        }
        .form-input::placeholder {
            color: #64748b;
            font-size: 0.825rem;
        }
        .form-input:focus {
            background-color: #ffffff;
            border-color: #818cf8;
            box-shadow: 0 0 0 3px rgba(129, 140, 248, 0.25);
        }

        /* Submit Button */
        .btn-submit {
            width: 100%;
            padding: 0.75rem;
            background-color: #0b0b2e;
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 8px;
            color: #ffffff;
            font-weight: 700;
            font-size: 0.875rem;
            cursor: pointer;
            transition: background-color 0.2s ease;
            margin-top: 0.5rem;
        }
        .btn-submit:hover {
            background-color: #141448;
        }

        /* Subtext inside Card */
        .card-footer-text {
            margin-top: 1.25rem;
            text-align: center;
            font-size: 0.8rem;
            color: #cbd5e1;
        }
        .card-footer-text a {
            color: #38bdf8;
            text-decoration: underline;
            font-weight: 500;
        }
        .card-footer-text a:hover {
            color: #7dd3fc;
        }

        /* Bottom Footer Outside Card */
        .site-footer {
            margin-top: 1.25rem;
            text-align: center;
            font-size: 0.8rem;
            color: #94a3b8;
        }
    </style>
</head>
<body>
    <div class="bg-video-container">
        <video autoplay muted loop playsinline>
            <source src="{{ asset('videos/background.mp4') }}" type="video/mp4">
        </video>
    </div>
    <div class="bg-overlay"></div>

    <div class="auth-container">
        <header class="brand-logo">
            <a href="/">
                <img src="{{ asset('images/hexahub.png') }}" alt="HexaHub">
            </a>
        </header>

        <main class="auth-card">
            {{ $slot }}
        </main>

        <footer class="site-footer">
            <p>Group 7</p>
        </footer>
    </div>
</body>
</html>