@extends('layouts.app')

@section('content')
<style>
    /* High-Level UI for Academic Assessment */
    .page-header h1 {
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -1px;
    }

    /* Professional Notification Cards */
    .status-alert {
        border-radius: 12px;
        padding: 15px 20px;
        border: none;
        display: flex;
        align-items: center;
        margin-bottom: 15px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }
    .status-alert-info { background-color: #eff6ff; color: #1e40af; border-left: 4px solid #3b82f6; }
    .status-alert-success { background-color: #ecfdf5; color: #065f46; border-left: 4px solid #10b981; }

    /* The "Command Bar" for Course Info */
    .context-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 25px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        margin-bottom: 25px;
    }

    /* Premium Grading Sheet (Table) */
    .grading-sheet-card {
        background: #ffffff;
        border-radius: 20px;
        border: none;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    .grading-table thead th {
        background-color: #0f172a; /* High-contrast slate */
        color: #ffffff;
        padding: 18px 20px;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 700;
        white-space: nowrap;
    }

    .grading-table thead th a {
        color: #60a5fa !important;
        text-decoration: none;
    }

    .grading-table tbody tr {
        transition: background 0.2s;
    }

    .grading-table tbody tr:hover {
        background-color: #f8fafc;
    }

    .grading-table td {
        padding: 12px 20px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
        color: #1e293b;
        font-weight: 500;
    }

    /* Input Field Styling */
    .mark-input {
        background-color: #f1f5f9 !important;
        border: 2px solid transparent !important;
        border-radius: 8px !important;
        padding: 8px 12px !important;
        font-weight: 700 !important;
        width: 100px;
        transition: all 0.2s;
        text-align: center;
    }

    .mark-input:focus {
        background-color: #ffffff !important;
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1) !important;
        transform: scale(1.05);
    }

    /* Action Bar (Footer) */
    .action-bar {
        background: #f8fafc;
        padding: 20px 30px;
        border-top: 1px solid #e2e8f0;
    }

    .btn-save-premium {
        background: linear-gradient(135deg, #0f172a 0%, #334155 100%) !important;
        color: white !important;
        border: none !important;
        border-radius: 10px !important;
        padding: 12px 35px !important;
        font-weight: 700 !important;
        box-shadow: 0 4px 12px rgba(15, 23, 42, 0.2);
    }

    .btn-submit-final {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
        color: white !important;
        border: none !important;
        border-radius: 10px !important;
        padding: 12px 35px !important;
        font-weight: 700 !important;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
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
                    <div class="d-md-flex align-items-center justify-content-between mb-4">
                        <div>
                            <h1 class="page-header mb-1">
                                <i class="bi bi-award-fill text-primary me-2"></i> Academic Grading Terminal
                            </h1>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item"><a href="{{route('home')}}" class="text-decoration-none">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="{{url()->previous()}}" class="text-decoration-none">Course Manager</a></li>
                                    <li class="breadcrumb-item active fw-bold text-primary">Mark Entry</li>
                                </ol>
                            </nav>
                        </div>
                    </div>

                    @include('session-messages')

                    <!-- Dynamic Alerts (Original Logic) -->
                    @if ($academic_setting['marks_submission_status'] == "on")
                        <div class="status-alert status-alert-info">
                            <i class="bi bi-unlock-fill fs-4 me-3"></i>
                            <div>
                                <span class="fw-bold d-block">Submission Window Active</span>
                                <small>You are permitted to submit final marks for this semester.</small>
                            </div>
                        </div>
                    @endif

                    @if ($final_marks_submitted)
                        <div class="status-alert status-alert-success">
                            <i class="bi bi-check-circle-fill fs-4 me-3"></i>
                            <div>
                                <span class="fw-bold d-block">Finalized</span>
                                <small>Marks have been submitted and locked for this course.</small>
                            </div>
                        </div>
                    @endif

                    <!-- Context Overview -->
                    <div class="context-card border shadow-sm">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <span class="text-muted small text-uppercase fw-bold d-block mb-1">Class & Section</span>
                                <h4 class="fw-bold mb-0">Class #{{request()->query('class_name')}} | {{request()->query('section_name')}}</h4>
                            </div>
                            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                                <span class="text-muted small text-uppercase fw-bold d-block mb-1">Curriculum Subject</span>
                                <h4 class="fw-bold text-primary mb-0"><i class="bi bi-book-half me-2"></i>{{request()->query('course_name')}}</h4>
                            </div>
                        </div>
                    </div>

                    <!-- Main Grading Form -->
                    <form action="{{route('course.mark.store')}}" method="POST">
                        @csrf
                        <input type="hidden" name="session_id" value="{{$current_school_session_id}}">
                        
                        <div class="grading-sheet-card border shadow-sm mb-5">
                            <div class="table-responsive">
                                <table class="table grading-table mb-0">
                                    <thead>
                                        <tr>
                                            <th style="width: 300px;">Student Identity</th>
                                            @isset($exams)
                                                @foreach ($exams as $exam)
                                                <th class="text-center">
                                                    <a href="{{route('exam.rule.show', ['exam_id' => $exam->id])}}" 
                                                       data-bs-toggle="tooltip" 
                                                       title="Rule: Max {{ $exam_rules_by_exam_id[$exam->id] ?? 'N/A' }}">
                                                        {{$exam->exam_name}} <i class="bi bi-info-circle small ms-1"></i>
                                                    </a>
                                                </th>
                                                @endforeach
                                            @endisset
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- LOGIC: Existing Marks --}}
                                        @isset($exams)
                                            @isset($students_with_marks)
                                                @foreach ($students_with_marks as $id => $students_with_mark)
                                                    @php $markedExamCount = 0; @endphp
                                                    <tr>
                                                        <td class="fw-bold"><i class="bi bi-person-circle me-2 opacity-50"></i>{{$students_with_mark[0]->student->first_name}} {{$students_with_mark[0]->student->last_name}}</td>
                                                        
                                                        @foreach ($students_with_mark as $st)
                                                            @php $currentExamId = $exams[$markedExamCount]->id; @endphp
                                                            <td class="text-center">
                                                                <input type="number" step="0.01" min="0" 
                                                                    @if($exam_rules_by_exam_id->has($currentExamId)) max="{{$exam_rules_by_exam_id[$currentExamId]}}" @endif 
                                                                    class="mark-input form-control d-inline" 
                                                                    name="student_mark[{{$students_with_mark[0]->student->id}}][{{$currentExamId}}]" 
                                                                    value="{{$st->marks}}">
                                                            </td>
                                                            @php $markedExamCount++; @endphp
                                                        @endforeach

                                                        {{-- Fill empty columns --}}
                                                        @php
                                                            $gt = count($exams) - count($students_with_mark);
                                                        @endphp
                                                        @for ($i = 0; $i < $gt; $i++)
                                                            @php $currentExamId = $exams[$markedExamCount]->id; @endphp
                                                            <td class="text-center">
                                                                <input type="number" step="0.01" min="0" 
                                                                    @if($exam_rules_by_exam_id->has($currentExamId)) max="{{$exam_rules_by_exam_id[$currentExamId]}}" @endif 
                                                                    class="mark-input form-control d-inline" 
                                                                    name="student_mark[{{$students_with_mark[0]->student->id}}][{{$currentExamId}}]">
                                                            </td>
                                                            @php $markedExamCount++; @endphp
                                                        @endfor
                                                    </tr>
                                                @endforeach
                                            @endisset
                                        @endisset

                                        {{-- LOGIC: No Marks Recorded Yet --}}
                                        @if(count($students_with_marks) < 1)
                                            @foreach ($sectionStudents as $sectionStudent)
                                                <tr>
                                                    <td class="fw-bold"><i class="bi bi-person-circle me-2 opacity-50"></i>{{$sectionStudent->student->first_name}} {{$sectionStudent->student->last_name}}</td>
                                                    @isset($exams)
                                                        @foreach ($exams as $exam)
                                                            <td class="text-center">
                                                                <input type="number" step="0.01" min="0" 
                                                                    @if($exam_rules_by_exam_id->has($exam->id)) max="{{$exam_rules_by_exam_id[$exam->id]}}" @endif 
                                                                    class="mark-input form-control d-inline" 
                                                                    name="student_mark[{{$sectionStudent->student->id}}][{{$exam->id}}]">
                                                            </td>
                                                        @endforeach
                                                    @endisset
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>

                            <!-- Industrial Action Bar -->
                            <div class="action-bar d-flex align-items-center justify-content-between">
                                <div>
                                    @if (!$final_marks_submitted && count($exams) > 0 && $academic_setting['marks_submission_status'] == "on")
                                        <a href="{{route('course.final.mark.submit.show', ['class_id' => $class_id, 'class_name' => request()->query('class_name'), 'section_id' => $section_id, 'section_name' => request()->query('section_name'), 'course_id' => $course_id, 'course_name' => request()->query('course_name'), 'semester_id' => $semester_id])}}" 
                                           class="btn btn-submit-final" 
                                           onclick="return confirm('Are you sure? This will lock the marks for the entire semester.')">
                                            <i class="bi bi-send-check-fill me-2"></i> Submit Final Marks
                                        </a>
                                    @endif
                                </div>
                                
                                <div>
                                    @if(!$final_marks_submitted && count($exams) > 0)
                                        <button type="submit" class="btn btn-save-premium px-5">
                                            <i class="bi bi-save2-fill me-2"></i> Save Progress
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Hidden Meta Logic --}}
                        <input type="hidden" name="studentCount" value="{{count($sectionStudents)}}">
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

<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
@endsection