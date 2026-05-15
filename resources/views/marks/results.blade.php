@extends('layouts.app')

@section('content')
<style>
    /* High-Level UI for Results Analytics */
    .page-header h1 {
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -1px;
    }

    /* Modern Filter Control Station */
    .filter-station {
        background: #ffffff;
        border-radius: 20px;
        padding: 25px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        margin-bottom: 30px;
    }

    .filter-station label {
        font-weight: 700;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #64748b;
        margin-bottom: 8px;
    }

    .form-select-premium {
        background-color: #f1f5f9 !important;
        border: 2px solid transparent !important;
        border-radius: 12px !important;
        padding: 10px 15px !important;
        font-size: 0.9rem !important;
        transition: all 0.3s ease;
    }

    .form-select-premium:focus {
        background-color: #ffffff !important;
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1) !important;
    }

    /* Premium Results Grid */
    .results-card {
        background: #ffffff;
        border-radius: 24px;
        border: none;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    .premium-table thead th {
        background-color: #0f172a;
        color: #ffffff;
        padding: 18px 25px;
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        font-weight: 700;
        border: none;
    }

    .premium-table tbody tr {
        transition: all 0.2s;
    }

    .premium-table tbody tr:hover {
        background-color: #f8fafc;
    }

    .premium-table td {
        padding: 18px 25px;
        vertical-align: middle;
        color: #1e293b;
        border-bottom: 1px solid #f1f5f9;
    }

    /* Student Identity Styling */
    .avatar-placeholder {
        width: 40px;
        height: 40px;
        background: #e2e8f0;
        color: #64748b;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        font-size: 1.2rem;
    }

    /* Performance Badges */
    .grade-badge {
        padding: 6px 14px;
        border-radius: 10px;
        font-weight: 800;
        font-size: 0.85rem;
        display: inline-block;
        min-width: 45px;
        text-align: center;
    }

    /* Dynamic Logic Color Classes */
    .grade-A { background: #ecfdf5; color: #059669; border: 1px solid #10b981; }
    .grade-B { background: #eff6ff; color: #1e40af; border: 1px solid #3b82f6; }
    .grade-C { background: #fffbeb; color: #b45309; border: 1px solid #f59e0b; }
    .grade-F { background: #fef2f2; color: #dc2626; border: 1px solid #ef4444; }

    .point-text {
        font-family: 'JetBrains Mono', monospace;
        font-weight: 700;
        color: #0f172a;
        font-size: 1rem;
    }

    .btn-load {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%) !important;
        border: none !important;
        border-radius: 12px !important;
        padding: 11px 25px !important;
        font-weight: 700 !important;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
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
                            <i class="bi bi-trophy-fill text-primary me-2"></i> Academic Performance Registry
                        </h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="{{route('home')}}" class="text-decoration-none">Dashboard</a></li>
                                <li class="breadcrumb-item active fw-bold text-primary">Final Results</li>
                            </ol>
                        </nav>
                    </div>

                    <!-- Control Station (Filters) -->
                    <div class="filter-station shadow-sm border">
                        <form action="{{route('course.mark.list.show')}}" method="GET">
                            <div class="row g-3 align-items-end">
                                <div class="col-md-2">
                                    <label>Semester</label>
                                    <select class="form-select form-select-premium" name="semester_id" required>
                                        @isset($semesters)
                                            @foreach ($semesters as $semester)
                                            <option value="{{$semester->id}}">{{$semester->semester_name}}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label>Class Level</label>
                                    <select onchange="getSectionsAndCourses(this);" class="form-select form-select-premium" name="class_id">
                                        @isset($classes)
                                            <option selected disabled>Choose Class</option>
                                            @foreach ($classes as $school_class)
                                                <option value="{{$school_class->id}}">{{$school_class->class_name}}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label>Section</label>
                                    <select class="form-select form-select-premium" id="section-select" name="section_id" required>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label>Course / Subject</label>
                                    <select class="form-select form-select-premium" id="course-select" name="course_id" required>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary btn-load w-100">
                                        <i class="bi bi-arrow-repeat me-2"></i> Generate
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Results Sheet -->
                    <div class="results-card border shadow-sm mb-5">
                        <div class="table-responsive">
                            <table class="table premium-table mb-0">
                                <thead>
                                    <tr>
                                        <th style="width: 80px;">Profile</th>
                                        <th>Student Name</th>
                                        <th class="text-center">Total Score</th>
                                        <th class="text-center">GPA Points</th>
                                        <th class="text-center">Letter Grade</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @isset($marks)
                                        @if(count($marks) > 0)
                                            @foreach ($marks as $mark)
                                            <tr>
                                                <td>
                                                    <div class="avatar-placeholder shadow-sm">
                                                        <i class="bi bi-person-fill"></i>
                                                    </div>
                                                </td>
                                                <td class="fw-bold fs-6">
                                                    {{$mark->student->first_name}} {{$mark->student->last_name}}
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge bg-light text-dark border px-3 py-2 fw-bold" style="font-size: 0.9rem;">
                                                        {{$mark->final_marks}}
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="point-text text-primary">{{$mark->getAttribute('point')}}</span>
                                                </td>
                                                <td class="text-center">
                                                    @php 
                                                        $g = $mark->getAttribute('grade');
                                                        $colorClass = 'grade-B'; // Default
                                                        if(strpos($g, 'A') !== false) $colorClass = 'grade-A';
                                                        if(strpos($g, 'C') !== false || strpos($g, 'D') !== false) $colorClass = 'grade-C';
                                                        if(strpos($g, 'F') !== false) $colorClass = 'grade-F';
                                                    @endphp
                                                    <span class="grade-badge {{ $colorClass }}">
                                                        {{ $g }}
                                                    </span>
                                                </td>
                                            </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="5" class="py-5 text-center text-muted">
                                                    <i class="bi bi-clipboard-x display-1 opacity-10 d-block mb-3"></i>
                                                    No results found for this selection.
                                                </td>
                                            </tr>
                                        @endif
                                    @endisset
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                @include('layouts.footer')
            </div>
        </div>
    </div>
</div>

<script>
    function getSectionsAndCourses(obj) {
        var class_id = obj.options[obj.selectedIndex].value;
        var url = "{{route('get.sections.courses.by.classId')}}?class_id=" + class_id 

        fetch(url)
        .then((resp) => resp.json())
        .then(function(data) {
            var sectionSelect = document.getElementById('section-select');
            sectionSelect.options.length = 0;
            data.sections.unshift({'id': 0,'section_name': 'Select Section'})
            data.sections.forEach(function(section, key) {
                sectionSelect[key] = new Option(section.section_name, section.id);
            });

            var courseSelect = document.getElementById('course-select');
            courseSelect.options.length = 0;
            data.courses.unshift({'id': 0,'course_name': 'Select Course'})
            data.courses.forEach(function(course, key) {
                courseSelect[key] = new Option(course.course_name, course.id);
            });
        })
        .catch(function(error) {
            console.log(error);
        });
    }
</script>
@endsection