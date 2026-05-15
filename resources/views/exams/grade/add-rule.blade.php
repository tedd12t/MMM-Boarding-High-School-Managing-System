@extends('layouts.app')

@section('content')
<style>
    /* High-Level UI for Academic Logic */
    .page-header h1 {
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -1px;
    }

    /* Elevated Form Card */
    .rule-card {
        background: #ffffff;
        border-radius: 20px;
        border: none;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
        padding: 40px;
    }

    /* Modern Input Styling */
    .form-label-premium {
        font-weight: 700;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #475569;
        margin-bottom: 8px;
        display: block;
    }

    .form-control-premium {
        background-color: #f1f5f9 !important;
        border: 2px solid transparent !important;
        border-radius: 12px !important;
        padding: 12px 15px !important;
        font-size: 1rem !important;
        color: #1e293b !important;
        transition: all 0.3s ease;
    }

    .form-control-premium:focus {
        background-color: #ffffff !important;
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1) !important;
    }

    /* Range Grouping */
    .range-group {
        background: #f8fafc;
        padding: 20px;
        border-radius: 16px;
        border: 1px dashed #cbd5e1;
    }

    /* Premium Action Button */
    .btn-add-rule {
        background: linear-gradient(135deg, #0f172a 0%, #334155 100%) !important;
        color: white !important;
        border: none !important;
        border-radius: 12px !important;
        padding: 14px 40px !important;
        font-weight: 700 !important;
        width: 100%;
        box-shadow: 0 10px 15px -3px rgba(15, 23, 42, 0.2);
        transition: transform 0.2s;
    }

    .btn-add-rule:hover {
        transform: translateY(-2px);
    }

    /* Sidebar Context Panel */
    .context-panel {
        background: #eff6ff;
        border-radius: 20px;
        padding: 30px;
        border-left: 5px solid #3b82f6;
    }

    .required-mark {
        color: #ef4444;
        font-size: 1.2rem;
        margin-left: 4px;
    }
</style>

<div class="container-fluid px-4">
    <div class="row">
        <!-- Professional Sidebar -->
        @include('layouts.left-menu')

        <div class="col-lg-10">
            <div class="row pt-4">
                <div class="col-12 ps-lg-5">
                    
                    <!-- Header Section -->
                    <div class="mb-4">
                        <h1 class="page-header mb-1">
                            <i class="bi bi-file-earmark-plus text-primary me-2"></i> Define Grading Rule
                        </h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="{{route('home')}}" class="text-decoration-none text-muted">Home</a></li>
                                <li class="breadcrumb-item"><a href="{{url()->previous()}}" class="text-decoration-none text-muted">Grade Systems</a></li>
                                <li class="breadcrumb-item active fw-bold text-primary">New Rule</li>
                            </ol>
                        </nav>
                    </div>

                    @include('session-messages')

                    <div class="row g-4 mt-2">
                        <!-- Main Form Column -->
                        <div class="col-xl-6 col-lg-8">
                            <div class="rule-card border">
                                <form action="{{route('exam.grade.system.rule.store')}}" method="POST">
                                    @csrf
                                    {{-- Original Hidden Logic --}}
                                    <input type="hidden" name="grading_system_id" value="{{$grading_system_id}}">
                                    <input type="hidden" name="session_id" value="{{$current_school_session_id}}">

                                    <div class="row g-3 mb-4">
                                        <div class="col-md-6">
                                            <label for="inputPoint" class="form-label-premium">Grade Point <span class="required-mark">*</span></label>
                                            <input type="number" step="0.01" name="point" class="form-control form-control-premium" id="inputPoint" placeholder="e.g. 4.00" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="inputGrade" class="form-label-premium">Grade Letter <span class="required-mark">*</span></label>
                                            <input type="text" name="grade" class="form-control form-control-premium" id="inputGrade" placeholder="e.g. A+" required>
                                        </div>
                                    </div>

                                    <div class="range-group">
                                        <h6 class="fw-bold text-dark mb-3 small text-uppercase opacity-75">Score Range Boundaries</h6>
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label for="inputStarts" class="form-label-premium">Minimum Score</label>
                                                <input type="number" step="0.01" name="start_at" class="form-control form-control-premium" id="inputStarts" placeholder="85.00" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="inputEnds" class="form-label-premium">Maximum Score</label>
                                                <input type="number" step="0.01" name="end_at" class="form-control form-control-premium" id="inputEnds" placeholder="100.00" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-5">
                                        <button type="submit" class="btn btn-add-rule">
                                            <i class="bi bi-plus-circle-fill me-2"></i> Register Grading Rule
                                        </button>
                                        <div class="text-center mt-3">
                                            <a href="{{url()->previous()}}" class="text-muted small text-decoration-none fw-bold">Discard and Return</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Side Context Panel -->
                        <div class="col-xl-4 col-lg-4 d-none d-xl-block">
                            <div class="context-panel shadow-sm">
                                <h6 class="fw-bold text-primary mb-3"><i class="bi bi-info-circle-fill me-2"></i> Grading Logic</h6>
                                <p class="small text-dark opacity-75">
                                    Rules defined here determine how student percentages are converted into official GPA points and letter grades for **Maychew Martyrs Memorial** transcripts.
                                </p>
                                <hr class="my-4 opacity-25">
                                <ul class="list-unstyled small">
                                    <li class="mb-3 d-flex align-items-start">
                                        <i class="bi bi-check-circle-fill text-success me-2 mt-1"></i>
                                        <span><strong>Point:</strong> Numeric value for GPA calculations.</span>
                                    </li>
                                    <li class="mb-3 d-flex align-items-start">
                                        <i class="bi bi-check-circle-fill text-success me-2 mt-1"></i>
                                        <span><strong>Grade:</strong> The alpha-label (A, B, C) shown on report cards.</span>
                                    </li>
                                    <li class="d-flex align-items-start">
                                        <i class="bi bi-check-circle-fill text-success me-2 mt-1"></i>
                                        <span><strong>Range:</strong> The percentage bracket (e.g. 90 to 100).</span>
                                    </li>
                                </ul>
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