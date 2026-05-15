@extends('layouts.app')
@section('content')
<!-- High-Level CSS for Settings Page -->
<style>
    .settings-header {
        margin-bottom: 2rem;
        padding-left: 1rem;
    }
    
    .settings-header h1 {
        font-weight: 800;
        letter-spacing: -1px;
        color: #0f172a;
    }

    /* Professional Card Styling */
    .management-card {
        background: #ffffff;
        border: 1px solid #e2e8f0 !important;
        border-radius: 16px !important;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03) !important;
        transition: all 0.3s ease;
        height: auto;
    }

    .management-card:hover {
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1) !important;
        transform: translateY(-2px);
    }

    .card-title-area {
        display: flex;
        align-items: center;
        margin-bottom: 1.25rem;
        border-bottom: 1px solid #f1f5f9;
        padding-bottom: 10px;
    }

    .card-title-area h6 {
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 0;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
    }

    /* Refined Form Controls */
    .form-control-modern {
        border-radius: 10px !important;
        border: 1px solid #cbd5e1 !important;
        padding: 0.6rem 1rem !important;
        font-size: 0.9rem !important;
        background-color: #f8fafc !important;
    }

    .form-control-modern:focus {
        background-color: #fff !important;
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1) !important;
    }

    .form-label-custom {
        font-weight: 600;
        font-size: 0.85rem;
        color: #475569;
        margin-bottom: 0.4rem;
    }

    /* Modern Warning Box */
    .info-box {
        background: #fef2f2;
        border-left: 4px solid #ef4444;
        padding: 12px;
        border-radius: 8px;
        margin-bottom: 1.5rem;
    }

    .info-box.blue {
        background: #eff6ff;
        border-left: 4px solid #3b82f6;
    }

    /* Submit Button */
    .btn-action {
        background: #0f172a !important;
        color: white !important;
        border-radius: 10px !important;
        font-weight: 600 !important;
        padding: 8px 20px !important;
        border: none !important;
        width: 100%;
        transition: all 0.2s;
    }

    .btn-action:hover {
        background: #334155 !important;
        box-shadow: 0 4px 12px rgba(15, 23, 42, 0.2);
    }
    /* 1. DEFINE SIDEBAR WIDTH */
:root {
    --sidebar-width: 260px;
    --navbar-height: 70px;
}

/* 2. PIN SIDEBAR BELOW NAVBAR */
.sidebar-wrapper {
    position: fixed;
    top: var(--navbar-height); /* Starts right after navbar */
    left: 0;
    width: var(--sidebar-width);
    height: calc(100vh - var(--navbar-height));
    background: #0f172a !important;
    border-right: 1px solid rgba(255, 255, 255, 0.05);
    z-index: 1000;
    overflow-y: auto;
}

/* 3. THE KEY FIX: PUSH MAIN CONTENT TO THE RIGHT */
main {
    margin-left: var(--sidebar-width); /* Pushes content right */
    padding-top: 20px;
    width: calc(100% - var(--sidebar-width)); /* Ensures full width minus sidebar */
    min-height: calc(100vh - var(--navbar-height));
    display: block;
    position: relative;
}

/* 4. FIX FOR THE DASHBOARD ROW */
/* Since the sidebar is fixed, we remove the sidebar column from the grid logic */
.dashboard-content-col {
    width: 100% !important;
    flex: 0 0 100% !important;
    max-width: 100% !important;
    padding-left: 30px !important;
    padding-right: 30px !important;
}

/* Fix Navbar to stay above everything but respect the shift if needed */
.navbar {
    height: var(--navbar-height);
    position: fixed;
    top: 0;
    width: 100%;
    z-index: 1050;
}
</style>
<script src="{{ asset('js/masonry.pkgd.min.js') }}"></script>
<div class="container-fluid px-4">
    <div class="row g-0">
        @include('layouts.left-menu')
code
Code
<div class="col-lg-10">
        <div class="settings-header pt-4">
            <h1><i class="bi bi-gear-wide-connected text-primary me-2"></i> Academic Control Center</h1>
            <p class="text-muted">Configure your school structure, sessions, and permissions.</p>
            @include('session-messages')
        </div>

        <div class="row mt-2" data-masonry='{"percentPosition": true }'>
            
            {{-- 1. CREATE SESSION --}}
            @if ($latest_school_session_id == $current_school_session_id)
            <div class="col-md-4 mb-4">
                <div class="p-4 management-card">
                    <div class="card-title-area">
                        <i class="bi bi-calendar-plus text-primary me-2"></i>
                        <h6>Create New Session</h6>
                    </div>
                    <div class="info-box">
                        <small class="text-danger d-block">
                            <i class="bi bi-shield-exclamation me-1"></i> Create one session per year. The last created becomes the active one.
                        </small>
                    </div>
                    <form action="{{route('school.session.store')}}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label-custom">Academic Year Name</label>
                            <input type="text" class="form-control form-control-modern" placeholder="e.g. 2024 - 2025" name="session_name" required>
                        </div>
                        <button class="btn btn-action" type="submit"><i class="bi bi-plus-circle me-2"></i> Initialize Session</button>
                    </form>
                </div>
            </div>
            @endif

            {{-- 2. BROWSE SESSION --}}
            <div class="col-md-4 mb-4">
                <div class="p-4 management-card">
                    <div class="card-title-area">
                        <i class="bi bi-search text-primary me-2"></i>
                        <h6>Browse Archives</h6>
                    </div>
                    <p class="text-muted small mb-3">Switch view to historical data from previous sessions.</p>
                    <form action="{{route('school.session.browse')}}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label-custom">Select Target Session</label>
                            <select class="form-select form-select-modern" name="session_id" required>
                                @isset($school_sessions)
                                    @foreach ($school_sessions as $school_session)
                                        <option value="{{$school_session->id}}">{{$school_session->session_name}}</option>
                                    @endforeach
                                @endisset
                            </select>
                        </div>
                        <button class="btn btn-action" type="submit"><i class="bi bi-arrow-right-circle me-2"></i> Switch View</button>
                    </form>
                </div>
            </div>

            {{-- 3. CREATE SEMESTER --}}
            @if ($latest_school_session_id == $current_school_session_id)
            <div class="col-md-4 mb-4">
                <div class="p-4 management-card">
                    <div class="card-title-area">
                        <i class="bi bi-layers text-primary me-2"></i>
                        <h6>Initialize Semester</h6>
                    </div>
                    <form action="{{route('school.semester.create')}}" method="POST">
                        @csrf
                        <input type="hidden" name="session_id" value="{{$current_school_session_id}}">
                        <div class="mb-2">
                            <label class="form-label-custom">Semester Title</label>
                            <input type="text" class="form-control form-control-modern" placeholder="First Semester" name="semester_name" required>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label-custom">Start Date</label>
                                <input type="date" class="form-control form-control-modern" name="start_date" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label-custom">End Date</label>
                                <input type="date" class="form-control form-control-modern" name="end_date" required>
                            </div>
                        </div>
                        <button type="submit" class="mt-3 btn btn-action"><i class="bi bi-check-circle me-2"></i> Save Semester</button>
                    </form>
                </div>
            </div>

            {{-- 4. ATTENDANCE TYPE --}}
            <div class="col-md-4 mb-4">
                <div class="p-4 management-card">
                    <div class="card-title-area">
                        <i class="bi bi-fingerprint text-primary me-2"></i>
                        <h6>Attendance Logic</h6>
                    </div>
                    <div class="info-box">
                        <small class="text-danger d-block">Do not switch types during an active semester.</small>
                    </div>
                    <form action="{{route('school.attendance.type.update')}}" method="POST">
                        @csrf
                        <div class="form-check p-3 border rounded-3 mb-2 bg-white">
                            <input class="form-check-input ms-0 me-2" type="radio" name="attendance_type" id="attendance_type_section" {{($academic_setting->attendance_type == 'section')?'checked':''}} value="section">
                            <label class="form-check-label fw-bold" for="attendance_type_section">By Section</label>
                        </div>
                        <div class="form-check p-3 border rounded-3 mb-3 bg-white">
                            <input class="form-check-input ms-0 me-2" type="radio" name="attendance_type" id="attendance_type_course" {{($academic_setting->attendance_type == 'course')?'checked':''}} value="course">
                            <label class="form-check-label fw-bold" for="attendance_type_course">By Course</label>
                        </div>
                        <button type="submit" class="btn btn-action"><i class="bi bi-save me-2"></i> Update Policy</button>
                    </form>
                </div>
            </div>

            {{-- 5. CREATE CLASS --}}
            <div class="col-md-4 mb-4">
                <div class="p-4 management-card">
                    <div class="card-title-area">
                        <i class="bi bi-building text-primary me-2"></i>
                        <h6>Add Class</h6>
                    </div>
                    <form action="{{route('school.class.create')}}" method="POST">
                        @csrf
                        <input type="hidden" name="session_id" value="{{$current_school_session_id}}">
                        <div class="mb-3">
                            <label class="form-label-custom">Grade / Class Name</label>
                            <input type="text" class="form-control form-control-modern" name="class_name" placeholder="e.g. Grade 10" required>
                        </div>
                        <button class="btn btn-action" type="submit"><i class="bi bi-plus-lg me-2"></i> Register Class</button>
                    </form>
                </div>
            </div>

            {{-- 6. CREATE SECTION --}}
            <div class="col-md-4 mb-4">
                <div class="p-4 management-card">
                    <div class="card-title-area">
                        <i class="bi bi-door-open text-primary me-2"></i>
                        <h6>Define Section</h6>
                    </div>
                    <form action="{{route('school.section.create')}}" method="POST">
                        @csrf
                        <input type="hidden" name="session_id" value="{{$current_school_session_id}}">
                        <div class="mb-2">
                            <input class="form-control form-control-modern" name="section_name" type="text" placeholder="Section Name (A, B, C...)" required>
                        </div>
                        <div class="mb-2">
                            <input class="form-control form-control-modern" name="room_no" type="text" placeholder="Assigned Room No." required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label-custom">Assign to Class</label>
                            <select class="form-select form-select-modern" name="class_id" required>
                                @isset($school_classes)
                                    @foreach ($school_classes as $school_class)
                                    <option value="{{$school_class->id}}">{{$school_class->class_name}}</option>
                                    @endforeach
                                @endisset
                            </select>
                        </div>
                        <button type="submit" class="btn btn-action"><i class="bi bi-check2-all me-2"></i> Create Section</button>
                    </form>
                </div>
            </div>

            {{-- 7. CREATE COURSE --}}
            <div class="col-md-4 mb-4">
                <div class="p-4 management-card">
                    <div class="card-title-area">
                        <i class="bi bi-book text-primary me-2"></i>
                        <h6>Curriculum: Add Course</h6>
                    </div>
                    <form action="{{route('school.course.create')}}" method="POST">
                        @csrf
                        <input type="hidden" name="session_id" value="{{$current_school_session_id}}">
                        <div class="mb-2">
                            <input type="text" class="form-control form-control-modern" name="course_name" placeholder="Course Title" required>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-6">
                                <label class="form-label-custom">Type</label>
                                <select class="form-select form-select-modern" name="course_type" required>
                                    <option value="Core">Core</option>
                                    <option value="General">General</option>
                                    <option value="Elective">Elective</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label-custom">Semester</label>
                                <select class="form-select form-select-modern" name="semester_id" required>
                                    @isset($semesters)
                                        @foreach ($semesters as $semester)
                                        <option value="{{$semester->id}}">{{$semester->semester_name}}</option>
                                        @endforeach
                                    @endisset
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label-custom">Class Assignment</label>
                            <select class="form-select form-select-modern" name="class_id" required>
                                @isset($school_classes)
                                    @foreach ($school_classes as $school_class)
                                    <option value="{{$school_class->id}}">{{$school_class->class_name}}</option>
                                    @endforeach
                                @endisset
                            </select>
                        </div>
                        <button class="btn btn-action" type="submit"><i class="bi bi-journal-plus me-2"></i> Add to Syllabus</button>
                    </form>
                </div>
            </div>

            {{-- 8. ASSIGN TEACHER --}}
            <div class="col-md-4 mb-4">
                <div class="p-4 management-card">
                    <div class="card-title-area">
                        <i class="bi bi-person-check text-primary me-2"></i>
                        <h6>Assign Faculty</h6>
                    </div>
                    <form action="{{route('school.teacher.assign')}}" method="POST">
                        @csrf
                        <input type="hidden" name="session_id" value="{{$current_school_session_id}}">
                        <div class="mb-2">
                            <label class="form-label-custom">Select Faculty Member</label>
                            <select class="form-select form-select-modern" name="teacher_id" required>
                                @isset($teachers)
                                    @foreach ($teachers as $teacher)
                                    <option value="{{$teacher->id}}">{{$teacher->first_name}} {{$teacher->last_name}}</option>
                                    @endforeach
                                @endisset
                            </select>
                        </div>
                        <div class="mb-2">
                            <label class="form-label-custom">Target Semester</label>
                            <select class="form-select form-select-modern" name="semester_id" required>
                                @isset($semesters)
                                    @foreach ($semesters as $semester)
                                    <option value="{{$semester->id}}">{{$semester->semester_name}}</option>
                                    @endforeach
                                @endisset
                            </select>
                        </div>
                        <div class="mb-2">
                            <label class="form-label-custom">Target Class</label>
                            <select onchange="getSectionsAndCourses(this);" class="form-select form-select-modern" name="class_id" required>
                                @isset($school_classes)
                                    <option selected disabled>Choose Class...</option>
                                    @foreach ($school_classes as $school_class)
                                    <option value="{{$school_class->id}}">{{$school_class->class_name}}</option>
                                    @endforeach
                                @endisset
                            </select>
                        </div>
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="form-label-custom">Section</label>
                                <select class="form-select form-select-modern" id="section-select" name="section_id" required></select>
                            </div>
                            <div class="col-6">
                                <label class="form-label-custom">Course</label>
                                <select class="form-select form-select-modern" id="course-select" name="course_id" required></select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-action"><i class="bi bi-person-plus-fill me-2"></i> Confirm Assignment</button>
                    </form>
                </div>
            </div>

            {{-- 9. MARKS SUBMISSION STATUS --}}
            <div class="col-md-4 mb-4">
                <div class="p-4 management-card">
                    <div class="card-title-area">
                        <i class="bi bi-award text-primary me-2"></i>
                        <h6>Grading Policy</h6>
                    </div>
                    <form action="{{route('school.final.marks.submission.status.update')}}" method="POST">
                        @csrf
                        <div class="info-box blue">
                            <small class="text-primary d-block">Enable this only during the final assessment window.</small>
                        </div>
                        <div class="form-check form-switch p-3 border rounded-3 mb-3 bg-white">
                            <input class="form-check-input ms-0 me-3" type="checkbox" name="marks_submission_status" id="marks_submission_status_check" {{($academic_setting->marks_submission_status == 'on')?'checked':''}}>
                            <label class="form-check-label fw-bold" for="marks_submission_status_check">
                                {{($academic_setting->marks_submission_status == 'on')?'Submission Open':'Submission Closed'}}
                            </label>
                        </div>
                        <button type="submit" class="btn btn-action"><i class="bi bi-lock me-2"></i> Save Status</button>
                    </form>
                </div>
            </div>
            @endif
        </div>

        <div class="mt-5">
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
            data.sections.unshift({'id': 0,'section_name': 'Choose Section...'})
            data.sections.forEach(function(section, key) {
                sectionSelect[key] = new Option(section.section_name, section.id);
            });

            var courseSelect = document.getElementById('course-select');
            courseSelect.options.length = 0;
            data.courses.unshift({'id': 0,'course_name': 'Choose Course...'})
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