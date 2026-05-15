@extends('layouts.app')

@section('content')
<style>
    main {
        margin-left: 0 !important;
        width: 100% !important;
        display: flex !important;
        justify-content: center !important;
        align-items: flex-start !important;
    }

    .login-container, .register-container, .reset-container {
        width: 100% !important;
        margin-left: 0 !important;
        padding-left: 0 !important;
        display: flex !important;
        justify-content: center !important;
    }
    nav.navbar, .navbar {
        display: none !important;
    }

    body {
        background-color: #020617 !important;
        margin: 0;
        padding: 0;
        overflow: hidden;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .bg-wrapper {
        position: fixed;
        top: 0; left: 0; width: 100%; height: 100%;
        z-index: -1;
    }

    .bg-photo {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background: linear-gradient(rgba(2, 6, 23, 0.85), rgba(2, 6, 23, 0.95)), 
                    url("{{ asset('images/school-photo.jpg') }}"); 
        background-size: cover;
        background-position: center;
        animation: slowZoom 25s infinite alternate;
    }

    .bg-grid {
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

    .login-container {
        flex: 1;
        display: flex;
        justify-content: center; 
        align-items: flex-start; 
        padding-top: 20vh; 
        width: 100vw !important; 
        margin-left: 0 !important; 
    }

    .login-card {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.08) !important;
        backdrop-filter: blur(20px);
        border-radius: 20px !important;
        padding: 45px 35px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.6);
    }

    .login-header h2 {
        font-weight: 800;
        color: #ffffff;
        font-size: 2rem;
        text-align: center;
        margin-bottom: 30px;
        letter-spacing: -1px;
    }
    .input-group-premium {
        position: relative;
        margin-bottom: 25px;
    }

    .input-group-premium i {
        position: absolute;
        left: 18px;
        top: 50%;
        transform: translateY(-50%);
        color: #475569;
        z-index: 15;
    }

    .form-control-premium {
        background-color: #0f172a !important; 
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        border-radius: 10px !important;
        padding: 14px 15px 14px 52px !important;
        color: #ffffff !important; 
        font-size: 1rem;
        transition: 0.3s ease;
        width: 100%;
    }

    .form-control-premium:focus {
        border-color: #2563eb !important;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.2) !important;
        outline: none;
    }
    input:-webkit-autofill,
    input:-webkit-autofill:hover, 
    input:-webkit-autofill:focus, 
    input:-webkit-autofill:active {
        -webkit-text-fill-color: #ffffff !important;
        -webkit-box-shadow: 0 0 0px 1000px #0f172a inset !important;
        transition: background-color 5000s ease-in-out 0s;
    }
    .btn-login-submit {
        background: #2563eb !important;
        color: white !important;
        border: none !important;
        border-radius: 10px !important;
        padding: 14px !important;
        font-weight: 700 !important;
        width: 100%;
        text-transform: uppercase;
        letter-spacing: 1px;
        box-shadow: 0 10px 20px rgba(37, 99, 235, 0.2);
        transition: 0.3s;
    }

    .btn-login-submit:hover {
        background: #1d4ed8 !important;
        transform: translateY(-2px);
    }

    .login-footer {
        text-align: center;
        margin-top: 25px;
        color: #64748b;
        font-size: 0.85rem;
    }

    .login-footer a {
        color: #3b82f6;
        text-decoration: none;
        font-weight: 700;
    }

    .form-check-label { color: #94a3b8; font-size: 0.85rem; }
</style>

<div class="bg-wrapper">
    <div class="bg-photo"></div>
    <div class="bg-grid"></div>
</div>

<div class="login-container">
    <div class="login-card">
        <div class="login-header">
            <h2>Sign In</h2>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="input-group-premium">
                <i class="bi bi-person-fill"></i>
                <input id="email" type="email" class="form-control form-control-premium" 
                       name="email" value="{{ old('email') }}" required autofocus placeholder="Email Address">
            </div>

            <div class="input-group-premium">
                <i class="bi bi-shield-lock-fill"></i>
                <input id="password" type="password" class="form-control form-control-premium" 
                       name="password" required placeholder="Password">
            </div>
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label ms-1" for="remember">Keep me signed in</label>
                </div>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-white-50 small text-decoration-none">Forgot Password?</a>
                @endif
            </div>
            <button type="submit" class="btn-login-submit">
                Go To Dashboard <i class="bi bi-arrow-right-short"></i>
            </button>
            <div class="login-footer">
                Don't have an account? <a href="{{ route('register') }}">Create One</a>
            </div>
        </form>
    </div>
</div>
@endsection
