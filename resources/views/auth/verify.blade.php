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

    /* --- CENTERED MEDIUM CARD --- */
    .verify-container {
        width: 100vw !important;   /* Forces full screen width */
        margin-left: 0 !important;  /* Removes the sidebar gap */
        display: flex;
        justify-content: center;    /* Centers horizontally */
        align-items: flex-start; 
    
        /* KEEP YOUR ORIGINAL TOP PADDING */
        padding-top: 15vh; 
        z-index: 10;

    }

    .verify-card {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.08) !important;
        backdrop-filter: blur(20px);
        border-radius: 20px !important;
        padding: 50px 40px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.6);
        color: #ffffff;
    }

    .verify-header h2 {
        font-weight: 800;
        font-size: 2rem;
        margin-bottom: 20px;
        letter-spacing: -1px;
    }

    .icon-box {
        font-size: 3rem;
        color: #3b82f6;
        margin-bottom: 20px;
        display: inline-block;
    }

    /* --- SUCCESS ALERT --- */
    .alert-success-custom {
        background: rgba(16, 185, 129, 0.1) !important;
        border: 1px solid rgba(16, 185, 129, 0.2) !important;
        color: #10b981 !important;
        border-radius: 10px;
        padding: 12px;
        margin-bottom: 25px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    /* --- INPUT FIX --- */
    .form-control-premium {
        background-color: #0f172a !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        border-radius: 10px !important;
        padding: 14px;
        color: #ffffff !important;
        transition: 0.3s ease;
        margin-bottom: 20px;
    }

    /* Fix Autofill Background */
    input:-webkit-autofill {
        -webkit-text-fill-color: #ffffff !important;
        -webkit-box-shadow: 0 0 0px 1000px #0f172a inset !important;
        transition: background-color 5000s ease-in-out 0s;
    }

    /* --- BUTTONS --- */
    .btn-submit-premium {
        background: #2563eb !important;
        color: white !important;
        border: none !important;
        border-radius: 10px !important;
        padding: 14px !important;
        font-weight: 700 !important;
        width: 100%;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: 0.3s;
    }

    .btn-submit-premium:hover {
        background: #1d4ed8 !important;
        transform: translateY(-2px);
    }

    .btn-link-premium {
        color: #3b82f6;
        text-decoration: none;
        font-weight: 700;
        background: none;
        border: none;
        padding: 0;
        margin-top: 20px;
        font-size: 0.9rem;
    }

    .text-muted-custom {
        color: #94a3b8;
        font-size: 0.95rem;
        line-height: 1.6;
        margin-bottom: 30px;
    }
</style>

<!-- Background Wrapper -->
<div class="bg-wrapper">
    <div class="bg-photo"></div>
    <div class="bg-grid"></div>
</div>

<!-- Main Container -->
<div class="verify-container">
    <div class="verify-card">
        
        <div class="icon-box">
            <i class="bi bi-shield-lock-fill"></i>
        </div>

        <div class="verify-header">
            <h2>Security Portal</h2>
        </div>

        <!-- Success Message Logic -->
        @if (session('resent') || session('status'))
            <div class="alert-success-custom" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('resent') ? __('A fresh link has been sent to your inbox.') : session('status') }}
            </div>
        @endif

        <p class="text-muted-custom">
            {{ __('Please follow the instructions sent to your email to verify your identity and secure your management account.') }}
        </p>

        <!-- Dynamic Form Logic (Works for both Verify and Forgot Password) -->
        <form method="POST" action="{{ request()->is('password/*') ? route('password.email') : route('verification.resend') }}">
            @csrf
            
            @if(request()->is('password/reset'))
                <input id="email" type="email" class="form-control form-control-premium" name="email" value="{{ old('email') }}" required placeholder="Enter Email Address">
                <button type="submit" class="btn-submit-premium">
                    {{ __('Send Reset Link') }}
                </button>
            @else
                <button type="submit" class="btn-submit-premium">
                    {{ __('Resend Verification Link') }}
                </button>
            @endif
        </form>

        <div class="mt-4">
            <a href="{{ route('logout') }}" class="text-white-50 small text-decoration-none" 
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                {{ __('Cancel and Sign Out') }}
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
        </div>
    </div>
</div>
@endsection
