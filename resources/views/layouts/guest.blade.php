<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'GuardYou') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Outfit:wght@400;600;700;800;900&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            :root {
                --color-bg:               #080c14;
                --color-surface-container:#111827;
                --color-border:           rgba(255,255,255,0.07);
                --color-on-surface:       #ffffff;
                --color-on-surface-muted: #8b9ab0;
                --color-on-surface-variant:#6b7a8d;
                --color-gold:             #DC143C;
                --color-gold-light:       #FF2D55;
                --color-gold-dark:        #B01030;
                --font-display: 'Outfit', sans-serif;
                --font-body:    'Inter', sans-serif;
            }
            body {
                font-family: var(--font-body);
                background-color: var(--color-bg);
                color: var(--color-on-surface);
            }
            .auth-page {
                min-height: 100vh;
                display: flex; align-items: center; justify-content: center;
                padding: 3rem 1.5rem;
                background: radial-gradient(ellipse 60% 50% at 50% 50%, rgba(220,20,60,0.04) 0%, transparent 65%);
            }
            .auth-card {
                width: 100%; max-width: 460px;
                background: var(--color-surface-container);
                border: 1px solid var(--color-border);
                border-radius: 16px; padding: 2.5rem 2.5rem 2rem;
                box-shadow: 0 30px 80px rgba(0,0,0,0.4);
                
                /* Animation Setup */
                opacity: 0;
                transform: translateY(20px) scale(0.98);
                transition: opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1), transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
                position: relative;
                z-index: 2;
            }
            .auth-card.animate-in {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
            .pointer-glow {
                position: fixed;
                top: 0; left: 0;
                width: 600px; height: 600px;
                background: radial-gradient(circle, rgba(220, 20, 60, 0.08) 0%, transparent 60%);
                border-radius: 50%;
                pointer-events: none;
                transform: translate(-50%, -50%);
                z-index: 1;
                opacity: 0;
                transition: opacity 1s ease;
            }
            .auth-brand {
                font-family: var(--font-display);
                font-size: 1.5rem; font-weight: 900;
                text-transform: uppercase; letter-spacing: -0.02em;
                color: #fff; margin-bottom: 2rem;
                text-align: center;
                text-decoration: none;
                display: block;
            }
            .auth-brand span { color: var(--color-gold); }
            
            /* Overriding Breeze Defaults */
            .auth-card label, .auth-card .text-gray-700 {
                display: block; font-size: 0.75rem !important; font-weight: 700 !important;
                text-transform: uppercase !important; letter-spacing: 0.12em !important;
                color: var(--color-on-surface-muted) !important; margin-bottom: 0.5rem !important;
            }
            .auth-card input[type="email"], .auth-card input[type="password"], .auth-card input[type="text"] {
                width: 100% !important;
                background: rgba(255,255,255,0.04) !important;
                border: 1px solid rgba(255,255,255,0.1) !important;
                border-radius: 8px !important; padding: 0.85rem 1rem !important;
                color: var(--color-on-surface) !important; font-size: 0.9rem !important;
                font-family: var(--font-body) !important;
                transition: border-color 0.2s ease, background 0.2s ease !important;
                outline: none !important; box-shadow: none !important;
            }
            .auth-card input:focus {
                border-color: var(--color-gold) !important;
                background: rgba(220,20,60,0.04) !important;
                box-shadow: none !important;
            }
            .auth-card button {
                width: 100% !important;
                padding: 0.9rem !important; border-radius: 6px !important;
                background: linear-gradient(135deg, var(--color-gold) 0%, var(--color-gold-dark) 100%) !important;
                color: #ffffff !important;
                font-family: var(--font-display) !important;
                font-size: 0.85rem !important; font-weight: 800 !important;
                text-decoration: none !important; text-transform: uppercase !important; letter-spacing: 0.1em !important;
                border: none !important; cursor: pointer !important; display: inline-block !important;
                transition: all 0.2s ease !important;
                box-shadow: 0 4px 20px rgba(220,20,60,0.35) !important;
            }
            .auth-card button:hover {
                background: linear-gradient(135deg, var(--color-gold-light) 0%, var(--color-gold) 100%) !important;
                box-shadow: 0 6px 32px rgba(220,20,60,0.55) !important;
            }
            .auth-card a, .auth-card .text-gray-600 {
                color: var(--color-on-surface-muted) !important; text-decoration: none !important; transition: color 0.2s !important;
                font-size: 0.8rem !important;
            }
            .auth-card a:hover { color: var(--color-gold) !important; }
            .auth-card .text-red-600 { color: #f87171 !important; }
            .auth-card .bg-green-600 { background: #4ade80 !important; }
        </style>
    </head>
    <body class="font-sans antialiased text-gray-100 bg-gray-900">
        <div class="auth-page">
            <div class="auth-card">
                <a href="/" class="auth-brand">Guard<span>You</span></a>
                {{ $slot }}
            </div>
            <!-- Interactive background glow -->
            <div class="pointer-glow" id="pointerGlow"></div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const card = document.querySelector('.auth-card');
                const glow = document.getElementById('pointerGlow');

                // 1. Entrance Animation
                // Memberikan delay kecil agar transisi terasa smooth saat halaman pertama dimuat
                setTimeout(() => {
                    if(card) card.classList.add('animate-in');
                    if(glow) glow.style.opacity = '1';
                }, 100);

                // 2. Mouse Tracker Animation (Interactive Holographic Background)
                document.addEventListener('mousemove', (e) => {
                    requestAnimationFrame(() => {
                        if(glow) {
                            glow.style.left = e.clientX + 'px';
                            glow.style.top = e.clientY + 'px';
                        }
                    });
                });
            });
        </script>
    </body>
</html>
