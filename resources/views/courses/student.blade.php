@extends('layouts.app')

@section('content')
<style>
    /* High-Level UI for Course Management */
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

    /* Modern Table Container */
    .course-card-container {
        background: #ffffff;
        border-radius: 20px;
        border: none;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    .premium-table thead th {
        background-color: #f8fafc;
        padding: 18px 25px;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 700;
        color: #64748b;
        border-bottom: 1px solid #e2e8f0;
    }

    .premium-table tbody tr {
        transition: all 0.2s;
    }

    .premium-table tbody tr:hover {
        background-color: #f1f5f9;
    }

    .premium-table td {
        padding: 20px 25px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
    }

    /* Course Icon Logic */
    .course-icon-box {
        width: 45px;
        height: 45px;
        background: #eff6ff;
        color: #3b82f6;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        margin-right: 15px;
        font-size: 1.2rem;
    }

    /* High-Level Action Buttons */
    .btn-action-pill {
        border-radius: 50px !important;
        padding: 6px 16px !important;
        font-size: 0.8rem !important;
        font-weight: 700 !important;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: 1px solid #e2e8f0 !important;
        background: white !important;
        color: #475569 !important;
        transition: all 0.2s;
    }

    .btn-action-pill:hover {
        background: #3b82f6 !important;
        color: white !important;
        border-color: #3b82f6 !important;
        box-shadow: 0 4px 10px rgba(59, 130, 246, 0.3);
        transform: translateY(-1px);
    }

    .btn-action-pill i {
        margin-right: 6px;
    }

    /* Empty State */
    .empty-courses {
        padding: 80px 20px;
        text-align: center;
        color: #94a3b8;
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
                            <i class="bi bi-journal-bookmark-fill text-primary me-2"></i> Academic Curriculum
                        </h1>
                        <nav aria-label="breadcrumb" class="mt-2">
                            <ol class="breadcrumb breadcrumb-premium mb-0">
                                <li class="breadcrumb-item"><a href="{{route('home')}}" class="text-decoration-none text-muted">Home</a></li>
                                <li class="breadcrumb-item active fw-bold text-primary">My Courses</li>
                            </ol>
                        </nav>
                    </div>

                    @include('session-messages')

                    <!-- Courses List Card -->
                    <div class="course-card-container border shadow-sm mt-4">
                        <table class="table premium-table mb-0">
                            <thead>
                                <tr>
                                    <th style="width: 45%;">Course Information</th>
                                    <th class="text-end">Learning & Assessment</th>
                                </tr>
                            </thead>
                            <tbody>
                                @isset($courses)
                                    @if(count($courses) > 0)
                                        @foreach ($courses as $course)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="course-icon-box shadow-sm">
                                                        <i class="bi bi-book-half"></i>
                                                    </div>
                                                    <div>
                                                        <span class="d-block fw-800 text-dark fs-6">{{$course->course_name}}</span>
                                                        <small class="text-muted text-uppercase fw-bold" style="font-size: 0.65rem;">Code: CRS-{{$course->id}}0{{$course->semester_id}}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-end">
                                                <div class="btn-group gap-2">
                                                    {{-- Original Logic Parameters Preserved --}}
                                                    <a href="{{route('course.mark.show', [
                                                        'course_id' => $course->id,
                                                        'course_name' => $course->course_name,
                                                        'semester_id' => $course->semester_id,
                                                        'class_id'  => $class_info->class_id,
                                                        'session_id' => $course->session_id,
                                                        'section_id' => $class_info->section_id,
                                                        'student_id' => Auth::user()->id
                                                        ])}}" class="btn btn-action-pill">
                                                        <i class="bi bi-trophy"></i> Marks
                                                    </a>
                                                    
                                                    <a href="{{route('course.syllabus.index', ['course_id'  => $course->id])}}" class="btn btn-action-pill">
                                                        <i class="bi bi-journal-text"></i> Syllabus
                                                    </a>
                                                    
                                                    <a href="{{route('assignment.list.show', ['course_id' => $course->id])}}" class="btn btn-action-pill">
                                                        <i class="bi bi-pencil-square"></i> Assignments
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="2" class="empty-courses">
                                                <i class="bi bi-journals display-1 opacity-25"></i>
                                                <p class="mt-3 fs-5 fw-bold">No registered courses found.</p>
                                                <p class="small">Please contact the administration if you believe this is an error.</p>
                                            </td>
                                        </tr>
                                    @endif
                                @endisset
                            </tbody>
                        </table>
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
