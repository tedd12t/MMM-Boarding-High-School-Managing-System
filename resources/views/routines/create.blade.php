@extends('layouts.app')

@section('content')
<style>
    /* High-Level UI for Scheduling Operations */
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

    /* Elevated Scheduler Card */
    .scheduler-card {
        background: #ffffff;
        border-radius: 24px;
        border: none;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
        padding: 40px;
    }

    .card-section-title {
        font-weight: 700;
        color: #1e293b;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 1px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
    }

    /* Professional Form Elements */
    .form-label-premium {
        font-weight: 700;
        font-size: 0.8rem;
        color: #475569;
        margin-bottom: 8px;
        display: block;
    }

    .form-control-premium, .form-select-premium {
        background-color: #f1f5f9 !important;
        border: 2px solid transparent !important;
        border-radius: 12px !important;
        padding: 12px 15px !important;
        font-size: 0.95rem !important;
        transition: all 0.3s ease;
    }

    .form-control-premium:focus, .form-select-premium:focus {
        background-color: #ffffff !important;
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1) !important;
    }

    /* Time Range Box */
    .time-slot-box {
        background: #f8fafc;
        border: 2px dashed #e2e8f0;
        border-radius: 16px;
        padding: 20px;
    }

    /* Premium Action Button */
    .btn-publish-routine {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%) !important;
        color: white !important;
        border: none !important;
        border-radius: 12px !important;
        padding: 14px 40px !important;
        font-weight: 700 !important;
        width: 100%;
        box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.3);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .btn-publish-routine:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 20px -5px rgba(59, 130, 246, 0.4);
    }

    /* Sidebar Helper Panel */
    .logic-panel {
        background: #0f172a;
        color: #f1f5f9;
        border-radius: 20px;
        padding: 35px;
        height: 100%;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.2);
    }

    .required-symbol {
        color: #3b82f6;
        margin-left: 3px;
        font-weight: bold;
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
                            <i class="bi bi-calendar4-range text-primary me-2"></i> Academic Routine Studio
                        </h1>
                        <nav aria-label="breadcrumb" class="mt-2">
                            <ol class="breadcrumb breadcrumb-premium mb-0">
                                <li class="breadcrumb-item"><a href="{{route('home')}}" class="text-decoration-none text-muted">Home</a></li>
                                <li class="breadcrumb-item active fw-bold text-primary">Create Routine</li>
                            </ol>
                        </nav>
                    </div>

                    @include('session-messages')

                    <div class="row g-4 mt-2 mb-5">
                        <!-- Primary Scheduler Column -->
                        <div class="col-xl-7 col-lg-8">
                            <div class="scheduler-card border">
                                <form action="{{route('section.routine.store')}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="session_id" value="{{$current_school_session_id}}">

                                    <!-- Section 1: Classification -->
                                    <div class="card-section-title">
                                        <i class="bi bi-info-circle-fill me-2"></i> Class & Section Details
                                    </div>
                                    <div class="row g-3 mb-4">
                                        <div class="col-md-6">
                                            <label class="form-label-premium">Target Class<span class="required-symbol">*</span></label>
                                            <select onchange="getSectionsAndCourses(this);" class="form-select form-select-premium" name="class_id" required>
                                                @isset($classes)
                                                    <option selected disabled>Choose Class...</option>
                                                    @foreach ($classes as $school_class)
                                                    <option value="{{$school_class->id}}">{{$school_class->class_name}}</option>
                                                    @endforeach
                                                @endisset
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label-premium">Assign Section<span class="required-symbol">*</span></label>
                                            <select class="form-select form-select-premium" id="section-select" name="section_id" required>
                                                <option value="">Waiting for class...</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Section 2: Subject & Day -->
                                    <div class="card-section-title">
                                        <i class="bi bi-book-half me-2"></i> Subject & Timeline
                                    </div>
                                    <div class="row g-3 mb-4">
                                        <div class="col-md-7">
                                            <label class="form-label-premium">Course / Subject<span class="required-symbol">*</span></label>
                                            <select class="form-select form-select-premium" id="course-select" name="course_id" required>
                                                <option value="">Select Class First</option>
                                            </select>
                                        </div>
                                        <div class="col-md-5">
                                            <label class="form-label-premium">Day of Week<span class="required-symbol">*</span></label>
                                            <select class="form-select form-select-premium" name="weekday" required>
                                                <option value="1">Monday</option>
                                                <option value="2">Tuesday</option>
                                                <option value="3">Wednesday</option>
                                                <option value="4">Thursday</option>
                                                <option value="5">Friday</option>
                                                <option value="6">Saturday</option>
                                                <option value="7">Sunday</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Section 3: Time Slot -->
                                    <div class="time-slot-box">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label for="inputStarts" class="form-label-premium">Period Starts<span class="required-symbol">*</span></label>
                                                <input type="text" class="form-control form-control-premium" id="inputStarts" name="start" placeholder="e.g. 08:30am" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="inputEnds" class="form-label-premium">Period Ends<span class="required-symbol">*</span></label>
                                                <input type="text" class="form-control form-control-premium" id="inputEnds" name="end" placeholder="e.g. 09:20am" required>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Action Bar -->
                                    <div class="mt-5 d-flex align-items-center justify-content-between">
                                        <a href="{{url()->previous()}}" class="text-muted text-decoration-none small fw-bold">
                                            <i class="bi bi-x-circle me-1"></i> Discard
                                        </a>
                                        <div style="width: 300px;">
                                            <button type="submit" class="btn btn-publish-routine">
                                                <i class="bi bi-cloud-check-fill me-2"></i> Deploy to Timetable
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Side Logic Panel -->
                        <div class="col-xl-4 col-lg-4 d-none d-xl-block">
                            <div class="logic-panel">
                                <h6 class="fw-bold text-primary mb-3">
                                    <i class="bi bi-lightning-charge-fill me-2"></i> Routine Intelligence
                                </h6>
                                <p class="small opacity-75">
                                    The routine defines the heartbeat of <strong>Maychew Martyrs Memorial</strong>. Ensure time slots do not overlap with existing faculty assignments.
                                </p>
                                <hr class="opacity-10 my-4">
                                
                                <div class="mb-4">
                                    <span class="d-block small fw-bold text-uppercase opacity-50 mb-2">Scheduling Format</span>
                                    <div class="p-3 rounded-3 bg-white bg-opacity-5 border border-white border-opacity-10">
                                        <code class="text-info">HH:MMam/pm</code>
                                        <p class="small mb-0 mt-2 opacity-75">Always include am/pm to avoid 24-hour clock confusion in student reports.</p>
                                    </div>
                                </div>

                                <div class="small">
                                    <p class="mb-2 fw-bold text-primary">Institutional Policy:</p>
                                    <ul class="list-unstyled opacity-75">
                                        <li class="mb-2"><i class="bi bi-check2-all me-2 text-success"></i> Standard period: 50 mins</li>
                                        <li class="mb-2"><i class="bi bi-check2-all me-2 text-success"></i> Auto-notifies Teachers</li>
                                        <li><i class="bi bi-check2-all me-2 text-success"></i> Syncs with Attendance</li>
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
            data.courses.unshift({'id': 0,'course_name': 'Choose Subject...'})
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