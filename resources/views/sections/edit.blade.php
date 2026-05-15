@extends('layouts.app')

@section('content')
<style>
    /* High-Level UI for Infrastructure Management */
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
    .management-card {
        background: #ffffff;
        border-radius: 20px;
        border: none;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
        padding: 40px;
    }

    /* Modern Label & Input Styling */
    .form-label-premium {
        font-weight: 700;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #475569;
        margin-bottom: 10px;
        display: block;
    }

    .form-control-premium {
        background-color: #f1f5f9 !important;
        border: 2px solid transparent !important;
        border-radius: 12px !important;
        padding: 12px 18px !important;
        font-size: 1rem !important;
        color: #1e293b !important;
        transition: all 0.3s ease;
    }

    .form-control-premium:focus {
        background-color: #ffffff !important;
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1) !important;
    }

    /* High-Level Primary Button */
    .btn-save-premium {
        background: linear-gradient(135deg, #0f172a 0%, #334155 100%) !important;
        color: white !important;
        border: none !important;
        border-radius: 12px !important;
        padding: 14px 40px !important;
        font-weight: 700 !important;
        font-size: 0.95rem;
        letter-spacing: 0.5px;
        box-shadow: 0 4px 12px rgba(15, 23, 42, 0.2);
        transition: all 0.3s ease;
    }

    .btn-save-premium:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 15px rgba(15, 23, 42, 0.3);
    }

    /* Sidebar Context Panel */
    .context-panel {
        background: #eff6ff;
        border-radius: 20px;
        padding: 30px;
        border-left: 5px solid #3b82f6;
        height: 100%;
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
                            <i class="bi bi-door-open text-primary me-2"></i> Infrastructure Management
                        </h1>
                        <nav aria-label="breadcrumb" class="mt-2">
                            <ol class="breadcrumb breadcrumb-premium mb-0">
                                <li class="breadcrumb-item"><a href="{{route('home')}}" class="text-decoration-none text-muted">Home</a></li>
                                <li class="breadcrumb-item"><a href="{{url()->previous()}}" class="text-decoration-none text-muted">Classes</a></li>
                                <li class="breadcrumb-item active fw-bold text-primary">Edit Section</li>
                            </ol>
                        </nav>
                    </div>

                    @include('session-messages')

                    <div class="row g-4 mt-2">
                        <!-- Primary Form Column -->
                        <div class="col-xl-6 col-lg-8">
                            <div class="management-card border">
                                <div class="mb-4 border-bottom pb-3">
                                    <h5 class="fw-bold text-dark">Modify Section Identity</h5>
                                    <p class="text-muted small mb-0">Update the physical location and naming convention for this academic unit.</p>
                                </div>

                                <form action="{{route('school.section.update')}}" method="POST">
                                    @csrf
                                    {{-- Original Hidden Logic --}}
                                    <input type="hidden" name="session_id" value="{{$current_school_session_id}}">
                                    <input type="hidden" name="section_id" value="{{$section_id}}">

                                    <!-- Section Name Input -->
                                    <div class="mb-4">
                                        <label for="section_name" class="form-label-premium">Section Identifier<span class="required-symbol">*</span></label>
                                        <input class="form-control form-control-premium" 
                                               id="section_name" 
                                               name="section_name" 
                                               type="text" 
                                               value="{{$section->section_name}}" 
                                               placeholder="e.g., Section A or Alpha" 
                                               required>
                                    </div>

                                    <!-- Room Number Input -->
                                    <div class="mb-4">
                                        <label for="room_no" class="form-label-premium">Assigned Room Number<span class="required-symbol">*</span></label>
                                        <input class="form-control form-control-premium" 
                                               id="room_no" 
                                               name="room_no" 
                                               type="text" 
                                               value="{{$section->room_no}}" 
                                               placeholder="e.g., R-204" 
                                               required>
                                    </div>

                                    <div class="d-flex align-items-center justify-content-between mt-5 pt-3">
                                        <a href="{{url()->previous()}}" class="text-muted text-decoration-none small fw-bold">
                                            <i class="bi bi-arrow-left-circle me-1"></i> Discard
                                        </a>
                                        <button type="submit" class="btn btn-save-premium px-5">
                                            <i class="bi bi-shield-check me-2"></i> Commit Changes
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Side Context Panel -->
                        <div class="col-xl-4 col-lg-4 d-none d-xl-block">
                            <div class="context-panel shadow-sm">
                                <h6 class="fw-bold text-primary mb-3">
                                    <i class="bi bi-info-square-fill me-2"></i> Institutional Logic
                                </h6>
                                <p class="small text-dark opacity-75">
                                    Section identifiers and room assignments are used to generate the **Maychew Martyrs Memorial** daily routine and attendance logs.
                                </p>
                                <hr class="my-4 opacity-25">
                                
                                <div class="mb-4">
                                    <span class="d-block small fw-bold text-uppercase opacity-50 mb-2">Technical Reference</span>
                                    <div class="p-3 rounded-3 bg-white border">
                                        <div class="d-flex justify-content-between mb-1">
                                            <span class="small text-muted">Section ID:</span>
                                            <span class="small fw-bold">#{{$section_id}}</span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span class="small text-muted">Session:</span>
                                            <span class="small fw-bold">{{$current_school_session_id}}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="p-3 rounded-3 bg-primary bg-opacity-10 border border-primary border-opacity-10">
                                    <p class="small mb-0 text-primary">
                                        <i class="bi bi-lightbulb-fill me-1"></i> 
                                        <strong>Pro Tip:</strong> Ensure the room number matches the physical capacity registered in the school library system.
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