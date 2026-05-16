<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'MMM Boarding High School Manageing System') }}</title>

        <link rel="shortcut icon" href="{{asset('favicon_io/favicon.ico')}}">
        <link rel="apple-touch-icon" href="{{asset('favicon_io/apple-touch-icon.png')}}">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;800&display=swap" rel="stylesheet">
        
        <!-- Bootstrap 5 & Icons -->
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

        <style>
            :root {
                --primary-blue: #2563eb;
                --dark-bg: #020617;
                --grid-color: rgba(37, 99, 235, 0.12);
            }

            body {
                font-family: 'Inter', sans-serif;
                background-color: var(--dark-bg);
                color: #ffffff;
                margin: 0;
                padding: 0;
                overflow-x: hidden;
            }

            .hero-wrapper {
                position: relative;
                min-height: 100vh;
                width: 100%;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: flex-start; 
                overflow: hidden;
                background: radial-gradient(circle at center, #0a192f 0%, #020617 100%);
                padding-top: 120px; 
            }

            .grid-container {
                position: absolute;
                width: 200%; height: 200%;
                top: -50%; left: -50%;
                background-image: 
                    linear-gradient(var(--grid-color) 1px, transparent 1px),
                    linear-gradient(90deg, var(--grid-color) 1px, transparent 1px);
                background-size: 80px 80px;
                transform: perspective(500px) rotateX(60deg);
                animation: tunnelMove 15s linear infinite;
                z-index: 1;
            }

            @keyframes tunnelMove {
                0% { transform: perspective(500px) rotateX(60deg) translateY(0); }
                100% { transform: perspective(500px) rotateX(60deg) translateY(80px); }
            }

            .hero-overlay {
                position: absolute;
                top: 0; left: 0; width: 100%; height: 100%;
                background: radial-gradient(circle at center, transparent 10%, var(--dark-bg) 90%);
                z-index: 2;
            }

            .navbar {
                position: fixed;
                top: 0; width: 100%;
                z-index: 1000;
                padding: 20px 0;
                background: rgba(2, 6, 23, 0.8) !important;
                backdrop-filter: blur(10px);
            }

            .navbar-brand {
                display: flex;
                align-items: center;
                gap: 10px;
                text-decoration: none;
            }

            .academic-logo-icon {
                font-size: 1.5rem;
                color: var(--primary-blue);
            }

            .school-name-top {
                font-weight: 700;
                color: #ffffff;
                font-size: 0.85rem;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }

            .btn-login-main {
                background: var(--primary-blue);
                background-color: #000000 !important;
                color: white;
                border-color: #000000 !important;
                padding: 8px 24px;
                border-radius: 6px;
                font-weight: 700;
                font-size: 0.85rem;
                text-decoration: none;
            }
            .hero-content {
                position: relative;
                z-index: 10;
                text-align: center;
                width: 90%;
                max-width: 1200px;
                margin-bottom: 100px;
            }

            .hero-title {
                font-size: clamp(1.8rem, 5vw, 3.5rem); 
                font-weight: 800;
                line-height: 1.2;
                text-transform: uppercase;
                letter-spacing: -1px;
                margin-bottom: 20px;
            }

            .info-section {
                background: var(--dark-bg);
                padding: 80px 0;
                position: relative;
                z-index: 20;
            }

            .section-header h2 {
                font-weight: 800;
                text-transform: uppercase;
                color: var(--primary-blue);
                font-size: 1.8rem;
                margin-bottom: 10px;
            }

            .info-card {
                background: rgba(255, 255, 255, 0.03);
                border: 1px solid rgba(255, 255, 255, 0.08);
                padding: 30px;
                border-radius: 12px;
                height: 100%;
                transition: 0.3s ease;
            }

            .info-card:hover {
                border-color: var(--primary-blue);
                transform: translateY(-5px);
            }

            .info-card h4 {
                color: #ffffff;
                font-weight: 700;
                margin-bottom: 12px;
                font-size: 1.2rem;
            }

            .info-card p {
                color: #94a3b8;
                font-size: 0.9rem;
            }

            .info-icon {
                font-size: 1.8rem;
                color: var(--primary-blue);
                margin-bottom: 15px;
                display: block;
            }
        </style>
    </head>
    <body>
        
        <!-- Navigation -->
        <nav class="navbar">
            <div class="container d-flex justify-content-between align-items-center">
                <a class="navbar-brand" href="/">
                    <div class="academic-logo-icon">
                        <i class="bi bi-mortarboard-fill"></i>
                    </div>
                    <span class="school-name-top">Maychew Martyrs Memorial Boarding High School</span>
                </a>
                
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/home') }}" class="btn-login-main">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn-login-main">Login</a>
                    @endauth
                @endif
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="hero-wrapper">
            <div class="grid-container"></div>
            <div class="hero-overlay"></div>

            <div class="hero-content">
                <h1 class="hero-title">
                    Maychew Martyrs Memorial <br> Boarding High School
                </h1>
            </div>

            <!-- Features directly under title -->
            <div class="container pb-5" style="position: relative; z-index: 30;">
                <div class="text-center mb-5">
                    <h2 class="text-primary fw-800 text-uppercase" style="font-size: 1.5rem;">Management System</h2>
                </div>
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="info-card">
                            <i class="bi bi-person-check info-icon"></i>
                            <h4>Attendance Tracking</h4>
                            <p>Automated attendance logs for students and staff with instant reporting.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-card">
                            <i class="bi bi-graph-up-arrow info-icon"></i>
                            <h4>Grade Analytics</h4>
                            <p>Advanced marking system with automated ranking and visualizations.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-card">
                            <i class="bi bi-calendar3 info-icon"></i>
                            <h4>Dynamic Routine</h4>
                            <p>Interactive scheduling engine to manage teacher timetables effortlessly.</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- System Review Credentials -->
            <div class="mt-4 pt-3">
                <div class="d-inline-block p-3 rounded-4 border border-white border-opacity-10" style="background: rgba(255,255,255,0.05); backdrop-filter: blur(5px);">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <i class="bi bi-shield-lock-fill text-primary fs-4"></i>
                        </div>
                        <div class="text-start">
                            <small class="text-white-50 d-block text-uppercase fw-bold" style="font-size: 0.65rem; letter-spacing: 1px;">System Review Access</small>
                            <code class="text-white" style="font-size: 0.9rem;">
                                Email: <span class="text-primary">admin@MMM.com</span> &nbsp;|&nbsp; Pass: <span class="text-primary">password</span>
                            </code>
                        </div>
                    </div>
                </div>
            </div>

        </section>

        <!-- Footer -->
        <footer class="py-4 border-top border-white border-opacity-10 text-center text-white-50 small">
            &copy; {{ date('Y') }} Maychew Martyrs Memorial Special Boarding School.
        </footer>

    </body>
</html>
