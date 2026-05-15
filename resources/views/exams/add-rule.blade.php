@extends('layouts.app')

@section('content')
<style>
    /* High-Level UI for Exam Configuration */
    .page-header h1 {
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -1px;
    }

    .breadcrumb-premium {
        background: #ffffff;
        padding: 10px 20px;
        border-radius: 12px;
        display: inline-flex;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
        border: 1px solid #e2e8f0;
    }

    /* Elevated Form Card */
    .config-card {
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

    /* Score Distribution Box */
    .note-area {
        background: #f8fafc;
        border: 1px dashed #cbd5e1;
        border-radius: 16px;
        padding: 20px;
    }

    /* Premium Action Button */
    .btn-save-rule {
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

    .btn-save-rule:hover {
        transform: translateY(-2px);
    }

    /* Sidebar Context Panel */
    .logic-panel {
        background: #eff6ff;
        border-radius: 20px;
        padding: 30px;
        border-left: 5px solid #3b82f6;
    }

    .required-symbol {
        color: #3b82f6;
        margin-left: 3px;
        font-size: 1.1rem;
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
                            <i class="bi bi-file-earmark-plus text-primary me-2"></i> Configure Assessment Rule
                        </h1>
                        <nav aria-label="breadcrumb" class="mt-2">
                            <ol class="breadcrumb breadcrumb-premium mb-0">
                                <li class="breadcrumb-item"><a href="{{route('home')}}" class="text-decoration-none text-muted">Home</a></li>
                                <li class="breadcrumb-item"><a href="{{url()->previous()}}" class="text-decoration-none text-muted">Exams</a></li>
                                <li class="breadcrumb-item active fw-bold text-primary">New Marking Rule</li>
                            </ol>
                        </nav>
                    </div>

                    @include('session-messages')

                    <div class="row g-4 mt-2">
                        <!-- Main Form Column -->
                        <div class="col-xl-6 col-lg-8">
                            <div class="config-card border">
                                <form action="{{route('exam.rule.store')}}" method="POST">
                                    @csrf
                                    {{-- Original Hidden Logic --}}
                                    <input type="hidden" name="exam_id" value="{{$exam_id}}">
                                    <input type="hidden" name="session_id" value="{{$current_school_session_id}}">

                                    <div class="row g-3 mb-4">
                                        <div class="col-md-6">
                                            <label for="inputTotalMarks" class="form-label-premium">Maximum Score<span class="required-symbol">*</span></label>
                                            <input type="number" 
                                                   class="form-control form-control-premium" 
                                                   id="inputTotalMarks" 
                                                   placeholder="e.g. 100.00" 
                                                   name="total_marks" 
                                                   step="0.01" 
                                                   required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="inputPassMarks" class="form-label-premium">Passing Threshold<span class="required-symbol">*</span></label>
                                            <input type="number" 
                                                   class="form-control form-control-premium" 
                                                   id="inputPassMarks" 
                                                   placeholder="e.g. 40.00" 
                                                   name="pass_marks" 
                                                   step="0.01" 
                                                   required>
                                        </div>
                                    </div>

                                    <div class="note-area">
                                        <label for="inputMarksDistributionNote" class="form-label-premium">Marks Distribution breakdown<span class="required-symbol">*</span></label>
                                        <textarea class="form-control form-control-premium" 
                                                  id="inputMarksDistributionNote" 
                                                  rows="4" 
                                                  placeholder="Detail the marks per section (e.g. MCQ: 20, Theory: 80)" 
                                                  name="marks_distribution_note" 
                                                  required></textarea>
                                        <small class="text-muted mt-2 d-block">
                                            <i class="bi bi-info-circle me-1"></i> This note will be visible to teachers during mark entry.
                                        </small>
                                    </div>

                                    <div class="mt-5">
                                        <button type="submit" class="btn btn-save-rule">
                                            <i class="bi bi-check-circle-fill me-2"></i> Finalize Marking Rule
                                        </button>
                                        <div class="text-center mt-3">
                                            <a href="{{url()->previous()}}" class="text-muted small text-decoration-none fw-bold">Discard Changes</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Side Logic Panel -->
                        <div class="col-xl-4 col-lg-4 d-none d-xl-block">
                            <div class="logic-panel shadow-sm">
                                <h6 class="fw-bold text-primary mb-3"><i class="bi bi-shield-lock-fill me-2"></i> Assessment Logic</h6>
                                <p class="small text-dark opacity-75">
                                    Rules defined here are strictly enforced during the grading process at **Maychew Martyrs Memorial**.
                                </p>
                                <hr class="my-4 opacity-25">
                                <div class="d-flex mb-3">
                                    <div class="me-3 fs-4 text-primary"><i class="bi bi-1-circle"></i></div>
                                    <p class="small mb-0"><strong>Precision:</strong> Marks support up to 2 decimal places for highly accurate scientific grading.</p>
                                </div>
                                <div class="d-flex mb-3">
                                    <div class="me-3 fs-4 text-primary"><i class="bi bi-2-circle"></i></div>
                                    <p class="small mb-0"><strong>Validation:</strong> The pass mark must be lower than or equal to the total marks.</p>
                                </div>
                                <div class="d-flex">
                                    <div class="me-3 fs-4 text-primary"><i class="bi bi-3-circle"></i></div>
                                    <p class="small mb-0"><strong>Distribution:</strong> Clear notes ensure all faculty members follow the same marking rubric.</p>
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