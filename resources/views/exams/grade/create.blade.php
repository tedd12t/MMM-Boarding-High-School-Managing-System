@extends('layouts.app')

@section('content')
<style>
    /* High-Level UI for System Configuration */
    .page-header h1 {
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -1px;
    }

    /* Premium Management Card */
    .config-card {
        background: #ffffff;
        border-radius: 20px;
        border: none;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
        padding: 40px;
    }

    .config-card-header {
        border-bottom: 1px solid #f1f5f9;
        margin-bottom: 25px;
        padding-bottom: 15px;
    }

    /* Professional Form Elements */
    .form-label-premium {
        font-weight: 700;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #475569;
        margin-bottom: 10px;
        display: block;
    }

    .form-control-premium, .form-select-premium {
        background-color: #f1f5f9 !important;
        border: 2px solid transparent !important;
        border-radius: 12px !important;
        padding: 12px 18px !important;
        font-size: 1rem !important;
        color: #1e293b !important;
        transition: all 0.3s ease;
    }

    .form-control-premium:focus, .form-select-premium:focus {
        background-color: #ffffff !important;
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1) !important;
    }

    /* Action Buttons */
    .btn-create-premium {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%) !important;
        color: white !important;
        border: none !important;
        border-radius: 12px !important;
        padding: 14px 40px !important;
        font-weight: 700 !important;
        box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.3);
        transition: transform 0.2s;
        width: 100%;
    }

    .btn-create-premium:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 20px -5px rgba(59, 130, 246, 0.4);
    }

    /* Side Info Panel */
    .logic-guide-panel {
        background: #0f172a;
        color: #f1f5f9;
        border-radius: 20px;
        padding: 35px;
        height: 100%;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.2);
    }

    .required-symbol {
        color: #3b82f6;
        margin-left: 3px;
    }
</style>

<div class="container-fluid px-4">
    <div class="row">
        <!-- Sidebar Inclusion -->
        @include('layouts.left-menu')

        <div class="col-lg-10">
            <div class="row pt-4">
                <div class="col-12 ps-lg-5">
                    
                    <!-- Header Section -->
                    <div class="mb-4">
                        <h1 class="page-header mb-1">
                            <i class="bi bi-gear-fill text-primary me-2"></i> Assessment Architecture
                        </h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="{{route('home')}}" class="text-decoration-none text-muted">Home</a></li>
                                <li class="breadcrumb-item active fw-bold text-primary">Grading Setup</li>
                            </ol>
                        </nav>
                    </div>

                    @include('session-messages')

                    <div class="row g-4 mt-2">
                        <!-- Left Column: Form -->
                        <div class="col-xl-6 col-lg-7">
                            <div class="config-card border">
                                <div class="config-card-header">
                                    <h5 class="fw-bold text-dark mb-1">Grading System Parameters</h5>
                                    <p class="text-muted small mb-0">Establish a new framework for evaluating student performance.</p>
                                </div>

                                <form action="{{route('exam.grade.system.store')}}" method="POST">
                                    @csrf
                                    {{-- Keeping original hidden session logic --}}
                                    <input type="hidden" name="session_id" value="{{$current_school_session_id}}">

                                    <div class="row g-3 mb-4">
                                        <div class="col-md-6">
                                            <label class="form-label-premium">Target Class<span class="required-symbol">*</span></label>
                                            <select class="form-select-premium form-select" name="class_id" required>
                                                @isset($school_classes)
                                                    @foreach ($school_classes as $school_class)
                                                    <option value="{{$school_class->id}}">{{$school_class->class_name}}</option>
                                                    @endforeach
                                                @endisset
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label-premium">Target Semester<span class="required-symbol">*</span></label>
                                            <select class="form-select-premium form-select" name="semester_id" required>
                                                @isset($semesters)
                                                    @foreach ($semesters as $semester)
                                                    <option value="{{$semester->id}}" {{($semester->id === request()->query('semester_id'))?'selected':''}}>{{$semester->semester_name}}</option>
                                                    @endforeach
                                                @endisset
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label-premium">System Nomenclature<span class="required-symbol">*</span></label>
                                        <input type="text" 
                                               class="form-control form-control-premium" 
                                               placeholder="e.g. Standard GPA System / Primary Grade Scale" 
                                               name="system_name" 
                                               required>
                                    </div>

                                    <div class="mt-5">
                                        <button type="submit" class="btn btn-create-premium">
                                            <i class="bi bi-shield-check me-2"></i> Initialize Grading System
                                        </button>
                                        <div class="text-center mt-3">
                                            <a href="{{url()->previous()}}" class="text-muted small text-decoration-none fw-bold">Cancel and Return</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Right Column: Logic Guide -->
                        <div class="col-xl-5 col-lg-5 d-none d-lg-block">
                            <div class="logic-guide-panel">
                                <h6 class="fw-bold text-primary mb-3">
                                    <i class="bi bi-info-square-fill me-2"></i> Configuration Guide
                                </h6>
                                <p class="small opacity-75">
                                    Defining a grading system is the first step in academic reporting for <strong>Maychew Martyrs Memorial</strong>.
                                </p>
                                <hr class="opacity-25 my-4">
                                
                                <div class="mb-4 d-flex">
                                    <div class="me-3"><i class="bi bi-1-circle-fill text-primary"></i></div>
                                    <div>
                                        <p class="small mb-0"><strong>Scope:</strong> Choose whether this scale applies to a single class or the entire semester.</p>
                                    </div>
                                </div>

                                <div class="mb-4 d-flex">
                                    <div class="me-3"><i class="bi bi-2-circle-fill text-primary"></i></div>
                                    <div>
                                        <p class="small mb-0"><strong>Naming:</strong> Use descriptive names like <em>"2024 Science Lab Scale"</em> to distinguish between different subject requirements.</p>
                                    </div>
                                </div>

                                <div class="p-3 rounded-3 bg-white bg-opacity-10 border border-white border-opacity-10 mt-5">
                                    <p class="small mb-0 opacity-75">
                                        <i class="bi bi-lightbulb-fill text-warning me-1"></i> 
                                        After creating this system, you will be directed to add specific <strong>Rules</strong> (e.g., 90-100 = A+).
                                    </p>
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