@extends('layouts.app')

@section('content')
<style>
    /* High-Level UI for Exam Management */
    .page-header h1 {
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -1px;
    }

    /* Modern Filter Surface */
    .filter-surface {
        background: #ffffff;
        border-radius: 16px;
        padding: 20px 25px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        margin-bottom: 25px;
    }

    .filter-label {
        font-weight: 700;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #64748b;
        margin-bottom: 8px;
        display: block;
    }

    /* Premium Table Architecture */
    .data-card {
        background: #ffffff;
        border-radius: 20px;
        border: none;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    .premium-table thead th {
        background-color: #f8fafc;
        padding: 18px 25px;
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        font-weight: 700;
        color: #475569;
        border-bottom: 1px solid #e2e8f0;
    }

    .premium-table tbody tr {
        transition: all 0.2s ease;
    }

    .premium-table tbody tr:hover {
        background-color: #f1f5f9;
    }

    .premium-table td {
        padding: 18px 25px;
        vertical-align: middle;
        color: #1e293b;
        font-weight: 500;
        border-bottom: 1px solid #f1f5f9;
    }

    /* Status & Time Badges */
    .time-badge {
        background: #f1f5f9;
        color: #475569;
        padding: 4px 10px;
        border-radius: 6px;
        font-family: 'JetBrains Mono', monospace; /* Or standard monospace */
        font-size: 0.8rem;
        border: 1px solid #e2e8f0;
        display: inline-flex;
        align-items: center;
    }

    .course-pill {
        background: #eff6ff;
        color: #2563eb;
        padding: 4px 12px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.75rem;
        border: 1px solid #dbeafe;
    }

    /* Action Pillar Styling */
    .btn-action-pill {
        border-radius: 10px !important;
        padding: 6px 14px !important;
        font-size: 0.8rem !important;
        font-weight: 700 !important;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.2s;
    }

    .btn-add {
        background-color: #ffffff !important;
        border: 1px solid #10b981 !important;
        color: #059669 !important;
    }

    .btn-add:hover {
        background-color: #10b981 !important;
        color: #ffffff !important;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }

    .btn-view {
        background-color: #ffffff !important;
        border: 1px solid #3b82f6 !important;
        color: #2563eb !important;
    }

    .btn-view:hover {
        background-color: #3b82f6 !important;
        color: #ffffff !important;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
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
                            <i class="bi bi-file-earmark-spreadsheet text-primary me-2"></i> Examination Registry
                        </h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="{{route('home')}}" class="text-decoration-none text-muted">Home</a></li>
                                <li class="breadcrumb-item active fw-bold text-primary">Exams</li>
                            </ol>
                        </nav>
                    </div>

                    @include('session-messages')

                    <!-- Filter Surface -->
                    <div class="filter-surface shadow-sm">
                        <form action="{{route('exam.list.show')}}" method="GET">
                            <div class="row align-items-end g-3">
                                <div class="col-md-3">
                                    <label class="filter-label">Academic Level</label>
                                    <select class="form-select border-2" name="class_id" style="border-radius: 10px;">
                                        @isset($classes)
                                            @foreach ($classes as $school_class)
                                                <option value="{{$school_class->id}}">{{$school_class->class_name}}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="filter-label">Target Semester</label>
                                    <select class="form-select border-2" name="semester_id" style="border-radius: 10px;">
                                        @isset($semesters)
                                            @foreach ($semesters as $semester)
                                                <option value="{{$semester->id}}">{{$semester->semester_name}}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary w-100 shadow-sm" style="border-radius: 10px; padding: 10px; font-weight: 700;">
                                        <i class="bi bi-funnel-fill me-2"></i> Filter
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Main List Card -->
                    <div class="data-card border shadow-sm mb-5">
                        <div class="table-responsive">
                            <table class="table premium-table mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col">Exam Title</th>
                                        <th scope="col">Subject</th>
                                        <th scope="col">Window Opens</th>
                                        <th scope="col">Window Closes</th>
                                        <th scope="col" class="text-end">Management</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($exams as $exam)
                                        {{-- ADMIN ROLE LOGIC --}}
                                        @if (Auth::user()->role == "admin")
                                        <tr>
                                            <td>
                                                <span class="fw-800 text-dark">{{$exam->exam_name}}</span>
                                                <div class="text-muted small mt-1">Ref: EXM-{{$exam->id}}</div>
                                            </td>
                                            <td><span class="course-pill">{{$exam->course->course_name}}</span></td>
                                            <td><span class="time-badge"><i class="bi bi-calendar-event me-2"></i>{{$exam->start_date}}</span></td>
                                            <td><span class="time-badge border-warning"><i class="bi bi-calendar-x me-2"></i>{{$exam->end_date}}</span></td>
                                            <td class="text-end">
                                                <div class="btn-group gap-2">
                                                    <a href="{{route('exam.rule.create', ['exam_id' => $exam->id])}}" class="btn btn-action-pill btn-add">
                                                        <i class="bi bi-plus-lg me-1"></i> Rule
                                                    </a>
                                                    <a href="{{route('exam.rule.show', ['exam_id' => $exam->id])}}" class="btn btn-action-pill btn-view">
                                                        <i class="bi bi-eye-fill me-1"></i> View
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        
                                        {{-- TEACHER ROLE LOGIC --}}
                                        @elseif(Auth::user()->role == "teacher")
                                            @foreach ($teacher_courses as $teacher_course)
                                                @if ($exam->course->id == $teacher_course->course_id)
                                                <tr>
                                                    <td><span class="fw-800 text-dark">{{$exam->exam_name}}</span></td>
                                                    <td><span class="course-pill">{{$exam->course->course_name}}</span></td>
                                                    <td><span class="time-badge">{{$exam->start_date}}</span></td>
                                                    <td><span class="time-badge border-warning">{{$exam->end_date}}</span></td>
                                                    <td class="text-end">
                                                        <div class="btn-group gap-2">
                                                            <a href="{{route('exam.rule.create', ['exam_id' => $exam->id])}}" class="btn btn-action-pill btn-add">
                                                                <i class="bi bi-plus-lg me-1"></i> Rule
                                                            </a>
                                                            <a href="{{route('exam.rule.show', ['exam_id' => $exam->id])}}" class="btn btn-action-pill btn-view">
                                                                <i class="bi bi-eye-fill me-1"></i> View
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endif
                                            @endforeach
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
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