@extends('layouts.app')

@section('content')
<style>
    /* High-Level UI for Form Pages */
    .page-header {
        margin-bottom: 1.5rem;
    }

    .page-header h1 {
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -1px;
    }

    /* Modern Breadcrumbs */
    .breadcrumb-custom {
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
        transition: color 0.2s;
    }

    .breadcrumb-item a:hover {
        color: #3b82f6;
    }

    /* The Assignment Card */
    .form-card {
        background: #ffffff;
        border-radius: 20px;
        border: none;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
        padding: 2.5rem;
    }

    .form-label-premium {
        font-weight: 700;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #475569;
        margin-bottom: 0.6rem;
        display: block;
    }

    .form-control-premium {
        background-color: #f8fafc !important;
        border: 2px solid #e2e8f0 !important;
        border-radius: 12px !important;
        padding: 0.75rem 1rem !important;
        font-size: 1rem !important;
        transition: all 0.2s;
    }

    .form-control-premium:focus {
        border-color: #3b82f6 !important;
        background-color: #ffffff !important;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1) !important;
    }

    /* File Input Specifics */
    input[type="file"].form-control-premium {
        padding: 0.6rem !important;
    }

    /* Submit Button */
    .btn-create {
        background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%) !important;
        color: white !important;
        border: none !important;
        border-radius: 12px !important;
        padding: 12px 30px !important;
        font-weight: 700 !important;
        width: 100%;
        margin-top: 1rem;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .btn-create:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(37, 99, 235, 0.4);
    }

    .helper-text {
        font-size: 0.75rem;
        color: #94a3b8;
        margin-top: 0.5rem;
    }
</style>

<div class="container-fluid px-4">
    <div class="row">
        @include('layouts.left-menu')
        
        <div class="col-lg-10">
            <div class="row pt-4">
                <div class="col-12 ps-lg-5">
                    
                    <!-- Header & Navigation -->
                    <div class="page-header d-md-flex align-items-center justify-content-between">
                        <div>
                            <h1><i class="bi bi-file-earmark-plus text-primary me-2"></i> Create Assignment</h1>
                            <nav aria-label="breadcrumb" class="mt-2">
                                <ol class="breadcrumb breadcrumb-custom mb-0">
                                    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                                    <li class="breadcrumb-item"><a href="{{url()->previous()}}">Course Dashboard</a></li>
                                    <li class="breadcrumb-item active">New Assignment</li>
                                </ol>
                            </nav>
                        </div>
                    </div>

                    @include('session-messages')

                    <!-- Form Content -->
                    <div class="row mt-4">
                        <div class="col-xl-6 col-lg-8">
                            <div class="form-card">
                                <div class="mb-4 border-bottom pb-3">
                                    <h5 class="fw-bold mb-1">Assignment Details</h5>
                                    <p class="text-muted small">Upload your materials and name your task.</p>
                                </div>

                                <form action="{{route('assignment.store')}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <!-- Original Logic Hidden Inputs -->
                                    <input type="hidden" name="session_id" value="{{$current_school_session_id}}">
                                    <input type="hidden" name="class_id" value="{{request()->query('class_id')}}">
                                    <input type="hidden" name="semester_id" value="{{request()->query('semester_id')}}">
                                    <input type="hidden" name="course_id" value="{{request()->query('course_id')}}">
                                    <input type="hidden" name="section_id" value="{{request()->query('section_id')}}">

                                    <!-- Assignment Name -->
                                    <div class="mb-4">
                                        <label for="assignment-name" class="form-label-premium">Title / Assignment Name</label>
                                        <input type="text" 
                                               class="form-control form-control-premium" 
                                               id="assignment-name" 
                                               name="assignment_name" 
                                               placeholder="e.g. Midterm Physics Project" 
                                               required>
                                    </div>

                                    <!-- File Upload -->
                                    <div class="mb-4">
                                        <label for="assignment-file" class="form-label-premium">Upload Reference File</label>
                                        <input type="file" 
                                               name="file" 
                                               class="form-control form-control-premium" 
                                               id="assignment-file" 
                                               accept=".jpg,.jpeg,.bmp,.png,.gif,.doc,.docx,.csv,.rtf,.xlsx,.xls,.txt,.pdf,.zip" 
                                               required>
                                        <div class="helper-text">
                                            <i class="bi bi-info-circle me-1"></i> Supports PDF, Word, Excel, Images, and ZIP archives.
                                        </div>
                                    </div>

                                    <!-- Submit -->
                                    <div class="mt-5">
                                        <button type="submit" class="btn btn-create">
                                            <i class="bi bi-cloud-arrow-up-fill me-2"></i> Publish Assignment
                                        </button>
                                        <div class="text-center mt-3">
                                            <a href="{{url()->previous()}}" class="text-muted small text-decoration-none">Cancel and Go Back</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        
                        <!-- Right Side Tip Box (High-Level Addition) -->
                        <div class="col-xl-4 col-lg-4 d-none d-xl-block">
                            <div class="p-4 rounded-4 bg-primary text-white shadow-sm" style="background: linear-gradient(135deg, #0f172a 0%, #334155 100%) !important;">
                                <h6 class="fw-bold mb-3"><i class="bi bi-lightbulb me-2 text-warning"></i> Teacher's Tip</h6>
                                <p class="small opacity-75">When naming assignments, include the Topic and the Due Date for better student organization.</p>
                                <hr class="opacity-25">
                                <ul class="list-unstyled small opacity-75">
                                    <li class="mb-2"><i class="bi bi-check2-circle me-2 text-success"></i> File size limit: 5MB</li>
                                    <li><i class="bi bi-check2-circle me-2 text-success"></i> Auto-notifies students</li>
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
@endsection