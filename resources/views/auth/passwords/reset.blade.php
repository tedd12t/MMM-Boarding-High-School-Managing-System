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

    .reset-container {
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
    
    .reset-card {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.08) !important;
        backdrop-filter: blur(20px);
        border-radius: 20px !important;
        padding: 50px 40px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.6);
        color: #ffffff;
    }

    .reset-header h2 {
        font-weight: 800;
        font-size: 2rem;
        text-align: center;
        margin-bottom: 8px;
        letter-spacing: -1px;
    }

    .reset-header p {
        color: #64748b;
        text-align: center;
        margin-bottom: 35px;
        font-size: 0.9rem;
    }

    /* --- FORM LABELS & INPUTS --- */
    .form-label-custom {
        color: #3b82f6;
        font-weight: 700;
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        margin-bottom: 10px;
        display: block;
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
        padding: 14px 15px 14px 50px !important;
        color: #ffffff !important;
        font-size: 1rem;
        transition: 0.3s ease;
        width: 100%;
    }

    .form-control-premium:focus {
        border-color: #2563eb !important;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.15) !important;
        outline: none;
    }

    /* CRITICAL: Autofill Fix */
    input:-webkit-autofill {
        -webkit-text-fill-color: #ffffff !important;
        -webkit-box-shadow: 0 0 0px 1000px #0f172a inset !important;
        transition: background-color 5000s ease-in-out 0s;
    }

    /* --- BUTTONS --- */
    .btn-reset-submit {
        background: #2563eb !important;
        color: white !important;
        border: none !important;
        border-radius: 10px !important;
        padding: 16px !important;
        font-weight: 700 !important;
        width: 100%;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: 0.3s ease;
        box-shadow: 0 10px 25px rgba(37, 99, 235, 0.3);
        margin-top: 10px;
    }

    .btn-reset-submit:hover {
        background: #1d4ed8 !important;
        transform: translateY(-2px);
    }

    .invalid-feedback-custom {
        color: #f87171;
        font-size: 0.75rem;
        font-weight: 600;
        margin-top: -15px;
        margin-bottom: 15px;
        display: block;
    }
</style>

<!-- Background Wrapper -->
<div class="bg-wrapper">
    <div class="bg-photo"></div>
    <div class="bg-grid"></div>
</div>

<!-- Main Page Container -->
<div class="reset-container">
    <div class="reset-card">
        <div class="reset-header">
            <h2>{{ __('Reset Password') }}</h2>
            <p>Define your new security credentials</p>
        </div>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <!-- Email (Read Only or Prefilled) -->
            <label class="form-label-custom">{{ __('Email Address') }}</label>
            <div class="input-group-premium">
                <i class="bi bi-envelope-fill"></i>
                <input id="email" type="email" class="form-control form-control-premium @error('email') is-invalid @enderror" 
                       name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
            </div>
            @error('email')
                <span class="invalid-feedback-custom">{{ $message }}</span>
            @enderror

            <!-- New Password -->
            <label class="form-label-custom">{{ __('New Password') }}</label>
            <div class="input-group-premium">
                <i class="bi bi-shield-lock-fill"></i>
                <input id="password" type="password" class="form-control form-control-premium @error('password') is-invalid @enderror" 
                       name="password" required autocomplete="new-password" placeholder="••••••••">
            </div>
            @error('password')
                <span class="invalid-feedback-custom">{{ $message }}</span>
            @enderror

            <!-- Confirm Password -->
            <label class="form-label-custom">{{ __('Confirm New Password') }}</label>
            <div class="input-group-premium">
                <i class="bi bi-check-circle-fill"></i>
                <input id="password-confirm" type="password" class="form-control form-control-premium" 
                       name="password_confirmation" required autocomplete="new-password" placeholder="••••••••">
            </div>

            <!-- Submit -->
            <button type="submit" class="btn-reset-submit">
                {{ __('Update Password') }} <i class="bi bi-arrow-right-short ms-1"></i>
            </button>
        </form>
    </div>
</div>
@endsection
