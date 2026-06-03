<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Audit System')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --as-bg: #eef2f7;
            --as-ink: #172033;
            --as-muted: #6b7280;
            --as-panel: #ffffff;
            --as-line: #e5e9f2;
            --as-sidebar: #111827;
            --as-sidebar-2: #1f2937;
            --as-teal: #0f766e;
            --as-blue: #2563eb;
            --as-amber: #d97706;
            --as-rose: #e11d48;
        }

        body {
            background: var(--as-bg);
            color: var(--as-ink);
            font-size: 14px;
        }

        .app-shell {
            min-height: 100vh;
            background:
                radial-gradient(circle at top left, rgba(37, 99, 235, .10), transparent 28rem),
                linear-gradient(180deg, #f8fafc 0%, var(--as-bg) 42%);
        }

        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, var(--as-sidebar) 0%, #151c2b 100%);
            border-right: 1px solid rgba(255, 255, 255, .08);
        }

        .brand-mark {
            width: 42px;
            height: 42px;
            display: grid;
            place-items: center;
            border-radius: .75rem;
            background: linear-gradient(135deg, var(--as-teal), var(--as-blue));
            box-shadow: 0 14px 28px rgba(15, 118, 110, .24);
        }

        .sidebar-label {
            color: #7dd3fc;
            font-size: .72rem;
            letter-spacing: .08em;
            text-transform: uppercase;
        }

        .sidebar .nav-link {
            color: #cbd5e1;
            border-radius: .6rem;
            padding: .72rem .85rem;
            display: flex;
            align-items: center;
            gap: .7rem;
            font-weight: 500;
        }

        .sidebar .nav-link i {
            width: 1.25rem;
            text-align: center;
        }

        .sidebar .nav-link.active,
        .sidebar .nav-link:hover {
            background: rgba(255, 255, 255, .10);
            color: #ffffff;
        }

        .content-shell { min-height: 100vh; }

        .topbar {
            min-height: 72px;
            background: rgba(255, 255, 255, .86);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--as-line);
        }

        .page-title {
            font-size: 1.18rem;
            font-weight: 700;
        }

        .user-chip {
            border: 1px solid var(--as-line);
            background: #f8fafc;
            border-radius: 999px;
            padding: .38rem .7rem;
            color: #334155;
        }

        .content-area {
            padding: 1.5rem;
        }

        .enterprise-card,
        .table-card,
        .stat-card {
            background: var(--as-panel);
            border: 1px solid var(--as-line);
            border-radius: .8rem;
            box-shadow: 0 16px 40px rgba(15, 23, 42, .07);
        }

        .stat-card {
            overflow: hidden;
            position: relative;
        }

        .stat-card::after {
            content: "";
            position: absolute;
            inset: auto 0 0;
            height: 3px;
            background: var(--accent, var(--as-teal));
        }

        .stat-icon {
            width: 46px;
            height: 46px;
            display: grid;
            place-items: center;
            border-radius: .75rem;
            color: #fff;
            background: var(--accent, var(--as-teal));
        }

        .metric-label {
            color: var(--as-muted);
            font-size: .78rem;
            font-weight: 700;
            letter-spacing: .06em;
            text-transform: uppercase;
        }

        .metric-value {
            font-size: 2rem;
            line-height: 1;
            font-weight: 800;
        }

        .section-title {
            font-size: .98rem;
            font-weight: 700;
        }

        .table > :not(caption) > * > * {
            padding: .9rem 1rem;
            border-color: var(--as-line);
        }

        .table thead th {
            color: #64748b;
            font-size: .75rem;
            letter-spacing: .06em;
            text-transform: uppercase;
            font-weight: 800;
        }

        .btn {
            border-radius: .55rem;
            font-weight: 600;
        }

        .form-control,
        .form-select {
            border-radius: .55rem;
            border-color: #d8deea;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--as-blue);
            box-shadow: 0 0 0 .2rem rgba(37, 99, 235, .14);
        }

        .timeline-dot {
            width: .7rem;
            height: .7rem;
            border-radius: 50%;
            background: var(--as-teal);
            box-shadow: 0 0 0 .25rem rgba(15, 118, 110, .12);
            flex: 0 0 auto;
            margin-top: .35rem;
        }

        @media (max-width: 991.98px) {
            .sidebar { min-height: auto; }
            .content-area { padding: 1rem; }
        }
    </style>
</head>
<body>
@auth
    <div class="container-fluid app-shell">
        <div class="row">
            <aside class="col-lg-2 sidebar p-3">
                <a class="d-flex align-items-center gap-3 text-white text-decoration-none mb-4" href="{{ route('dashboard') }}">
                    <span class="brand-mark"><i class="bi bi-shield-lock-fill fs-4"></i></span>
                    <span>
                        <span class="d-block fw-bold">Audit System</span>
                        <small class="text-white-50">Security Console</small>
                    </span>
                </a>
                <div class="sidebar-label mb-2">Navigation</div>
                <nav class="nav flex-column gap-1">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}"><i class="bi bi-grid-1x2-fill"></i>Dashboard</a>
                    <a class="nav-link {{ request()->routeIs('donnees.*') ? 'active' : '' }}" href="{{ route('donnees.index') }}"><i class="bi bi-database-fill-lock"></i>Données</a>
                    @if(auth()->user()->isAdmin())
                        <a class="nav-link {{ request()->routeIs('utilisateurs.*') ? 'active' : '' }}" href="{{ route('utilisateurs.index') }}"><i class="bi bi-people-fill"></i>Utilisateurs</a>
                        <a class="nav-link {{ request()->routeIs('audit.*') ? 'active' : '' }}" href="{{ route('audit.index') }}"><i class="bi bi-activity"></i>Audit</a>
                    @endif
                </nav>
                <div class="enterprise-card mt-4 p-3 border-0" style="background: rgba(255,255,255,.08); color: #e2e8f0;">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <i class="bi bi-check-circle-fill text-info"></i>
                        <span class="fw-semibold">Système actif</span>
                    </div>
                    <small class="text-white-50">Surveillance des actions utilisateurs en temps réel.</small>
                </div>
            </aside>
            <main class="col-lg-10 content-shell px-0">
                <nav class="navbar navbar-expand topbar px-4">
                    <div>
                        <span class="page-title">@yield('title', 'Dashboard')</span>
                        <div class="text-muted small">Contrôle des accès, données et activités sensibles</div>
                    </div>
                    <div class="ms-auto d-flex align-items-center gap-3">
                        <span class="user-chip"><i class="bi bi-person-circle me-1"></i>{{ auth()->user()->name }} · {{ auth()->user()->role }}</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="btn btn-outline-danger btn-sm"><i class="bi bi-box-arrow-right me-1"></i>Déconnexion</button>
                        </form>
                    </div>
                </nav>
                <div class="content-area">
                    @include('partials.alerts')
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
@else
    @yield('content')
@endauth
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
