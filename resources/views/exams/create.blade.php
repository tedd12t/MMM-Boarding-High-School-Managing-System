@extends('layouts.app')

@section('content')
<style>
    /* High-Level UI for Academic Operations */
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
    .exam-card {
        background: #ffffff;
        border-radius: 20px;
        border: none;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
        padding: 40px;
    }

    .exam-card-header {
        border-bottom: 1px solid #f1f5f9;
        margin-bottom: 25px;
        padding-bottom: 15px;
    }

    /* Professional Form Elements */
    .form-label-premium {
        font-weight: 700;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #475569;
        margin-bottom: 10px;
        display: block;
    }

    .form-control-premium, .form-select-premium {
        background-color: #f1f5f9 !important;
        border: 2px solid transparent !important;
        border-radius: 12px !important;
        padding: 12px 18px !important;
        font-size: 1rem !important;
        color: #1e293b !important;
        transition: all 0.3s ease;
    }

    .form-control-premium:focus, .form-select-premium:focus {
        background-color: #ffffff !important;
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1) !important;
    }

    /* Scheduling Section Styling */
    .schedule-box {
        background: #f8fafc;
        border-radius: 16px;
        padding: 20px;
        border: 1px dashed #cbd5e1;
    }

    /* Premium Action Button */
    .btn-create-exam {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%) !important;
        color: white !important;
        border: none !important;
        border-radius: 12px !important;
        padding: 14px 40px !important;
        font-weight: 700 !important;
        box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.3);
        transition: transform 0.2s;
        width: 100%;
    }

    .btn-create-exam:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 20px -5px rgba(59, 130, 246, 0.4);
    }

    .required-mark {
        color: #3b82f6;
        margin-left: 3px;
        font-weight: bold;
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
                            <i class="bi bi-file-earmark-plus text-primary me-2"></i> Schedule New Examination
                        </h1>
                        <nav aria-label="breadcrumb" class="mt-2">
                            <ol class="breadcrumb breadcrumb-premium mb-0">
                                <li class="breadcrumb-item"><a href="{{route('home')}}" class="text-decoration-none text-muted">Home</a></li>
                                <li class="breadcrumb-item active fw-bold text-primary">Create Exam</li>
                            </ol>
                        </nav>
                    </div>

                    @include('session-messages')

                    <div class="row g-4 mt-2">
                        <!-- Main Form Column -->
                        <div class="col-xl-7 col-lg-8">
                            <div class="exam-card border">
                                <div class="exam-card-header">
                                    <h5 class="fw-bold text-dark mb-1">Examination Details</h5>
                                    <p class="text-muted small mb-0">Enter the subject and scheduling information for the assessment.</p>
                                </div>

                                <form action="{{route('exam.create')}}" method="POST">
                                    @csrf
                                    {{-- Keeping original hidden session logic --}}
                                    <input type="hidden" name="session_id" value="{{$current_school_session_id}}">

                                    <div class="row g-3 mb-4">
                                        <div class="col-md-6">
                                            <label class="form-label-premium">Academic Semester<span class="required-mark">*</span></label>
                                            <select class="form-select form-select-premium" name="semester_id" required>
                                                @isset($semesters)
                                                    @foreach ($semesters as $semester)
                                                    <option value="{{$semester->id}}">{{$semester->semester_name}}</option>
                                                    @endforeach
                                                @endisset
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label-premium">Target Class<span class="required-mark">*</span></label>
                                            <select onchange="getCourses(this);" class="form-select form-select-premium" name="class_id" required>
                                                @isset($classes)
                                                    <option selected disabled>Choose Class...</option>
                                                    @foreach ($classes as $school_class)
                                                    <option value="{{$school_class->id}}">{{$school_class->class_name}}</option>
                                                    @endforeach
                                                @endisset
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label-premium">Target Course / Subject<span class="required-mark">*</span></label>
                                        <select class="form-select form-select-premium" id="course-select" name="course_id" required>
                                            <option value="">Select a class first...</option>
                                        </select>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label-premium">Examination Title<span class="required-mark">*</span></label>
                                        <input type="text" class="form-control form-control-premium" name="exam_name" placeholder="e.g. Mid-Term Physics, Final Calculus" required>
                                    </div>

                                    <div class="schedule-box">
                                        <h6 class="fw-bold text-dark mb-3 small text-uppercase opacity-75">Date & Time Management</h6>
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label for="inputStarts" class="form-label-premium">Start Window</label>
                                                <input type="datetime-local" class="form-control form-control-premium" id="inputStarts" name="start_date" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="inputEnds" class="form-label-premium">End Window</label>
                                                <input type="datetime-local" class="form-control form-control-premium" id="inputEnds" name="end_date" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-5">
                                        <button type="submit" class="btn btn-create-exam">
                                            <i class="bi bi-calendar2-plus me-2"></i> Deploy Examination
                                        </button>
                                        <div class="text-center mt-3">
                                            <a href="{{url()->previous()}}" class="text-muted small text-decoration-none fw-bold">Cancel and Go Back</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Side Operational Tips -->
                        <div class="col-xl-4 col-lg-4 d-none d-xl-block">
                            <div class="p-4 rounded-4 bg-primary text-white shadow-lg" style="background: linear-gradient(135deg, #0f172a 0%, #334155 100%) !important;">
                                <h6 class="fw-bold mb-3"><i class="bi bi-info-circle-fill me-2 text-info"></i> Scheduler Tip</h6>
                                <p class="small opacity-75">Exam titles should be descriptive (e.g., "Assignment 1" or "Second Term Final") as they will appear directly on student report cards.</p>
                                <hr class="opacity-25 my-4">
                                <ul class="list-unstyled small mb-0">
                                    <li class="mb-3 d-flex align-items-center"><i class="bi bi-check-circle me-2 text-success"></i> Auto-validates conflicts</li>
                                    <li class="mb-3 d-flex align-items-center"><i class="bi bi-check-circle me-2 text-success"></i> Alerts assigned teacher</li>
                                    <li class="d-flex align-items-center"><i class="bi bi-check-circle me-2 text-success"></i> Supports partial marking</li>
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

<script>
    function getCourses(obj) {
        var class_id = obj.options[obj.selectedIndex].value;
        var url = "{{route('get.sections.courses.by.classId')}}?class_id=" + class_id 

        fetch(url)
        .then((resp) => resp.json())
        .then(function(data) {
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