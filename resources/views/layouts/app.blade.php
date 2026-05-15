<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Unifiedtransform') }}</title>

    <!-- Fonts & Icons -->
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
            --dark-bg: #020617;
        }

        body {
            font-family: 'Inter', sans-serif !important;
            background-color: var(--dark-bg) !important;
            color: #ffffff;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        /* --- BACKGROUND ANIMATION --- */
        .app-bg-wrapper {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            z-index: -1;
            background: var(--dark-bg);
        }
        .app-bg-photo {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background: linear-gradient(rgba(2, 6, 23, 0.85), rgba(2, 6, 23, 0.95)), 
                        url("{{ asset('images/school-photo.jpg') }}"); 
            background-size: cover;
            background-position: center;
            animation: slowZoom 25s infinite alternate;
        }
        .app-bg-grid {
            position: absolute;
            width: 200%; height: 200%;
            top: -50%; left: -50%;
            background-image: 
                linear-gradient(rgba(37, 99, 235, 0.1) 1px, transparent 1px),
                linear-gradient(90deg, rgba(37, 99, 235, 0.1) 1px, transparent 1px);
            background-size: 80px 80px;
            transform: perspective(500px) rotateX(60deg);
            animation: tunnelMove 15s linear infinite;
        }
        @keyframes tunnelMove {
            0% { transform: perspective(500px) rotateX(60deg) translateY(0); }
            100% { transform: perspective(500px) rotateX(60deg) translateY(80px); }
        }
        @keyframes slowZoom {
            from { transform: scale(1); }
            to { transform: scale(1.1); }
        }

        /* --- FIXED NAVBAR --- */
        .navbar {
            height: var(--navbar-height);
            position: fixed;
            top: 0; left: 0; width: 100%;
            z-index: 1050;
            background: rgba(15, 23, 42, 0.9) !important;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }
        @media (min-width: 992px) {
        main {
        /* 1. Start after the sidebar */
            margin-left: var(--sidebar-width) !important;
        
        /* 2. Occupy the rest of the screen */
            width: calc(100% - var(--sidebar-width)) !important;
        
        /* 3. Center the content inside this area */
            display: flex !important;
            justify-content: center !important; 
            padding-top: var(--navbar-height) !important;
        }

        /* 4. Define the Width of your Dashboard */
        .container {
            /* This controls how "wide" the dashboard looks. 
               Change 1200px to 1400px if you want it wider. */
            max-width: 1200px !important; 
            width: 95% !important;
        
            /* 5. Force equal distance on Left and Right */
            margin-left: auto !important;
            margin-right: auto !important;
            padding-left: 15px !important;
            padding-right: 15px !important;
        }

        /* 6. Ensure rows behave */
        .row {
            width: 100% !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
        }
    }
    </style>
</head>
<body>
    <!-- Global Animated Background -->
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
                    <span class="d-lg-none">MMM Academy</span>
                </a>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Session logic omitted for brevity, keep your original center logic here -->
                    
                    <ul class="navbar-nav ms-auto align-items-center">
                        @guest
                            <li class="nav-item"><a class="btn btn-primary btn-sm px-4" href="{{ route('login') }}">Login</a></li>
                        @else
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle nav-user-profile" href="#" data-bs-toggle="dropdown">
                                    <span class="badge bg-primary me-2">{{ Auth::user()->role }}</span>
                                    {{ Auth::user()->first_name }}
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

        <main>
            @yield('content')
        </main>
    </div>
</body>
</html>