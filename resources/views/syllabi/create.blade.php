@extends('layouts.app')

@section('content')
<style>
    /* High-Level UI for Document Management */
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

    /* Elevated Console Card */
    .console-card {
        background: #ffffff;
        border-radius: 24px;
        border: none;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
        padding: 40px;
    }

    .console-card-header {
        border-bottom: 1px solid #f1f5f9;
        margin-bottom: 30px;
        padding-bottom: 20px;
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
        font-size: 0.95rem !important;
        color: #1e293b !important;
        transition: all 0.3s ease;
    }

    .form-control-premium:focus, .form-select-premium:focus {
        background-color: #ffffff !important;
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1) !important;
    }

    /* File Upload Zone Decoration */
    .upload-zone {
        background: #f8fafc;
        border: 2px dashed #cbd5e1;
        border-radius: 16px;
        padding: 30px;
        text-align: center;
        transition: all 0.3s ease;
    }

    .upload-zone:hover {
        border-color: #3b82f6;
        background: #eff6ff;
    }

    /* High-Level Primary Button */
    .btn-publish-premium {
        background: linear-gradient(135deg, #0f172a 0%, #334155 100%) !important;
        color: white !important;
        border: none !important;
        border-radius: 12px !important;
        padding: 14px 40px !important;
        font-weight: 700 !important;
        font-size: 1rem;
        letter-spacing: 0.5px;
        box-shadow: 0 10px 15px -3px rgba(15, 23, 42, 0.2);
        transition: all 0.3s ease;
        width: 100%;
    }

    .btn-publish-premium:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 20px -5px rgba(15, 23, 42, 0.3);
    }

    /* Right Side Context Panel */
    .guideline-panel {
        background: #0f172a;
        color: #f1f5f9;
        border-radius: 20px;
        padding: 35px;
        height: 100%;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.2);
    }

    .required-mark {
        color: #3b82f6;
        margin-left: 3px;
        font-weight: bold;
    }
</style>

<div class="container-fluid px-4">
    <div class="row g-0">
        <!-- Professional Sidebar -->
        @include('layouts.left-menu')

        <div class="col-lg-10">
            <div class="row pt-4">
                <div class="col-12 ps-lg-5">
                    
                    <!-- Header Section -->
                    <div class="mb-4">
                        <h1 class="page-header mb-1">
                            <i class="bi bi-journal-richtext text-primary me-2"></i> Curriculum Document Studio
                        </h1>
                        <nav aria-label="breadcrumb" class="mt-2">
                            <ol class="breadcrumb breadcrumb-premium mb-0">
                                <li class="breadcrumb-item"><a href="{{route('home')}}" class="text-decoration-none text-muted">Home</a></li>
                                <li class="breadcrumb-item active fw-bold text-primary">Upload Syllabus</li>
                            </ol>
                        </nav>
                    </div>

                    @include('session-messages')

                    <div class="row g-4 mt-2 mb-5">
                        <!-- Primary Form Column -->
                        <div class="col-xl-7 col-lg-8">
                            <div class="console-card border">
                                <div class="console-card-header">
                                    <h5 class="fw-bold text-dark mb-1">Upload Console</h5>
                                    <p class="text-muted small mb-0">Select academic targets and upload the official syllabus documentation.</p>
                                </div>

                                <form action="{{route('syllabus.store')}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    {{-- Keeping original hidden session logic --}}
                                    <input type="hidden" name="session_id" value="{{$current_school_session_id}}">

                                    <div class="row g-3 mb-4">
                                        <div class="col-md-6">
                                            <label class="form-label-premium">Institutional Grade / Class<span class="required-mark">*</span></label>
                                            <select onchange="getCourses(this);" class="form-select form-select-premium" name="class_id" required>
                                                @isset($school_classes)
                                                    <option selected disabled>Choose Class...</option>
                                                    @foreach ($school_classes as $school_class)
                                                    <option value="{{$school_class->id}}">{{$school_class->class_name}}</option>
                                                    @endforeach
                                                @endisset
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label-premium">Target Course / Subject<span class="required-mark">*</span></label>
                                            <select class="form-select form-select-premium" id="course-select" name="course_id" required>
                                                <option value="">Waiting for class...</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label for="syllabus-name" class="form-label-premium">Document Nomenclature<span class="required-mark">*</span></label>
                                        <input type="text" class="form-control form-control-premium" id="syllabus-name" name="syllabus_name" placeholder="e.g. Grade 10 Physics - First Semester" required>
                                    </div>

                                    <div class="upload-zone mb-4">
                                        <label for="syllabus-file" class="form-label-premium"><i class="bi bi-cloud-arrow-up fs-3 d-block mb-2 text-primary"></i>Attach Digital File</label>
                                        <input type="file" name="file" class="form-control form-control-premium" id="syllabus-file" 
                                               accept=".pdf,.doc,.docx,.xlsx,.xls,.zip" required>
                                        <div class="mt-2 text-muted small">
                                            <i class="bi bi-info-circle me-1"></i> Supports PDF, Office Docs, and Archives. Max 10MB.
                                        </div>
                                    </div>

                                    <div class="mt-5 d-flex align-items-center justify-content-between">
                                        <a href="{{url()->previous()}}" class="text-muted text-decoration-none small fw-bold">
                                            <i class="bi bi-arrow-left-circle me-1"></i> Discard
                                        </a>
                                        <div style="width: 280px;">
                                            <button type="submit" class="btn btn-publish-premium">
                                                <i class="bi bi-check2-all me-2"></i> Commit to Repository
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Side Guideline Panel -->
                        <div class="col-xl-4 col-lg-4 d-none d-xl-block">
                            <div class="guideline-panel">
                                <h6 class="fw-bold text-primary mb-3">
                                    <i class="bi bi-shield-lock-fill me-2"></i> Repository Guidelines
                                </h6>
                                <p class="small opacity-75">
                                    Syllabus documents stored in the <strong>Maychew Martyrs Memorial</strong> repository are accessible to all enrolled students and assigned faculty.
                                </p>
                                <hr class="opacity-10 my-4">
                                
                                <div class="mb-4">
                                    <span class="d-block small fw-bold text-uppercase opacity-50 mb-2">Naming Convention</span>
                                    <div class="p-3 rounded-3 bg-white bg-opacity-5 border border-white border-opacity-10">
                                        <p class="small mb-0">Use <strong>"Year_Subject_Grade"</strong> format for optimal search results in the library module.</p>
                                    </div>
                                </div>

                                <div class="small">
                                    <p class="mb-2 fw-bold text-primary">Institutional Policy:</p>
                                    <ul class="list-unstyled opacity-75">
                                        <li class="mb-2"><i class="bi bi-check2-circle me-2 text-success"></i> Verify file virus-free</li>
                                        <li class="mb-2"><i class="bi bi-check2-circle me-2 text-success"></i> Clear course mapping</li>
                                        <li><i class="bi bi-check2-circle me-2 text-success"></i> PDF format preferred</li>
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
    function getCourses(obj) {
        var class_id = obj.options[obj.selectedIndex].value;
        var url = "{{route('get.sections.courses.by.classId')}}?class_id=" + class_id 

        fetch(url)
        .then((resp) => resp.json())
        .then(function(data) {
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