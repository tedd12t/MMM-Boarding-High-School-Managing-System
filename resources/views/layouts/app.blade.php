<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'MMM Boarding High School Managing System') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <style>
        :root {
            --sidebar-width: 260px;
            --navbar-height: 70px;
            --primary-blue: #2563eb;
        }
        body {
            
            background-color: #020617 !important; 
            color: #ffffff;
            margin: 0;
        }

        .navbar {
            height: var(--navbar-height);
            position: fixed;
            top: 0; left: 0; width: 100%;
            z-index: 1050;
            background: #0f172a !important; 
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            padding: 0 20px;
        }
        .nav-user-profile, 
        .nav-user-profile:focus, 
        .nav-user-profile:active,
        .show > .nav-link {
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
            color: #ffffff !important;
            font-weight: 600;
            display: flex;
            align-items: center;
        }

        .role-badge {
            background: var(--primary-blue);
            color: white;
            text-transform: uppercase;
            font-size: 0.65rem;
            font-weight: 800;
            padding: 3px 10px;
            border-radius: 4px;
            margin-right: 10px;
        }
        .dropdown-menu {
            background: #1e293b; 
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 10px 25px rgba(0,0,0,0.5);
            border-radius: 8px;
            margin-top: 10px !important;
        }

        .dropdown-item {
            color: #cbd5e1;
            padding: 10px 20px;
        }

        .dropdown-item:hover {
            background: var(--primary-blue);
            color: white;
        }
        .sidebar-wrapper {
            position: fixed;
            top: var(--navbar-height);
            left: 0;
            width: var(--sidebar-width);
            height: calc(100vh - var(--navbar-height));
            background: #0f172a !important;
            border-right: 1px solid rgba(255, 255, 255, 0.05);
            z-index: 1000;
        }
        @media (min-width: 992px) {
            main {
                margin-left: var(--sidebar-width) !important;
                width: calc(100% - var(--sidebar-width)) !important;
                padding-top: calc(var(--navbar-height) + 20px) !important;
                display: block !important;
            }

            .container, .container-fluid {
                max-width: 100% !important;
                margin-left: 0 !important;
                padding-left: 20px !important;
                padding-right: 30px !important;
            }
        }

        .dashboard-hero, .stat-card, .card {
            background: #1e293b !important; 
            border: 1px solid #334155 !important;
            backdrop-filter: none !important;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.2) !important;
            color: #ffffff !important;
        }

        .card-body {
            background: #ffffff !important;
            color: #1e293b !important;
            border-radius: 0 0 12px 12px;
        }

        .fc-theme-standard td, .fc-theme-standard th {
            border: 1px solid #e2e8f0 !important;
        }
        #app {
            display: flex;
            flex-direction: column;
            min-height: 100vh; /* Full height of the screen */
        }

        main {
            flex: 1 0 auto; /* This area grows to fill space, pushing footer down */
        }

        footer, .footer-content {
            flex-shrink: 0; /* Prevents footer from squishing */
            padding: 30px 0;
            width: 100%;
            background-color: transparent;
        }

        /* Optional: Styling for the footer text to make it look premium */
        .footer-text {
            font-size: 0.85rem;
            font-style: italic;
            color: #94a3b8 !important;
            letter-spacing: 1px;
        }
        .row.g-0 {
            margin: 0 !important;
        }

        .left-menu-container {
            padding-right: 0 !important;
            border-right: none !important; /* Removes any border that creates a visible gap */
        }

        /* Add a small padding inside the content so text isn't touching the sidebar */
        .dashboard-hero, .stat-card, .section-card {
            margin-left: 20px !important; 
        }
    </style>
</head>
<body>
    <div class="app-bg-wrapper">
        <div class="app-bg-photo"></div>
        <div class="app-bg-grid"></div>
    </div>

    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark">
            <div class="container-fluid px-4">
                <a class="navbar-brand fw-bold" href="{{ url('/') }}">
                    <i class="bi bi-mortarboard-fill text-primary me-2"></i>
                    <span class="d-none d-lg-inline">Maychew Martyrs Memorial Boarding High School</span>
                    <span class="d-lg-none">MMM Boarding High School</span>
                </a>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    
                    <ul class="navbar-nav ms-auto align-items-center">
                        @guest
                            <li class="nav-item"><a class="btn btn-primary btn-sm px-4" href="{{ route('login') }}">Login</a></li>
                        @else
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle nav-user-profile" href="#" data-bs-toggle="dropdown">
                                    <span class="badge bg-primary me-2">{{ Auth::user()->role }}</span>
                                    {{ Auth::user()->first_name }}
                                </a>
                                <div class="dropdown-menu dropdown-menu-end shadow-lg border-0">
                                    <div class="px-3 py-2 border-bottom mb-2">
                                        <small class="text-muted d-block" style="font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px;">Authorized Account: </small>
                                        <span class="fw-bold text-dark">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</span>
                                    </div>
                                    <a class="dropdown-item py-2" href="{{route('password.edit')}}">
                                        <i class="bi bi-shield-lock-fill text-primary me-2"></i> Settings
                                    </a>
    
                                    <hr class="dropdown-divider opacity-5">
    
                                    <!-- Logout Link -->
                                    <a class="dropdown-item text-danger py-2" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="bi bi-power me-2"></i> Log Out
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main>
            @yield('content')
        </main>
    </div>
</body>
</html>
