@extends('layouts.app')

@section('content')
<style>
    /* High-Level UI for Administrative Editing */
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

    /* Elevated Edit Card */
    .edit-card {
        background: #ffffff;
        border-radius: 24px;
        border: none;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
        padding: 40px;
    }

    .edit-card-header {
        border-bottom: 1px solid #f1f5f9;
        margin-bottom: 30px;
        padding-bottom: 20px;
    }

    /* Modern Input Styling */
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

    /* Distribution Note Area */
    .note-box {
        background: #f8fafc;
        border: 2px dashed #e2e8f0;
        border-radius: 16px;
        padding: 20px;
        margin-top: 10px;
    }

    /* High-Level Primary Button */
    .btn-save-premium {
        background: linear-gradient(135deg, #0f172a 0%, #334155 100%) !important;
        color: white !important;
        border: none !important;
        border-radius: 12px !important;
        padding: 14px 40px !important;
        font-weight: 700 !important;
        font-size: 0.95rem;
        letter-spacing: 0.5px;
        box-shadow: 0 4px 12px rgba(15, 23, 42, 0.2);
        transition: all 0.3s ease;
        width: 100%;
    }

    .btn-save-premium:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 15px rgba(15, 23, 42, 0.3);
    }

    /* Side Context Guide */
    .status-panel {
        background: #0f172a;
        color: #f1f5f9;
        border-radius: 20px;
        padding: 35px;
        height: 100%;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.2);
    }

    .required-mark {
        color: #3b82f6;
        margin-left: 3px;
        font-weight: bold;
    }
</style>

<div class="container-fluid px-4">
    <div class="row g-0">
        <!-- Professional Sidebar -->
        @include('layouts.left-menu')

        <div class="col-lg-10">
            <div class="row pt-4">
                <div class="col-12 ps-lg-5">
                    
                    <!-- Header Section -->
                    <div class="mb-4">
                        <h1 class="page-header mb-1">
                            <i class="bi bi-pencil-square text-primary me-2"></i> Edit Assessment Parameters
                        </h1>
                        <nav aria-label="breadcrumb" class="mt-2">
                            <ol class="breadcrumb breadcrumb-premium mb-0">
                                <li class="breadcrumb-item"><a href="{{route('home')}}" class="text-decoration-none text-muted">Home</a></li>
                                <li class="breadcrumb-item"><a href="{{url()->previous()}}" class="text-decoration-none text-muted">Exam Rules</a></li>
                                <li class="breadcrumb-item active fw-bold text-primary">Modify Rule</li>
                            </ol>
                        </nav>
                    </div>

                    @include('session-messages')

                    <div class="row g-4 mt-2 mb-5">
                        <!-- Primary Form Column -->
                        <div class="col-xl-7 col-lg-8">
                            <div class="edit-card border">
                                <div class="edit-card-header">
                                    <h5 class="fw-bold text-dark mb-1">Rule Configuration</h5>
                                    <p class="text-muted small mb-0">Update the marking boundaries and distribution logic for this assessment.</p>
                                </div>

                                <form action="{{route('exam.rule.update')}}" method="POST">
                                    @csrf
                                    {{-- Keeping original hidden logic --}}
                                    <input type="hidden" name="exam_rule_id" value="{{$exam_rule_id}}">

                                    <div class="row g-4 mb-4">
                                        <div class="col-md-6">
                                            <label for="inputTotalMarks" class="form-label-premium">Maximum Score<span class="required-mark">*</span></label>
                                            <input type="number" 
                                                   class="form-control form-control-premium" 
                                                   id="inputTotalMarks" 
                                                   value="{{$exam_rule->total_marks}}" 
                                                   name="total_marks" 
                                                   step="0.01" 
                                                   required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="inputPassMarks" class="form-label-premium">Passing Threshold<span class="required-mark">*</span></label>
                                            <input type="number" 
                                                   class="form-control form-control-premium" 
                                                   id="inputPassMarks" 
                                                   value="{{$exam_rule->pass_marks}}" 
                                                   name="pass_marks" 
                                                   step="0.01" 
                                                   required>
                                        </div>
                                    </div>

                                    <div class="note-box mb-4">
                                        <label for="inputMarksDistributionNote" class="form-label-premium">Marks Distribution breakdown<span class="required-mark">*</span></label>
                                        <textarea class="form-control form-control-premium" 
                                                  id="inputMarksDistributionNote" 
                                                  rows="5" 
                                                  name="marks_distribution_note" 
                                                  required>{{$exam_rule->marks_distribution_note}}</textarea>
                                        <div class="mt-2 text-muted" style="font-size: 0.75rem;">
                                            <i class="bi bi-info-circle me-1"></i> Use this area to describe section-wise marks (e.g., Part A: 40, Part B: 60).
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center justify-content-between mt-5">
                                        <a href="{{url()->previous()}}" class="text-muted text-decoration-none small fw-bold">
                                            <i class="bi bi-arrow-left-circle me-1"></i> Discard Changes
                                        </a>
                                        <div style="width: 250px;">
                                            <button type="submit" class="btn btn-save-premium">
                                                <i class="bi bi-cloud-upload-fill me-2"></i> Update Rule
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Side Context Panel -->
                        <div class="col-xl-4 col-lg-4 d-none d-xl-block">
                            <div class="status-panel">
                                <h6 class="fw-bold text-primary mb-3">
                                    <i class="bi bi-info-square-fill me-2"></i> System Intelligence
                                </h6>
                                <p class="small opacity-75">
                                    You are modifying an active rule for **Maychew Martyrs Memorial**. Changes here will update the grading rubric for all instructors assigned to this exam.
                                </p>
                                <hr class="opacity-25 my-4">
                                
                                <div class="p-3 rounded-3 bg-white bg-opacity-10 border border-white border-opacity-10 mb-4">
                                    <span class="d-block small fw-bold text-uppercase opacity-50 mb-2">Current Rule ID</span>
                                    <code class="text-info fs-6">EXAM-RL-{{$exam_rule_id}}</code>
                                </div>

                                <div class="small">
                                    <p class="mb-2 fw-bold text-primary">Pre-Update Checklist:</p>
                                    <ul class="list-unstyled opacity-75">
                                        <li class="mb-2"><i class="bi bi-check2-all me-2"></i> Verify Pass/Total ratio</li>
                                        <li class="mb-2"><i class="bi bi-check2-all me-2"></i> Clarify section breakdown</li>
                                        <li><i class="bi bi-check2-all me-2"></i> Inform assigned faculty</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-auto">
                @include('layouts.footer')
            </div>
        </div>
    </div>
</div>
@endsection