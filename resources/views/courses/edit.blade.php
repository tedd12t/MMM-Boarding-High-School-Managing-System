@extends('layouts.app')

@section('content')
<style>
    /* High-Level UI for Curriculum Management */
    .page-header h1 {
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -1px;
    }

    /* Modern Breadcrumb Styling */
    .breadcrumb-premium {
        background: #ffffff;
        padding: 10px 20px;
        border-radius: 12px;
        display: inline-flex;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
        border: 1px solid #e2e8f0;
    }

    .breadcrumb-item a {
        color: #64748b;
        text-decoration: none;
        font-weight: 500;
    }

    /* Elevated Form Card */
    .management-card {
        background: #ffffff;
        border-radius: 20px;
        border: none;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
        padding: 40px;
    }

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

    /* Action Buttons */
    .btn-save-premium {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%) !important;
        color: white !important;
        border: none !important;
        border-radius: 12px !important;
        padding: 14px 40px !important;
        font-weight: 700 !important;
        box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.3);
        transition: transform 0.2s;
    }

    .btn-save-premium:hover {
        transform: translateY(-2px);
    }

    /* Context Panel */
    .context-panel {
        background: #0f172a;
        color: #f1f5f9;
        border-radius: 20px;
        padding: 30px;
        height: 100%;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.2);
    }
</style>

<div class="container-fluid px-4">
    <div class="row g-0">
        <!-- Professional Sidebar -->
        @include('layouts.left-menu')

        <div class="col-lg-10">
            <div class="row pt-4">
                <div class="col-12 ps-lg-5">
                    
                    <!-- Header & Navigation -->
                    <div class="mb-4">
                        <h1 class="page-header mb-1">
                            <i class="bi bi-journal-medical text-primary me-2"></i> Curriculum Management
                        </h1>
                        <nav aria-label="breadcrumb" class="mt-2">
                            <ol class="breadcrumb breadcrumb-premium mb-0">
                                <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                                <li class="breadcrumb-item"><a href="{{url()->previous()}}">Courses</a></li>
                                <li class="breadcrumb-item active fw-bold text-primary">Edit Course</li>
                            </ol>
                        </nav>
                    </div>

                    @include('session-messages')

                    <!-- Content Layout -->
                    <div class="row mt-4 g-4">
                        <!-- Primary Form Column -->
                        <div class="col-xl-7 col-lg-8">
                            <div class="management-card">
                                <div class="mb-4 border-bottom pb-3">
                                    <h5 class="fw-bold text-dark">Course Definition</h5>
                                    <p class="text-muted small">Update the academic details and classification of this course.</p>
                                </div>

                                <form action="{{route('school.course.update')}}" method="POST">
                                    @csrf
                                    <!-- Original Hidden Logic -->
                                    <input type="hidden" name="session_id" value="{{$current_school_session_id}}">
                                    <input type="hidden" name="course_id" value="{{$course_id}}">

                                    <div class="mb-4">
                                        <label for="course_name" class="form-label-premium">Course / Subject Title</label>
                                        <input class="form-control form-control-premium" 
                                               id="course_name" 
                                               name="course_name" 
                                               type="text" 
                                               value="{{$course->course_name}}" 
                                               required>
                                    </div>

                                    <div class="mb-4">
                                        <label for="course_type" class="form-label-premium">Academic Category</label>
                                        <select class="form-select form-select-premium" id="course_type" name="course_type">
                                            <option value="Core" {{($course->course_type == 'Core')? 'selected' : ''}}>Core Requirement</option>
                                            <option value="General" {{($course->course_type == 'General')? 'selected' : ''}}>General Education</option>
                                            <option value="Elective" {{($course->course_type == 'Elective')? 'selected' : ''}}>Elective Subject</option>
                                            <option value="Optional" {{($course->course_type == 'Optional')? 'selected' : ''}}>Optional Credit</option>
                                        </select>
                                    </div>

                                    <div class="mt-5 d-flex align-items-center justify-content-between">
                                        <a href="{{url()->previous()}}" class="text-muted text-decoration-none small fw-bold">
                                            <i class="bi bi-x-circle me-1"></i> Cancel Changes
                                        </a>
                                        <button type="submit" class="btn btn-save-premium">
                                            <i class="bi bi-cloud-check-fill me-2"></i> Commit Updates
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Side Context Panel (The "High-Level" Touch) -->
                        <div class="col-xl-4 col-lg-4 d-none d-xl-block">
                            <div class="context-panel">
                                <h6 class="fw-bold text-primary mb-3">
                                    <i class="bi bi-info-square-fill me-2"></i> System Intelligence
                                </h6>
                                <p class="small opacity-75">
                                    You are currently modifying a course within the <strong>{{ $current_school_session_id }}</strong> session. 
                                </p>
                                <hr class="opacity-25">
                                <div class="mb-3">
                                    <span class="d-block small fw-bold text-uppercase opacity-50 mb-1">Current Session</span>
                                    <span class="badge bg-soft-primary p-2 w-100 border text-start">
                                        <i class="bi bi-calendar-check me-2"></i> {{ $current_school_session_id }}
                                    </span>
                                </div>
                                <div class="p-3 rounded-3 bg-white bg-opacity-10 border border-white border-opacity-10">
                                    <p class="small mb-0 opacity-75">
                                        <i class="bi bi-lightbulb-fill text-warning me-1"></i> 
                                        <strong>Note:</strong> Course type affects how GPA is calculated and appears on official transcripts for Maychew Martyrs Memorial students.
                                    </p>
                                </div>
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
@endsection