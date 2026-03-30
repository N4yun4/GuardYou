<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', 'GuardYou — Platform jasa bodyguard profesional terverifikasi. Pesan perlindungan personal kapan saja.')">
    <title>@yield('title', 'GuardYou') | Elite Protection</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Outfit:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --color-bg:               #080c14;
            --color-surface:          #0d1117;
            --color-surface-low:      #0d1117;
            --color-surface-container:#111827;
            --color-surface-high:     #1a2233;
            --color-surface-highest:  #1e2a3a;
            --color-border:           rgba(255,255,255,0.07);
            --color-on-surface:       #ffffff;
            --color-on-surface-muted: #8b9ab0;
            --color-on-surface-variant:#6b7a8d;
            --color-gold:             #DC143C;
            --color-gold-light:       #FF2D55;
            --color-gold-dark:        #B01030;
            --color-gold-bg:          rgba(220,20,60,0.1);
            --font-display: 'Outfit', sans-serif;
            --font-body:    'Inter', sans-serif;
        }
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            font-family: var(--font-body);
            background-color: var(--color-bg);
            color: var(--color-on-surface);
            -webkit-font-smoothing: antialiased;
            overflow-x: hidden;
            line-height: 1.6;
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: var(--font-display);
            letter-spacing: -0.02em;
            font-weight: 800;
            line-height: 1.1;
        }

        /* ── NAVBAR ── */
        .navbar {
            position: fixed; top: 0; left: 0; right: 0; z-index: 1000;
            display: flex; align-items: center; justify-content: space-between;
            padding: 1rem 3rem;
            background: rgba(8, 12, 20, 0.85);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border-bottom: 1px solid rgba(255,255,255,0.04);
            transition: background 0.3s ease, border-color 0.3s ease;
        }
        .navbar.scrolled {
            background: rgba(8, 12, 20, 0.97);
            border-bottom-color: rgba(255,255,255,0.08);
        }
        .navbar-brand {
            font-family: var(--font-display);
            font-size: 1.5rem; font-weight: 900;
            color: var(--color-on-surface);
            text-decoration: none; letter-spacing: -0.03em;
            text-transform: uppercase;
        }
        .navbar-brand span { color: var(--color-gold); }

        .navbar-links { display: flex; align-items: center; gap: 2rem; }
        .navbar-links a {
            font-size: 0.72rem; font-weight: 600;
            color: var(--color-on-surface-muted);
            text-decoration: none; letter-spacing: 0.08em;
            text-transform: uppercase;
            transition: color 0.2s ease;
        }
        .navbar-links a:hover { color: var(--color-on-surface); }

        .navbar-auth { display: flex; gap: 0.75rem; align-items: center; }

        /* ── BUTTONS ── */
        .btn-primary {
            padding: 0.65rem 1.5rem;
            border-radius: 6px;
            background: linear-gradient(135deg, var(--color-gold) 0%, var(--color-gold-dark) 100%);
            color: #ffffff;
            font-family: var(--font-display);
            font-size: 0.75rem; font-weight: 800;
            text-decoration: none; text-transform: uppercase; letter-spacing: 0.1em;
            border: none; cursor: pointer; display: inline-block;
            transition: all 0.2s ease;
            box-shadow: 0 4px 20px rgba(220,20,60,0.35);
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, var(--color-gold-light) 0%, var(--color-gold) 100%);
            box-shadow: 0 6px 32px rgba(220,20,60,0.55);
            transform: translateY(-1px);
        }
        .btn-primary:active { transform: translateY(0); }

        .btn-outline {
            padding: 0.65rem 1.5rem;
            border-radius: 6px;
            color: var(--color-on-surface);
            font-family: var(--font-display);
            font-size: 0.75rem; font-weight: 700;
            text-decoration: none; text-transform: uppercase; letter-spacing: 0.08em;
            background: transparent;
            border: 1px solid rgba(255,255,255,0.2);
            cursor: pointer; display: inline-block;
            transition: all 0.2s ease;
        }
        .btn-outline:hover {
            background: rgba(255,255,255,0.06);
            border-color: rgba(255,255,255,0.35);
        }

        .btn-lg {
            padding: 0.9rem 2rem;
            font-size: 0.8rem;
        }

        /* ── SHARED UTILITY ── */
        .eyebrow {
            display: inline-flex; align-items: center; gap: 0.75rem;
            font-size: 0.68rem; font-weight: 700; text-transform: uppercase;
            letter-spacing: 0.25em; color: var(--color-gold);
            margin-bottom: 1.25rem;
        }
        .eyebrow::before {
            content: ''; width: 28px; height: 1.5px;
            background: var(--color-gold); border-radius: 1px;
        }

        .section-title {
            font-size: clamp(1.8rem, 3vw, 2.5rem);
            font-weight: 900; color: var(--color-on-surface);
        }
        .section-title span { color: var(--color-gold); }

        .section-label {
            font-size: 0.65rem; font-weight: 800; text-transform: uppercase;
            letter-spacing: 0.25em; color: var(--color-gold);
            margin-bottom: 2rem; display: block;
        }
        .hero-label { /* alias */
            display: inline-flex; align-items: center; gap: 0.75rem;
            font-size: 0.68rem; font-weight: 700; text-transform: uppercase;
            letter-spacing: 0.25em; color: var(--color-gold);
        }
        .hero-label::before {
            content: ''; width: 28px; height: 1.5px;
            background: var(--color-gold); border-radius: 1px;
        }
        .sidebar-label {
            font-size: 0.65rem; font-weight: 800; text-transform: uppercase;
            letter-spacing: 0.25em; color: var(--color-gold);
            margin-bottom: 1.5rem; display: block;
        }
        .entry-label {
            font-size: 0.6rem; font-weight: 700; text-transform: uppercase;
            letter-spacing: 0.18em; color: var(--color-gold); display: block;
        }
        .strip-lbl {
            font-size: 0.6rem; font-weight: 700; text-transform: uppercase;
            letter-spacing: 0.18em; color: var(--color-on-surface-muted); display: block;
        }
        .strip-val {
            font-size: 1rem; font-weight: 800; color: var(--color-on-surface);
        }
        .text-muted { color: var(--color-on-surface-muted); }

        /* ── CARDS ── */
        .card {
            background: var(--color-surface-container);
            border: 1px solid var(--color-border);
            border-radius: 12px;
            padding: 2rem;
            transition: border-color 0.2s ease, transform 0.2s ease;
        }
        .card:hover {
            border-color: rgba(220,20,60,0.25);
            transform: translateY(-3px);
        }

        /* ── AVATAR PLACEHOLDER ── */
        .avatar-placeholder {
            width: 100%; height: 100%;
            display: flex; align-items: center; justify-content: center;
            font-family: var(--font-display);
            font-weight: 900; color: rgba(220,20,60,0.35);
            background: linear-gradient(135deg, #111827 0%, #0d1117 100%);
            user-select: none;
        }

        /* ── STATUS BADGES ── */
        .badge {
            display: inline-flex; align-items: center; gap: 0.3rem;
            padding: 0.3rem 0.75rem; border-radius: 20px;
            font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em;
        }
        .badge-pending   { background:rgba(220,20,60,0.1);  color:var(--color-gold); border:1px solid rgba(220,20,60,0.2); }
        .badge-paid      { background:rgba(34,197,94,0.1);  color:#4ade80; border:1px solid rgba(34,197,94,0.2); }
        .badge-active    { background:rgba(96,165,250,0.1); color:#60a5fa; border:1px solid rgba(96,165,250,0.2); }
        .badge-completed { background:rgba(148,163,184,0.1);color:#94a3b8; border:1px solid rgba(148,163,184,0.2); }
        .badge-cancelled { background:rgba(248,113,113,0.1);color:#f87171; border:1px solid rgba(248,113,113,0.2); }

        /* ── ALERTS ── */
        .alert { padding: 0.9rem 1.2rem; border-radius: 8px; font-size: 0.875rem; margin-bottom: 1.5rem; }
        .alert-success { background:rgba(34,197,94,0.08); border:1px solid rgba(34,197,94,0.2); color:#4ade80; }
        .alert-warning { background:rgba(220,20,60,0.08); border:1px solid rgba(220,20,60,0.2); color:var(--color-gold); }
        .alert-danger  { background:rgba(248,113,113,0.08); border:1px solid rgba(248,113,113,0.2); color:#f87171; }

        /* ── FOOTER ── */
        .site-footer {
            background: #050810;
            padding: 4rem 3rem 2rem;
            border-top: 1px solid rgba(255,255,255,0.04);
            margin-top: 6rem;
        }
        .footer-grid {
            display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; gap: 3rem;
            max-width: 1200px; margin: 0 auto;
        }
        .footer-brand-name {
            font-family: var(--font-display);
            font-size: 1.3rem; font-weight: 900;
            text-transform: uppercase; letter-spacing: -0.03em;
            margin-bottom: 0.75rem;
        }
        .footer-brand-name span { color: var(--color-gold); }
        .footer-tagline { color: var(--color-on-surface-muted); font-size: 0.875rem; line-height: 1.7; max-width: 280px; }
        .footer-col h4 {
            color: var(--color-on-surface-muted);
            font-size: 0.65rem; text-transform: uppercase; letter-spacing: 0.15em;
            margin-bottom: 1.25rem; font-weight: 700;
        }
        .footer-col ul { list-style: none; }
        .footer-col ul li { margin-bottom: 0.65rem; }
        .footer-col ul li a {
            color: var(--color-on-surface-variant); font-size: 0.85rem;
            text-decoration: none; transition: color 0.2s;
        }
        .footer-col ul li a:hover { color: var(--color-on-surface); }
        .footer-bottom {
            max-width: 1200px; margin: 3rem auto 0;
            padding-top: 1.5rem; border-top: 1px solid rgba(255,255,255,0.05);
            display: flex; justify-content: space-between; align-items: center;
            color: var(--color-on-surface-variant); font-size: 0.75rem; gap: 1rem; flex-wrap: wrap;
        }
        .footer-bottom a { color: inherit; text-decoration: none; transition: color 0.2s; }
        .footer-bottom a:hover { color: var(--color-on-surface); }

        /* ── SCROLLBAR ── */
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: var(--color-bg); }
        ::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: rgba(220,20,60,0.4); }
    </style>
    @stack('styles')
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar" id="mainNav">
        <a href="{{ url('/') }}" class="navbar-brand">Guard<span>You</span></a>

        <div class="navbar-links">
            <a href="{{ url('/') }}">Home</a>
            <a href="{{ route('bodyguards.index') }}">Find Bodyguard</a>
            @auth
                @if(auth()->user()->role === 'user')
                    <a href="{{ route('bookings.index') }}">Booking Saya</a>
                @endif
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}">Admin</a>
                @endif
            @endauth
        </div>

        <div class="navbar-auth">
            @auth
                <div style="display:flex; align-items:center; gap:1rem;">
                    <a href="{{ route('dashboard') }}" style="color:var(--color-on-surface-muted); font-size:0.72rem; font-weight:600; letter-spacing:0.05em; text-decoration:none; text-transform:uppercase;">{{ auth()->user()->name }}</a>
                    <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                        @csrf
                        <button type="submit" class="btn-outline" style="padding:0.5rem 1rem;">Keluar</button>
                    </form>
                </div>
            @else
                <a href="{{ route('login') }}" class="btn-outline">Login</a>
                <a href="{{ route('register') }}" class="btn-primary">Sign Up</a>
            @endauth
        </div>
    </nav>

    <!-- PAGE CONTENT -->
    <main style="padding-top: 72px;">
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="site-footer">
        <div class="footer-grid">
            <div>
                <div class="footer-brand-name">Guard<span>You</span></div>
                <p class="footer-tagline">Platform jasa bodyguard profesional terverifikasi. Perlindungan personal terpercaya untuk ketenangan pikiran Anda.</p>
            </div>
            <div class="footer-col">
                <h4>Layanan</h4>
                <ul>
                    <li><a href="{{ route('bodyguards.index') }}">Find Bodyguard</a></li>
                    <li><a href="{{ route('register') }}">Daftar Bodyguard</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Perusahaan</h4>
                <ul>
                    <li><a href="#">Tentang Kami</a></li>
                    <li><a href="#">FAQ</a></li>
                    <li><a href="#">Kontak</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Legal</h4>
                <ul>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Terms of Service</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <div>&copy; {{ date('Y') }} GuardYou. The Guardian Seal of Personal Protection.</div>
            <div style="display:flex; gap:1.5rem;">
                <a href="#">Contact</a>
                <a href="#">Privacy Policy</a>
                <a href="#">Terms of Service</a>
                <a href="#">FAQ</a>
            </div>
        </div>
    </footer>

    <script>
        const nav = document.getElementById('mainNav');
        window.addEventListener('scroll', () => {
            nav.classList.toggle('scrolled', window.scrollY > 40);
        });
    </script>
    @stack('scripts')
</body>
</html>
