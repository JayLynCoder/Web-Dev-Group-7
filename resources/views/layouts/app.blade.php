<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'HexaHub') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        
        <!-- Vite & Custom Auth CSS -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    </head>
    <body style="margin: 0; background-color: #05051a !important;">
        <!-- Background video strictly in the layout -->
        <video class="background-video" autoplay muted loop playsinline aria-hidden="true">
            <source src="{{ asset('videos/background.mp4') }}" type="video/mp4">
        </video>
        <div class="background-overlay" aria-hidden="true"></div>

        <main class="auth-page" style="flex-direction: column; justify-content: flex-start; padding-top: 2.5rem;">
            <div style="width: 100%; max-width: 900px; display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; z-index: 2; padding: 0 1rem;">
                <a href="/" aria-label="HexaHub Home">
                    <img src="{{ asset('images/hexahub.png') }}" alt="HexaHub" style="width: 160px; height: auto; display: block;">
                </a>
                <div style="display: flex; align-items: center; gap: 1rem; font-size: 0.85rem; color: #ffffff;">
                    <span>{{ Auth::user()->name ?? 'User' }}</span>
                    <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                        @csrf
                        <button type="submit" style="background: rgba(255, 255, 255, 0.15); border: 1px solid rgba(255, 255, 255, 0.3); color: white; padding: 0.4rem 0.8rem; border-radius: 6px; cursor: pointer; font-family: inherit; font-size: 0.8rem;">
                            Log Out
                        </button>
                    </form>
                </div>
            </div>

            <div class="auth-content" style="max-width: 900px; width: 100%;">
                <section class="auth-section" style="width: 100%;">
                    <article class="auth-card" style="text-align: left;">
                        <!-- This injects the dashboard content -->
                        {{ $slot }}
                    </article>
                </section>

                <footer class="site-footer">
                    <p>Group 7</p>
                </footer>
            </div>
        </main>
    </body>
</html>