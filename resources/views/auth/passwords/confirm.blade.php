@extends('layouts.app')

@section('content')
<style>
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

    /* --- ANIMATED BACKGROUND SYSTEM --- */
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

    /* --- CENTERED MEDIUM SECURITY CARD --- */
    .confirm-container {
        width: 100%;
        max-width: 420px; /* Medium Professional Size */
        padding-top: 15vh; /* Centered slightly towards bottom */
        z-index: 10;
    }

    .confirm-card {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.08) !important;
        backdrop-filter: blur(20px);
        border-radius: 20px !important;
        padding: 50px 40px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.6);
        color: #ffffff;
        text-align: center;
    }

    .confirm-header h2 {
        font-weight: 800;
        font-size: 2rem;
        margin-bottom: 10px;
        letter-spacing: -1px;
    }

    .confirm-header p {
        color: #64748b;
        font-size: 0.9rem;
        margin-bottom: 35px;
        line-height: 1.5;
    }

    .icon-box {
        font-size: 3rem;
        color: #3b82f6;
        margin-bottom: 20px;
        display: inline-block;
    }

    /* --- INPUT FIX (NO WHITE BACKGROUND) --- */
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

    /* Autofill Visibility Fix */
    input:-webkit-autofill {
        -webkit-text-fill-color: #ffffff !important;
        -webkit-box-shadow: 0 0 0px 1000px #0f172a inset !important;
        transition: background-color 5000s ease-in-out 0s;
    }

    /* --- BUTTONS --- */
    .btn-confirm-submit {
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
    }

    .btn-confirm-submit:hover {
        background: #1d4ed8 !important;
        transform: translateY(-2px);
    }

    .forgot-link {
        color: #3b82f6;
        text-decoration: none;
        font-weight: 700;
        font-size: 0.85rem;
        display: block;
        margin-top: 25px;
        transition: 0.2s;
    }

    .forgot-link:hover {
        color: #ffffff;
    }
</style>

<!-- Background Elements -->
<div class="bg-wrapper">
    <div class="bg-photo"></div>
    <div class="bg-grid"></div>
</div>

<!-- Confirm Password Page Container -->
<div class="confirm-container">
    <div class="confirm-card">
        
        <div class="icon-box">
            <i class="bi bi-shield-lock-fill"></i>
        </div>

        <div class="confirm-header">
            <h2>{{ __('Security Check') }}</h2>
            <p>{{ __('Please confirm your password before continuing to your secure dashboard.') }}</p>
        </div>

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <!-- Password Input -->
            <div class="input-group-premium text-start">
                <i class="bi bi-key-fill"></i>
                <input id="password" type="password" 
                       class="form-control form-control-premium @error('password') is-invalid @enderror" 
                       name="password" required autocomplete="current-password" 
                       placeholder="Enter Security Password">
            </div>

            @error('password')
                <p class="text-danger small fw-bold mt-n3 mb-3 text-start"><i class="bi bi-exclamation-circle me-1"></i> {{ $message }}</p>
            @enderror

            <!-- Submit Button -->
            <button type="submit" class="btn-confirm-submit">
                {{ __('Unlock Dashboard') }} <i class="bi bi-unlock-fill ms-2"></i>
            </button>

            <!-- Forgot Link -->
            @if (Route::has('password.request'))
                <a class="forgot-link" href="{{ route('password.request') }}">
                    {{ __('Forgot Your Password?') }}
                </a>
            @endif
        </form>
    </div>
</div>
@endsection