<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>MMM Academy | Portal</title>

    <!-- Google Fonts & Bootstrap Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    <!-- Scripts & Styles -->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <style>
        :root {
            --sidebar-width: 260px;
            --navbar-height: 70px;
            --primary-blue: #2563eb;
            --dark-navy: #0f172a;
            --deep-bg: #020617;
        }

        body {
            font-family: 'Inter', sans-serif !important;
            background-color: var(--deep-bg) !important;
            color: #ffffff;
            margin: 0; padding: 0;
            overflow-x: hidden;
        }

        /* --- GLOBAL ANIMATED BACKGROUND --- */
        .app-bg-wrapper {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            z-index: -1; background: var(--deep-bg);
        }
        .app-bg-photo {
            position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            background: linear-gradient(rgba(2, 6, 23, 0.85), rgba(2, 6, 23, 0.95)), 
                        url("{{ asset('images/school-photo.jpg') }}"); 
            background-size: cover; background-position: center;
            animation: slowZoom 30s infinite alternate;
        }
        .app-bg-grid {
            position: absolute; width: 200%; height: 200%; top: -50%; left: -50%;
            background-image: linear-gradient(rgba(37, 99, 235, 0.1) 1px, transparent 1px),
                              linear-gradient(90deg, rgba(37, 99, 235, 0.1) 1px, transparent 1px);
            background-size: 80px 80px;
            transform: perspective(500px) rotateX(60deg);
            animation: tunnelMove 20s linear infinite;
        }
        @keyframes tunnelMove { 0% { transform: perspective(500px) rotateX(60deg) translateY(0); } 100% { transform: perspective(500px) rotateX(60deg) translateY(80px); } }
        @keyframes slowZoom { from { transform: scale(1); } to { transform: scale(1.1); } }

        /* --- TOP NAVBAR --- */
        .navbar {
            height: var(--navbar-height);
            position: fixed; top: 0; left: 0; width: 100%;
            z-index: 1050; background: var(--dark-navy) !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            padding: 0 20px;
        }
        .navbar-brand { font-weight: 700; font-size: 0.95rem; text-transform: uppercase; color: white !important; }
        .navbar-brand i { color: var(--primary-blue); font-size: 1.5rem; margin-right: 10px; }

        /* User Profile Toggle */
        .nav-user-profile, .nav-user-profile:focus, .nav-user-profile:active {
            background: transparent !important; border: none !important; box-shadow: none !important; color: white !important; font-weight: 600;
        }
        .role-badge { background: var(--primary-blue); color: white; text-transform: uppercase; font-size: 0.65rem; font-weight: 800; padding: 3px 10px; border-radius: 4px; margin-right: 10px; }

        /* --- THE LAYOUT SHIFT --- */
        @media (min-width: 992px) {
            main {
                margin-left: var(--sidebar-width) !important;
                width: calc(100% - var(--sidebar-width)) !important;
                padding-top: calc(var(--navbar-height) + 20px) !important;
                display: block !important;
            }
            .container-fluid { max-width: 100% !important; margin-left: 0 !important; padding: 0 30px !important; }
        }

        /* Autofill Fix for all pages */
        input:-webkit-autofill { -webkit-text-fill-color: white !important; -webkit-box-shadow: 0 0 0px 1000px #0f172a inset !important; }
    </style>
</head>
<body>
    <div class="app-bg-wrapper"><div class="app-bg-photo"></div><div class="app-bg-grid"></div></div>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark">
            <div class="container-fluid px-0">
                <a class="navbar-brand" href="{{ url('/') }}"><i class="bi bi-mortarboard-fill"></i> MMM Boarding High School</a>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto align-items-center">
                        @guest
                            <li class="nav-item"><a class="btn btn-primary btn-sm px-4 fw-bold" href="{{ route('login') }}">Login</a></li>
                        @else
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle nav-user-profile" href="#" data-bs-toggle="dropdown">
                                    <span class="role-badge">{{ Auth::user()->role }}</span> {{ Auth::user()->first_name }}
                                </a>
                                <div class="dropdown-menu dropdown-menu-end bg-dark border-secondary">
                                    <a class="dropdown-item text-white" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <main>@yield('content')</main>
    </div>
</body>
</html>
