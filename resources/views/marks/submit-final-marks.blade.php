@extends('layouts.app')

@section('content')
<style>
    .page-header h1 {
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -1px;
    }
    .course-banner {
        background: #ffffff;
        border-radius: 16px;
        padding: 25px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        margin-bottom: 30px;
        border-left: 6px solid #3b82f6;
    }
    .grading-container {
        background: #ffffff;
        border-radius: 20px;
        border: none;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    .grading-table thead th {
        background-color: #0f172a;
        color: #ffffff;
        padding: 18px 20px;
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        font-weight: 700;
    }

    .grading-table tbody tr {
        transition: background 0.2s;
    }

    .grading-table td {
        padding: 15px 20px;
        vertical-align: middle;
        color: #1e293b;
        border-bottom: 1px solid #f1f5f9;
    }

    /* Input Styling - Differentiation */
    .calculated-field {
        background-color: #f8fafc !important;
        border: 1px solid #e2e8f0 !important;
        color: #64748b !important;
        font-weight: 800 !important;
        text-align: center;
        border-radius: 8px;
        cursor: not-allowed;
    }

    .final-input {
        background-color: #ffffff !important;
        border: 2px solid #3b82f6 !important; /* Blue to invite interaction */
        color: #0f172a !important;
        font-weight: 800 !important;
        text-align: center;
        border-radius: 8px;
        transition: all 0.2s;
    }

    .final-input:focus {
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15) !important;
        transform: scale(1.02);
    }

    .note-input {
        border-radius: 8px !important;
        font-size: 0.85rem !important;
        border: 1px solid #cbd5e1 !important;
    }

    /* Bottom Action Bar */
    .grading-footer {
        background: #f8fafc;
        padding: 25px 35px;
        border-top: 1px solid #e2e8f0;
    }

    .btn-finalize {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%) !important;
        color: white !important;
        border: none !important;
        border-radius: 12px !important;
        padding: 12px 45px !important;
        font-weight: 700 !important;
        box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.3);
        transition: all 0.2s;
    }

    .btn-finalize:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 20px -5px rgba(59, 130, 246, 0.4);
    }
</style>

<div class="container-fluid px-4">
    <div class="row">
        @include('layouts.left-menu')

        <div class="col-lg-10">
            <div class="row pt-4">
                <div class="col-12 ps-lg-5">
                    
                    <!-- Header Section -->
                    <div class="mb-4">
                        <h1 class="page-header mb-1">
                            <i class="bi bi-award-fill text-primary me-2"></i> Final Assessment Verification
                        </h1>
                        <p class="text-muted">Review calculated aggregates and commit final marks to official records.</p>
                    </div>

                    @include('session-messages')

                    <!-- Context Banner -->
                    <div class="course-banner shadow-sm d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-primary small text-uppercase fw-bold" style="letter-spacing: 2px;">School Control</span>
                            <h3 class="fw-bold mb-0 mt-1">Class {{$class_name}} • Section #{{$section_name}}</h3>
                        </div>
                        <div class="text-end">
                            <span class="text-muted small text-uppercase fw-bold" style="letter-spacing: 1px;">Curriculum Subject</span>
                            <h4 class="fw-bold text-dark mb-0"><i class="bi bi-compass me-2"></i>{{$course_name}}</h4>
                        </div>
                    </div>

                    <!-- Grading Terminal -->
                    <form action="{{route('course.final.mark.submit.store')}}" method="POST">
                        @csrf
                        <input type="hidden" name="session_id" value="{{$current_school_session_id}}">
                        
                        <div class="grading-container border shadow-sm mb-5">
                            <div class="table-responsive">
                                <table class="table grading-table mb-0">
                                    <thead>
                                        <tr>
                                            <th style="width: 250px;">Student Identity</th>
                                            <th class="text-center" style="width: 150px;">Calculated Aggregate</th>
                                            <th class="text-center" style="width: 150px;">Final Adjusted Mark</th>
                                            <th>Professional Note / Reason</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @isset($students_with_marks)
                                            @foreach ($students_with_marks as $id => $students_with_mark)
                                            <tr>
                                                <td class="fw-bold">
                                                    <i class="bi bi-person-circle me-2 opacity-50"></i>
                                                    {{$students_with_mark[0]->student->first_name}} {{$students_with_mark[0]->student->last_name}}
                                                </td>
                                                
                                                @php $calculated_marks = 0; @endphp
                                                @foreach ($students_with_mark as $st)
                                                    @php $calculated_marks += $st->marks; @endphp
                                                @endforeach

                                                <td class="text-center">
                                                    <input type="number" step="0.01" class="form-control calculated-field" 
                                                           name="calculated_mark[{{$students_with_mark[0]->student->id}}]" 
                                                           value="{{$calculated_marks}}" readonly>
                                                </td>
                                                <td class="text-center">
                                                    <input type="number" step="0.01" class="form-control final-input shadow-sm" 
                                                           name="final_mark[{{$students_with_mark[0]->student->id}}]" 
                                                           placeholder="0.00" required>
                                                </td>
                                                <td>
                                                    <textarea class="form-control note-input" rows="1" 
                                                              name="note[{{$students_with_mark[0]->student->id}}]" 
                                                              placeholder="e.g., Rounded from best performers..."></textarea>
                                                </td>
                                            </tr>
                                            @endforeach
                                        @endisset
                                    </tbody>
                                </table>
                            </div>

                            <!-- Industrial Action Footer -->
                            <div class="grading-footer text-end">
                                <a href="{{url()->previous()}}" class="btn btn-link text-muted text-decoration-none fw-bold me-4">
                                    <i class="bi bi-arrow-left me-1"></i> Back to Courses
                                </a>
                                <button type="submit" class="btn btn-finalize shadow-lg">
                                    <i class="bi bi-shield-check me-2"></i> Commit Final Marks
                                </button>
                            </div>
                        </div>

                        {{-- Hidden Logic Meta --}}
                        <input type="hidden" name="semester_id" value="{{$semester_id}}">
                        <input type="hidden" name="class_id" value="{{$class_id}}">
                        <input type="hidden" name="section_id" value="{{$section_id}}">
                        <input type="hidden" name="course_id" value="{{$course_id}}">
                    </form>
                </div>
            </div>

            <div class="mt-4">
                @include('layouts.footer')
            </div>
        </div>
    </div>
</div>
@endsection
