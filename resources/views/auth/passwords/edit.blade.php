@extends('layouts.app')

@section('content')
<style>
    .breadcrumb {
        background: rgba(255, 255, 255, 0.03) !important;
        padding: 10px 20px !important;
        border-radius: 10px !important;
        border: 1px solid rgba(255, 255, 255, 0.05);
    }
    .breadcrumb-item a {
        color: #3b82f6 !important;
        text-decoration: none;
        font-weight: 600;
    }
    .breadcrumb-item.active {
        color: #94a3b8 !important;
    }
    .display-6 {
        font-weight: 800 !important;
        letter-spacing: -1px;
        color: #ffffff;
    }
    .display-6 i {
        color: #3b82f6;
        margin-right: 10px;
    }
    .password-card {
        background: rgba(255, 255, 255, 0.03) !important;
        border: 1px solid rgba(255, 255, 255, 0.08) !important;
        backdrop-filter: blur(15px);
        border-radius: 20px !important;
        padding: 40px !important;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        margin-top: 20px;
    }
    .form-label {
        color: #3b82f6 !important;
        font-weight: 700 !important;
        font-size: 0.8rem !important;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 8px;
    }

    .form-control-cyber {
        background-color: rgba(15, 23, 42, 0.8) !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        color: #ffffff !important;
        border-radius: 10px !important;
        padding: 12px 15px !important;
        transition: all 0.3s ease;
    }

    .form-control-cyber:focus {
        border-color: #2563eb !important;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.2) !important;
        outline: none;
    }
    input:-webkit-autofill {
        -webkit-text-fill-color: #ffffff !important;
        -webkit-box-shadow: 0 0 0px 1000px #0f172a inset !important;
    }
    .btn-save-premium {
        background: #2563eb !important;
        color: white !important;
        border: none !important;
        border-radius: 10px !important;
        padding: 12px 30px !important;
        font-weight: 700 !important;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.3s ease;
        width: 100%;
        margin-top: 10px;
    }

    .btn-save-premium:hover {
        background: #1d4ed8 !important;
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(37, 99, 235, 0.4);
    }
</style>

<div class="container-fluid">
    <div class="row justify-content-start">
        @include('layouts.left-menu')
        
        <div class="col-xs-11 col-sm-11 col-md-11 col-lg-10 col-xl-10 col-xxl-10">
            <div class="row pt-4">
                <div class="col ps-lg-5">
                    
                    <h1 class="display-6 mb-3"><i class="bi bi-shield-lock-fill"></i> Security Settings</h1>
                    
                    <nav aria-label="breadcrumb" class="mb-4">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Change Password</li>
                        </ol>
                    </nav>

                    @include('session-messages')

                    <div class="row">
                        <div class="col-xl-6 col-lg-8">
                            <div class="password-card">
                                <form action="{{route('password.update')}}" method="POST">
                                    @csrf
                                    
                                    <div class="mb-4">
                                        <label for="old-password" class="form-label">Current Password</label>
                                        <input class="form-control form-control-cyber" id="old-password" name="old_password" type="password" placeholder="Verify current password" required>
                                    </div>

                                    <div class="mb-4">
                                        <label for="new-password" class="form-label">New Password</label>
                                        <input class="form-control form-control-cyber" id="new-password" name="new_password" type="password" placeholder="Create new password" required>
                                    </div>

                                    <div class="mb-4">
                                        <label for="new-password-confirm" class="form-label">Confirm New Password</label>
                                        <input class="form-control form-control-cyber" id="new-password-confirm" name="new_password_confirmation" type="password" placeholder="Repeat new password" required>
                                    </div>

                                    <button type="submit" class="btn btn-save-premium">
                                        <i class="bi bi-shield-check me-2"></i> Update Credentials
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 d-none d-xl-block">
                            <div class="p-4" style="background: rgba(59, 130, 246, 0.05); border-left: 4px solid #3b82f6; border-radius: 12px; margin-top: 20px;">
                                <h5 class="text-primary fw-bold"><i class="bi bi-info-circle me-2"></i> Security Tip</h5>
                                <p class="text-muted small mb-0">Use a combination of letters, numbers, and symbols to ensure your account remains protected against unauthorized access.</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            @include('layouts.footer')
        </div>
    </div>
</div>
@endsection
