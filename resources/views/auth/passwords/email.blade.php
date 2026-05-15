@extends('layouts.app')

@section('content')
<style>
    /* 1. HIDE THE HEADER COMPLETELY */
    nav.navbar, .navbar {
        display: none !important;
    }

    /* 2. FORCE TRUE CENTER (Overrides Sidebar Margin) */
    main {
        margin-left: 0 !important;   /* Kills the 260px gap */
        width: 100% !important;
        display: flex !important;
        justify-content: center !important;
        align-items: flex-start !important;
    }

    body {
        background-color: #020617 !important;
        margin: 0;
        padding: 0;
        overflow: hidden;
        min-height: 100vh;
    }

    /* 3. CENTERED MEDIUM CARD (Same as Sign In) */
    .reset-container {
        width: 100% !important;
        max-width: 420px; /* Same width as Sign In */
        padding-top: 20vh; /* Same height as Sign In */
        z-index: 10;
        display: flex;
        flex-direction: column;
    }

    .reset-card {
        background: rgba(255, 255, 255, 0.03) !important;
        border: 1px solid rgba(255, 255, 255, 0.08) !important;
        backdrop-filter: blur(20px) !important;
        -webkit-backdrop-filter: blur(20px);
        border-radius: 20px !important;
        padding: 50px 40px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.6) !important;
        text-align: center;
        color: #ffffff;
    }

    .reset-header h2 {
        font-weight: 800;
        font-size: 2.2rem;
        margin-bottom: 8px;
        letter-spacing: -1px;
    }

    .reset-header p {
        color: #64748b;
        font-size: 0.9rem;
        margin-bottom: 35px;
    }

    /* 4. INPUT STYLING & TYPING FIX */
    .input-group-premium {
        position: relative;
        margin-bottom: 25px;
        text-align: left;
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
        background-color: #0f172a !important; /* Dark base */
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        border-radius: 10px !important;
        padding: 14px 15px 14px 52px !important;
        color: #ffffff !important; /* White text when typing */
        font-size: 1rem;
        width: 100%;
    }

    /* Autofill Shield (Invisible typing fix) */
    input:-webkit-autofill {
        -webkit-text-fill-color: #ffffff !important;
        -webkit-box-shadow: 0 0 0px 1000px #0f172a inset !important;
        transition: background-color 5000s ease-in-out 0s;
    }

    /* 5. BUTTON STYLING */
    .btn-reset-submit {
        background: #2563eb !important;
        color: white !important;
        border: none !important;
        border-radius: 10px !important;
        padding: 15px !important;
        font-weight: 700 !important;
        width: 100%;
        text-transform: uppercase;
        letter-spacing: 1px;
        box-shadow: 0 10px 20px rgba(37, 99, 235, 0.3);
        transition: 0.3s;
    }

    .btn-reset-submit:hover {
        background: #1d4ed8 !important;
        transform: translateY(-2px);
    }

    .reset-footer {
        text-align: center;
        margin-top: 30px;
    }

    .reset-footer a {
        color: #3b82f6;
        text-decoration: none;
        font-weight: 700;
        font-size: 0.85rem;
    }
</style>

<div class="reset-container">
    <div class="reset-card">
        <div class="reset-header">
            <h2>Recovery</h2>
            <p>MMM Academy Management Portal</p>
        </div>

        @if (session('status'))
            <div class="alert alert-success py-2 mb-4" style="background: rgba(16,185,129,0.1); border: 1px solid #10b981; color: #10b981; font-size: 0.8rem; border-radius: 8px;">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="input-group-premium">
                <i class="bi bi-envelope-fill"></i>
                <input id="email" type="email" class="form-control form-control-premium" 
                       name="email" value="{{ old('email') }}" required autofocus placeholder="Authorized Email">
            </div>

            <button type="submit" class="btn-reset-submit">
                Send Reset Link <i class="bi bi-send-fill ms-2"></i>
            </button>

            <div class="reset-footer">
                <a href="{{ route('login') }}">Back to Sign In</a>
            </div>
        </form>
    </div>
</div>
@endsection
