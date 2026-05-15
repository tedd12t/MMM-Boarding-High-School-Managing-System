@extends('layouts.app')

@section('content')
<style>
    .page-header h1 {
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -1px;
    }
    .breadcrumb-wrapper {
        background: #ffffff;
        padding: 12px 20px;
        border-radius: 12px;
        display: inline-flex;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
        border: 1px solid #e2e8f0;
        margin-bottom: 25px;
    }

    .breadcrumb-item a {
        color: #64748b;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.2s;
    }

    .breadcrumb-item a:hover {
        color: #3b82f6;
    }
    .edit-card {
        background: #ffffff;
        border-radius: 20px;
        border: none;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
        padding: 40px;
        transition: transform 0.3s ease;
    }
    .form-label-premium {
        font-weight: 700;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #475569;
        margin-bottom: 10px;
        display: block;
    }

    .form-control-premium {
        background-color: #f1f5f9 !important;
        border: 2px solid transparent !important;
        border-radius: 12px !important;
        padding: 12px 18px !important;
        font-size: 1rem !important;
        color: #1e293b !important;
        transition: all 0.3s ease;
    }

    .form-control-premium:focus {
        background-color: #ffffff !important;
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1) !important;
    }
    .btn-save-premium {
        background: linear-gradient(135deg, #0f172a 0%, #334155 100%) !important;
        color: white !important;
        border: none !important;
        border-radius: 12px !important;
        padding: 12px 35px !important;
        font-weight: 700 !important;
        font-size: 0.95rem;
        letter-spacing: 0.5px;
        box-shadow: 0 4px 12px rgba(15, 23, 42, 0.2);
        transition: all 0.3s ease;
    }

    .btn-save-premium:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 15px rgba(15, 23, 42, 0.3);
        background: linear-gradient(135deg, #1e293b 0%, #475569 100%) !important;
    }
    .info-panel {
        background: #eff6ff;
        border-left: 4px solid #3b82f6;
        padding: 20px;
        border-radius: 12px;
        height: 100%;
    }
</style>

<div class="container-fluid px-4">
    <div class="row">
        @include('layouts.left-menu')

        <div class="col-lg-10">
            <div class="row pt-4">
                <div class="col-12 ps-lg-5">
                    <div class="d-md-flex align-items-center justify-content-between mb-2">
                        <div>
                            <h1 class="page-header mb-1">
                                <i class="bi bi-pencil-square text-primary me-2"></i> Update Class Details
                            </h1>
                            <div class="breadcrumb-wrapper">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb mb-0">
                                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                                        <li class="breadcrumb-item"><a href="{{url()->previous()}}">Classes</a></li>
                                        <li class="breadcrumb-item active fw-bold text-primary">Edit</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>

                    @include('session-messages')
                    <div class="row mt-4">
                        <div class="col-xl-6 col-lg-8">
                            <div class="edit-card border">
                                <div class="mb-4">
                                    <h5 class="fw-bold text-dark">Modify Class Identity</h5>
                                    <p class="text-muted small">Update the grade or class name below. Changes reflect across all student records immediately.</p>
                                </div>

                                <form action="{{route('school.class.update')}}" method="POST">
                                    @csrf
                                    {{-- Keeping original hidden logic --}}
                                    <input type="hidden" name="session_id" value="{{$current_school_session_id}}">
                                    <input type="hidden" name="class_id" value="{{$class_id}}">

                                    <div class="mb-4">
                                        <label for="class_name" class="form-label-premium">Grade / Class Name</label>
                                        <input class="form-control form-control-premium" 
                                               id="class_name" 
                                               name="class_name" 
                                               type="text" 
                                               value="{{$schoolClass->class_name}}" 
                                               required 
                                               autofocus>
                                    </div>

                                    <div class="d-flex align-items-center justify-content-between mt-5">
                                        <a href="{{url()->previous()}}" class="text-muted text-decoration-none fw-bold small">
                                            <i class="bi bi-arrow-left me-1"></i> Discard Changes
                                        </a>
                                        <button type="submit" class="btn btn-save-premium">
                                            <i class="bi bi-check2-circle me-2"></i> Save Changes
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 d-none d-xl-block">
                            <div class="info-panel">
                                <h6 class="fw-bold text-primary mb-3"><i class="bi bi-info-circle-fill me-2"></i> Admin Tip</h6>
                                <p class="small text-dark opacity-75">
                                    For <strong>Maychew Martyrs Memorial</strong> standards, please ensure class names follow the 
                                    <em>"Grade - [Number] "</em> format for consistency in academic reports.
                                </p>
                                <hr class="my-3 opacity-25">
                                <div class="small fw-bold text-muted">
                                    <i class="bi bi-calendar3 me-2"></i> Current Session: {{$current_school_session_id}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-5">
                @include('layouts.footer')
            </div>
        </div>
    </div>
</div>
@endsection
