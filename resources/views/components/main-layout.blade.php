<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="TUKAC - Technical University of Kenya Ability Club. A community for students with disabilities.">
    <title>{{ isset($title) ? $title . ' — TUKAC' : 'TUKAC — Technical University of Kenya Ability Club' }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-primary: #0d0d1a;
            --bg-secondary: #12122a;
            --bg-card: rgba(255,255,255,0.04);
            --border-glow: rgba(99,102,241,0.3);
            --indigo: #6366f1;
            --purple: #8b5cf6;
            --emerald: #10b981;
            --text-primary: #f1f5f9;
            --text-muted: #94a3b8;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-primary);
            color: var(--text-primary);
            min-height: 100vh;
        }

        /* Navbar */
        .navbar {
            position: sticky; top: 0; z-index: 100;
            background: rgba(13,13,26,0.85);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--border-glow);
            padding: 0 2rem;
            display: flex; align-items: center; justify-content: space-between;
            height: 68px;
        }
        .navbar-brand { display: flex; align-items: center; gap: 12px; text-decoration: none; }
        .navbar-logo {
            width: 42px; height: 42px;
            background: linear-gradient(135deg, var(--indigo), var(--purple));
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-weight: 900; font-size: 16px; color: white;
            box-shadow: 0 0 20px rgba(99,102,241,0.4);
        }
        .navbar-title { font-weight: 800; font-size: 1.1rem; color: white; line-height: 1.2; }
        .navbar-subtitle { font-size: 0.65rem; color: var(--text-muted); font-weight: 400; }
        .navbar-links { display: flex; align-items: center; gap: 4px; }
        .navbar-links a {
            padding: 8px 14px; border-radius: 8px;
            color: var(--text-muted); font-weight: 500; font-size: 0.875rem;
            text-decoration: none; transition: all 0.2s;
        }
        .navbar-links a:hover, .navbar-links a.active { color: white; background: rgba(99,102,241,0.15); }
        .btn-nav-login {
            padding: 8px 18px; border-radius: 8px;
            background: transparent; border: 1px solid var(--border-glow);
            color: var(--indigo); font-weight: 600; font-size: 0.875rem;
            text-decoration: none; transition: all 0.2s;
        }
        .btn-nav-login:hover { background: rgba(99,102,241,0.1); }
        .btn-nav-register {
            padding: 8px 18px; border-radius: 8px;
            background: linear-gradient(135deg, var(--indigo), var(--purple));
            color: white; font-weight: 600; font-size: 0.875rem;
            text-decoration: none; transition: all 0.2s;
            box-shadow: 0 4px 15px rgba(99,102,241,0.35);
        }
        .btn-nav-register:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(99,102,241,0.45); }
        .navbar-user { display: flex; align-items: center; gap: 10px; }
        .user-avatar {
            width: 36px; height: 36px; border-radius: 50%;
            background: linear-gradient(135deg, var(--indigo), var(--purple));
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 13px; color: white;
        }
        .dropdown { position: relative; }
        .dropdown-menu {
            position: absolute; right: 0; top: calc(100% + 8px);
            background: #1a1a3e; border: 1px solid var(--border-glow);
            border-radius: 12px; padding: 8px; min-width: 180px;
            display: none; z-index: 200;
            box-shadow: 0 20px 40px rgba(0,0,0,0.4);
        }
        .dropdown:hover .dropdown-menu { display: block; }
        .dropdown-menu a, .dropdown-menu button {
            display: block; width: 100%; text-align: left;
            padding: 9px 14px; border-radius: 8px;
            color: var(--text-muted); font-size: 0.875rem;
            text-decoration: none; background: none; border: none;
            cursor: pointer; transition: all 0.2s;
        }
        .dropdown-menu a:hover, .dropdown-menu button:hover { background: rgba(99,102,241,0.15); color: white; }
        .dropdown-divider { border: none; border-top: 1px solid var(--border-glow); margin: 6px 0; }

        /* Mobile */
        .hamburger { display: none; flex-direction: column; gap: 5px; cursor: pointer; background: none; border: none; }
        .hamburger span { display: block; width: 24px; height: 2px; background: var(--text-muted); border-radius: 2px; }
        .mobile-menu { display: none; }

        @media (max-width: 768px) {
            .navbar-links { display: none; }
            .hamburger { display: flex; }
            .mobile-menu {
                position: fixed; top: 68px; left: 0; right: 0; z-index: 99;
                background: rgba(13,13,26,0.97); backdrop-filter: blur(16px);
                border-bottom: 1px solid var(--border-glow);
                padding: 1rem;
            }
            .mobile-menu.open { display: block; }
            .mobile-menu a {
                display: block; padding: 12px 16px; border-radius: 8px;
                color: var(--text-muted); font-size: 0.9rem; text-decoration: none;
                transition: all 0.2s;
            }
            .mobile-menu a:hover { background: rgba(99,102,241,0.15); color: white; }
        }

        /* Flash messages */
        .flash { padding: 12px 20px; border-radius: 10px; margin-bottom: 1rem; font-size: 0.875rem; font-weight: 500; }
        .flash-success { background: rgba(16,185,129,0.15); border: 1px solid rgba(16,185,129,0.3); color: #34d399; }
        .flash-error   { background: rgba(239,68,68,0.15);  border: 1px solid rgba(239,68,68,0.3);  color: #f87171; }

        /* Footer */
        footer {
            background: var(--bg-secondary);
            border-top: 1px solid var(--border-glow);
            padding: 3rem 2rem 1.5rem;
            margin-top: 5rem;
        }
        .footer-grid { display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 2rem; max-width: 1100px; margin: 0 auto; }
        .footer-logo-wrap { display: flex; align-items: center; gap: 12px; margin-bottom: 1rem; }
        .footer-desc { color: var(--text-muted); font-size: 0.875rem; line-height: 1.7; }
        .footer-title { color: white; font-weight: 700; font-size: 0.875rem; margin-bottom: 1rem; text-transform: uppercase; letter-spacing: 0.5px; }
        .footer-links a { display: block; color: var(--text-muted); font-size: 0.875rem; text-decoration: none; margin-bottom: 8px; transition: color 0.2s; }
        .footer-links a:hover { color: var(--indigo); }
        .footer-bottom { max-width: 1100px; margin: 2rem auto 0; padding-top: 1.5rem; border-top: 1px solid rgba(99,102,241,0.15); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; }
        .footer-bottom p { color: var(--text-muted); font-size: 0.8rem; }

        @media (max-width: 768px) {
            .footer-grid { grid-template-columns: 1fr; }
            .footer-bottom { flex-direction: column; text-align: center; }
        }

        /* Utility */
        .container { max-width: 1100px; margin: 0 auto; padding: 0 1.5rem; }
        .section { padding: 4rem 0; }
        .badge { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; }
        .badge-indigo { background: rgba(99,102,241,0.2); color: #818cf8; border: 1px solid rgba(99,102,241,0.3); }
        .badge-emerald { background: rgba(16,185,129,0.2); color: #34d399; border: 1px solid rgba(16,185,129,0.3); }
        .badge-red { background: rgba(239,68,68,0.2); color: #f87171; border: 1px solid rgba(239,68,68,0.3); }
        .badge-yellow { background: rgba(245,158,11,0.2); color: #fbbf24; border: 1px solid rgba(245,158,11,0.3); }
        .card {
            background: var(--bg-card);
            border: 1px solid var(--border-glow);
            border-radius: 16px; padding: 1.5rem;
            backdrop-filter: blur(10px);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .card:hover { transform: translateY(-3px); box-shadow: 0 12px 40px rgba(99,102,241,0.15); }
        .btn {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 10px 22px; border-radius: 10px;
            font-weight: 600; font-size: 0.875rem;
            text-decoration: none; border: none; cursor: pointer;
            transition: all 0.2s;
        }
        .btn-primary {
            background: linear-gradient(135deg, var(--indigo), var(--purple));
            color: white; box-shadow: 0 4px 15px rgba(99,102,241,0.35);
        }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(99,102,241,0.45); }
        .btn-outline { border: 1px solid var(--border-glow); color: var(--indigo); background: transparent; }
        .btn-outline:hover { background: rgba(99,102,241,0.1); }
        .btn-danger { background: rgba(239,68,68,0.15); color: #f87171; border: 1px solid rgba(239,68,68,0.3); }
        .btn-danger:hover { background: rgba(239,68,68,0.25); }
        .btn-success { background: rgba(16,185,129,0.15); color: #34d399; border: 1px solid rgba(16,185,129,0.3); }
        .btn-success:hover { background: rgba(16,185,129,0.25); }
        .page-header {
            background: linear-gradient(135deg, rgba(99,102,241,0.1), rgba(139,92,246,0.05));
            border-bottom: 1px solid var(--border-glow);
            padding: 3rem 0 2rem;
        }
        .page-header h1 { font-size: 2rem; font-weight: 800; color: white; }
        .page-header p { color: var(--text-muted); margin-top: 0.5rem; }
        .fade-up { opacity: 0; transform: translateY(30px); transition: opacity 0.6s ease, transform 0.6s ease; }
        .fade-up.visible { opacity: 1; transform: translateY(0); }
    </style>
</head>
<body>

<!-- ── Navbar ─────────────────────────────────────────────── -->
<nav class="navbar" role="navigation" aria-label="Main navigation">
    <a href="{{ route('home') }}" class="navbar-brand">
        <div class="navbar-logo">TK</div>
        <div>
            <div class="navbar-title">TUKAC</div>
            <div class="navbar-subtitle">Ability Club</div>
        </div>
    </a>

    <div class="navbar-links">
        <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
        <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">About</a>
        <a href="{{ route('events.index') }}" class="{{ request()->routeIs('events.*') ? 'active' : '' }}">Events</a>
        <a href="{{ route('blog.index') }}" class="{{ request()->routeIs('blog.*') ? 'active' : '' }}">Blog</a>
        <a href="{{ route('constitution') }}" class="{{ request()->routeIs('constitution') ? 'active' : '' }}">Constitution</a>
        @auth
            <a href="{{ route('members.index') }}" class="{{ request()->routeIs('members.*') ? 'active' : '' }}">Members</a>
            <a href="{{ route('attendance.index') }}" class="{{ request()->routeIs('attendance.*') ? 'active' : '' }}">Attendance</a>
        @endauth
    </div>

    <div style="display:flex;align-items:center;gap:10px;">
        @auth
            <div class="dropdown">
                <div style="display:flex;align-items:center;gap:10px;cursor:pointer;">
                    <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                    <span style="color:var(--text-muted);font-size:0.875rem;">{{ Str::words(auth()->user()->name, 1, '') }}</span>
                    <span style="color:var(--text-muted);">▾</span>
                </div>
                <div class="dropdown-menu">
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}">⚙️ Admin Panel</a>
                        <div class="dropdown-divider"></div>
                    @endif
                    <a href="{{ route('profile.edit') }}">👤 My Profile</a>
                    <a href="{{ route('attendance.mine') }}">📋 My Attendance</a>
                    <div class="dropdown-divider"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit">🚪 Sign Out</button>
                    </form>
                </div>
            </div>
        @else
            <a href="{{ route('login') }}" class="btn-nav-login">Login</a>
            <a href="{{ route('register') }}" class="btn-nav-register">Join Club</a>
        @endauth

        <button class="hamburger" id="hamburger" aria-label="Toggle menu">
            <span></span><span></span><span></span>
        </button>
    </div>
</nav>

<!-- Mobile Menu -->
<div class="mobile-menu" id="mobileMenu">
    <a href="{{ route('home') }}">🏠 Home</a>
    <a href="{{ route('about') }}">ℹ️ About</a>
    <a href="{{ route('events.index') }}">📅 Events</a>
    <a href="{{ route('blog.index') }}">📰 Blog</a>
    <a href="{{ route('constitution') }}">📜 Constitution</a>
    @auth
        <a href="{{ route('members.index') }}">👥 Members</a>
        <a href="{{ route('attendance.index') }}">✅ Attendance</a>
        @if(auth()->user()->isAdmin())
            <a href="{{ route('admin.dashboard') }}">⚙️ Admin Panel</a>
        @endif
        <form method="POST" action="{{ route('logout') }}" style="margin-top:8px;">
            @csrf
            <button style="width:100%;text-align:left;padding:12px 16px;border-radius:8px;background:rgba(239,68,68,0.1);border:none;color:#f87171;cursor:pointer;font-size:0.9rem;">🚪 Sign Out</button>
        </form>
    @else
        <a href="{{ route('login') }}" style="margin-top:8px;">🔑 Login</a>
        <a href="{{ route('register') }}">✨ Join Club</a>
    @endauth
</div>

<!-- ── Flash Messages ──────────────────────────────────────── -->
@if(session('success') || session('error'))
<div class="container" style="padding-top:1rem;">
    @if(session('success'))
        <div class="flash flash-success">✅ {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="flash flash-error">❌ {{ session('error') }}</div>
    @endif
</div>
@endif

<!-- ── Main Content ──────────────────────────────────────────── -->
<main id="main-content">
    {{ $slot }}
</main>

<!-- ── Footer ───────────────────────────────────────────────── -->
<footer>
    <div class="footer-grid">
        <div class="footer-brand">
            <div class="footer-logo-wrap">
                <div class="navbar-logo">TK</div>
                <div>
                    <div style="font-weight:800;color:white;">TUKAC</div>
                    <div style="font-size:0.7rem;color:var(--text-muted);">Technical University of Kenya Ability Club</div>
                </div>
            </div>
            <p class="footer-desc">Empowering students with disabilities at TUK. Together we learn, grow, and achieve beyond barriers.</p>
        </div>
        <div>
            <div class="footer-title">Quick Links</div>
            <div class="footer-links">
                <a href="{{ route('home') }}">Home</a>
                <a href="{{ route('about') }}">About Us</a>
                <a href="{{ route('events.index') }}">Events</a>
                <a href="{{ route('blog.index') }}">Blog</a>
                <a href="{{ route('constitution') }}">Constitution</a>
            </div>
        </div>
        <div>
            <div class="footer-title">Account</div>
            <div class="footer-links">
                @auth
                    <a href="{{ route('members.index') }}">Members List</a>
                    <a href="{{ route('attendance.index') }}">Attendance</a>
                    <a href="{{ route('profile.edit') }}">My Profile</a>
                @else
                    <a href="{{ route('login') }}">Login</a>
                    <a href="{{ route('register') }}">Register</a>
                @endauth
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <p>© {{ date('Y') }} TUKAC — Technical University of Kenya Ability Club. All rights reserved.</p>
        <p>Built with ❤️ using PHP, Java, JS, HTML & CSS</p>
    </div>
</footer>

<script>
    const hamburger  = document.getElementById('hamburger');
    const mobileMenu = document.getElementById('mobileMenu');
    hamburger.addEventListener('click', () => mobileMenu.classList.toggle('open'));

    const fadeEls = document.querySelectorAll('.fade-up');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) { entry.target.classList.add('visible'); observer.unobserve(entry.target); }
        });
    }, { threshold: 0.1 });
    fadeEls.forEach(el => observer.observe(el));
</script>
</body>
</html>
