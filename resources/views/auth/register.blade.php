@extends('layouts.app')

@section('content')
<style>
    /* --- THIS OVERRIDES THE GLOBAL SIDEBAR MARGIN --- */
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
    /* 1. HIDE THE HEADER COMPLETELY */
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

    /* --- ANIMATED BACKGROUND --- */
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

    /* --- CENTERED MEDIUM REGISTRATION CARD --- */
    .register-container {
        width: 100vw !important;   /* Forces full screen width */
        margin-left: 0 !important;  /* Removes the sidebar gap */
        display: flex;
        justify-content: center;    /* Centers horizontally */
        align-items: flex-start; 
    
        /* KEEP YOUR ORIGINAL TOP PADDING */
        padding-top: 10vh; 
        z-index: 10;
    }

    .register-card {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.08) !important;
        backdrop-filter: blur(20px);
        border-radius: 20px !important;
        padding: 45px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.6);
    }

    .register-header h2 {
        font-weight: 800;
        color: #ffffff;
        font-size: 2.1rem;
        text-align: center;
        margin-bottom: 30px;
        letter-spacing: -1px;
    }

    /* --- INPUT FIX (VISIBLE TEXT & DARK BACKGROUND) --- */
    .input-group-premium {
        position: relative;
        margin-bottom: 20px;
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
        background-color: #0f172a !important; /* Forces dark background */
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        border-radius: 10px !important;
        padding: 13px 15px 13px 52px !important;
        color: #ffffff !important; /* Text is always white */
        font-size: 1rem;
        transition: 0.3s ease;
        width: 100%;
    }

    .form-control-premium:focus {
        border-color: #2563eb !important;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.2) !important;
        outline: none;
    }

    /* CRITICAL: Prevents invisible typing on Saved Passwords/Autofill */
    input:-webkit-autofill,
    input:-webkit-autofill:hover, 
    input:-webkit-autofill:focus, 
    input:-webkit-autofill:active {
        -webkit-text-fill-color: #ffffff !important;
        -webkit-box-shadow: 0 0 0px 1000px #0f172a inset !important;
        transition: background-color 5000s ease-in-out 0s;
    }

    .form-label-custom {
        color: #3b82f6;
        font-weight: 700;
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 8px;
        display: block;
    }

    /* --- BUTTON & LINKS --- */
    .btn-register-submit {
        background: #2563eb !important;
        color: white !important;
        border: none !important;
        border-radius: 10px !important;
        padding: 15px !important;
        font-weight: 700 !important;
        width: 100%;
        text-transform: uppercase;
        letter-spacing: 1px;
        box-shadow: 0 10px 20px rgba(37, 99, 235, 0.2);
        transition: 0.3s;
        margin-top: 10px;
    }

    .btn-register-submit:hover {
        background: #1d4ed8 !important;
        transform: translateY(-2px);
    }

    .register-footer {
        text-align: center;
        margin-top: 25px;
        color: #64748b;
        font-size: 0.85rem;
    }

    .register-footer a {
        color: #3b82f6;
        text-decoration: none;
        font-weight: 700;
    }

    .invalid-feedback-custom {
        color: #f87171;
        font-size: 0.75rem;
        font-weight: 600;
        margin-top: 5px;
        display: block;
    }
</style>

<!-- Background Wrapper -->
<div class="bg-wrapper">
    <div class="bg-photo"></div>
    <div class="bg-grid"></div>
</div>

<!-- Page Container -->
<div class="register-container">
    <div class="register-card">
        <div class="register-header">
            <h2>Create Account</h2>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <label class="form-label-custom">Full Name</label>
            <div class="input-group-premium">
                <i class="bi bi-person-circle"></i>
                <input id="name" type="text" class="form-control form-control-premium @error('name') is-invalid @enderror" 
                       name="name" value="{{ old('name') }}" required autofocus placeholder="John Doe">
                @error('name')
                    <span class="invalid-feedback-custom">{{ $message }}</span>
                @enderror
            </div>

            <!-- Email -->
            <label class="form-label-custom">Authorized Email</label>
            <div class="input-group-premium">
                <i class="bi bi-envelope-fill"></i>
                <input id="email" type="email" class="form-control form-control-premium @error('email') is-invalid @enderror" 
                       name="email" value="{{ old('email') }}" required placeholder="email@school.com">
                @error('email')
                    <span class="invalid-feedback-custom">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password -->
            <label class="form-label-custom">Secure Password</label>
            <div class="input-group-premium">
                <i class="bi bi-lock-fill"></i>
                <input id="password" type="password" class="form-control form-control-premium @error('password') is-invalid @enderror" 
                       name="password" required placeholder="••••••••">
                @error('password')
                    <span class="invalid-feedback-custom">{{ $message }}</span>
                @enderror
            </div>

            <!-- Confirm Password -->
            <label class="form-label-custom">Confirm Password</label>
            <div class="input-group-premium">
                <i class="bi bi-shield-check"></i>
                <input id="password-confirm" type="password" class="form-control form-control-premium" 
                       name="password_confirmation" required placeholder="••••••••">
            </div>

            <!-- Submit -->
            <button type="submit" class="btn-register-submit">
                Initialize Account <i class="bi bi-chevron-right ms-1"></i>
            </button>

            <!-- Redirect -->
            <div class="register-footer">
                Already registered? <a href="{{ route('login') }}">Sign In</a>
            </div>
        </form>
    </div>
</div>
@endsection
