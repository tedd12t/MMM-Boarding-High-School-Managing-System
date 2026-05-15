@extends('layouts.app')

@section('content')
<style>
    /* High-Level UI for Teacher Management */
    .page-header h1 {
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -1px;
    }

    /* Modern Filter Surface */
    .filter-card {
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

    /* Premium Table Styling */
    .table-container {
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
        color: #475569;
        border-bottom: 1px solid #e2e8f0;
    }

    .premium-table tbody tr {
        transition: all 0.2s;
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

    /* Dropdown Branding */
    .btn-action-trigger {
        background: #ffffff !important;
        border: 1px solid #e2e8f0 !important;
        color: #0f172a !important;
        font-weight: 700 !important;
        font-size: 0.85rem !important;
        border-radius: 10px !important;
        padding: 8px 16px !important;
        transition: all 0.2s;
    }

    .btn-action-trigger:hover {
        background: #f1f5f9 !important;
        border-color: #cbd5e1 !important;
    }

    .dropdown-menu-premium {
        border: none !important;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
        border-radius: 12px !important;
        padding: 10px !important;
        min-width: 220px;
    }

    .dropdown-item-premium {
        border-radius: 8px !important;
        padding: 10px 15px !important;
        font-weight: 500 !important;
        font-size: 0.9rem !important;
        color: #475569 !important;
        display: flex;
        align-items: center;
    }

    .dropdown-item-premium:hover {
        background-color: #eff6ff !important;
        color: #2563eb !important;
    }

    .dropdown-item-premium i {
        font-size: 1.1rem;
        opacity: 0.7;
    }

    /* Class/Section Badges */
    .meta-badge {
        background: #f1f5f9;
        color: #475569;
        padding: 4px 10px;
        border-radius: 6px;
        font-weight: 700;
        font-size: 0.75rem;
        border: 1px solid #e2e8f0;
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
                            <i class="bi bi-journal-check text-primary me-2"></i> Faculty Course Manager
                        </h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="{{route('home')}}" class="text-decoration-none text-muted">Home</a></li>
                                <li class="breadcrumb-item active fw-bold text-primary">My Assigned Courses</li>
                            </ol>
                        </nav>
                    </div>

                    @include('session-messages')

                    <!-- Filter Surface -->
                    <div class="filter-card border shadow-sm">
                        <form action="{{route('course.teacher.list.show')}}" method="GET">
                            <input type="hidden" name="teacher_id" value="{{Auth::user()->id}}">
                            <div class="row align-items-end g-3">
                                <div class="col-md-4">
                                    <label class="filter-label">Select Academic Semester</label>
                                    <select class="form-select border-2" name="semester_id" required style="border-radius: 10px; padding: 10px;">
                                        @isset($semesters)
                                            @foreach ($semesters as $semester)
                                            <option value="{{$semester->id}}" {{($semester->id == request()->query('semester_id'))?'selected':''}}>{{$semester->semester_name}}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-primary w-100 shadow-sm" style="border-radius: 10px; padding: 11px; font-weight: 700;">
                                        <i class="bi bi-funnel-fill me-2"></i> Apply Filter
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Course Data Table -->
                    <div class="table-container shadow-sm border mb-5">
                        <table class="table premium-table mb-0">
                            <thead>
                                <tr>
                                    <th style="width: 35%;">Course / Subject</th>
                                    <th>Level / Grade</th>
                                    <th>Section</th>
                                    <th class="text-end">Management</th>
                                </tr>
                            </thead>
                            <tbody>
                                @isset($courses)
                                    @foreach ($courses as $course)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="me-3" style="width: 40px; height: 40px; background: #eff6ff; color: #3b82f6; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                                    <i class="bi bi-book-half"></i>
                                                </div>
                                                <span class="fw-800 fs-6">{{$course->course->course_name}}</span>
                                            </div>
                                        </td>
                                        <td><span class="meta-badge">{{$course->schoolClass->class_name}}</span></td>
                                        <td><span class="meta-badge text-primary border-primary border-opacity-25" style="background: #eff6ff;">{{$course->section->section_name}}</span></td>
                                        <td class="text-end">
                                            <div class="dropdown">
                                                <button class="btn btn-action-trigger dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                    Manage Course
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-premium shadow-lg">
                                                    <li><h6 class="dropdown-header text-uppercase small fw-bold opacity-50">Attendance</h6></li>
                                                    <li><a class="dropdown-item dropdown-item-premium" href="{{route('attendance.create.show', [
                                                        'class_id' => $course->schoolClass->id, 'section_id' => $course->section->id, 'course_id' => $course->course->id,
                                                        'class_name' => $course->schoolClass->class_name, 'section_name' => $course->section->section_name, 'course_name' => $course->course->course_name
                                                    ])}}"><i class="bi bi-calendar-plus me-2 text-primary"></i> Take Attendance</a></li>
                                                    
                                                    <li><a class="dropdown-item dropdown-item-premium border-bottom" href="{{route('attendance.list.show', [
                                                        'class_id' => $course->schoolClass->id, 'section_id' => $course->section->id, 'course_id' => $course->course->id,
                                                        'class_name' => $course->schoolClass->class_name, 'section_name' => $course->section->section_name, 'course_name' => $course->course->course_name
                                                    ])}}"><i class="bi bi-calendar-range me-2 text-primary"></i> View Records</a></li>

                                                    <li><h6 class="dropdown-header text-uppercase small fw-bold opacity-50 mt-2">Materials</h6></li>
                                                    <li><a class="dropdown-item dropdown-item-premium" href="{{route('course.syllabus.index', ['course_id' => $course->course->id])}}"><i class="bi bi-journal-text me-2 text-info"></i> Course Syllabus</a></li>
                                                    <li><a class="dropdown-item dropdown-item-premium" href="{{route('assignment.create', ['class_id' => $course->schoolClass->id, 'section_id' => $course->section->id, 'course_id' => $course->course->id, 'semester_id' => request()->query('semester_id')])}}"><i class="bi bi-file-earmark-plus me-2 text-info"></i> Create Assignment</a></li>
                                                    <li><a class="dropdown-item dropdown-item-premium border-bottom" href="{{route('assignment.list.show', ['course_id' => $course->course->id])}}"><i class="bi bi-files me-2 text-info"></i> View Assignments</a></li>

                                                    <li><h6 class="dropdown-header text-uppercase small fw-bold opacity-50 mt-2">Grading</h6></li>
                                                    <li><a class="dropdown-item dropdown-item-premium" href="{{route('course.mark.create', ['class_id' => $course->schoolClass->id, 'class_name' => $course->schoolClass->class_name, 'section_id' => $course->section->id, 'section_name' => $course->section->section_name, 'course_id' => $course->course->id, 'course_name' => $course->course->course_name, 'semester_id' => $selected_semester_id])}}"><i class="bi bi-award me-2 text-success"></i> Input Marks</a></li>
                                                    <li><a class="dropdown-item dropdown-item-premium" href="{{route('course.mark.list.show', ['class_id' => $course->schoolClass->id, 'class_name' => $course->schoolClass->class_name, 'section_id' => $course->section->id, 'section_name' => $course->section->section_name, 'course_id' => $course->course->id, 'course_name' => $course->course->course_name, 'semester_id' => $selected_semester_id])}}"><i class="bi bi-trophy me-2 text-success"></i> Final Results</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
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