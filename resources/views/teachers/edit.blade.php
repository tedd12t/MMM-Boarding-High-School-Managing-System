@extends('layouts.app')

@section('content')
<style>
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
    .edit-card {
        background: #ffffff;
        border-radius: 24px;
        border: none;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
        padding: 40px;
        margin-bottom: 40px;
    }

    /* Sectional Labeling */
    .section-label {
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 1.5px;
        color: #3b82f6;
        display: flex;
        align-items: center;
        margin-bottom: 25px;
        border-bottom: 1px solid #f1f5f9;
        padding-bottom: 15px;
    }

    /* Professional Form Elements */
    .form-label-premium {
        font-weight: 700;
        font-size: 0.8rem;
        color: #475569;
        margin-bottom: 8px;
    }

    .form-control-premium, .form-select-premium {
        background-color: #f8fafc !important;
        border: 2px solid transparent !important;
        border-radius: 12px !important;
        padding: 12px 15px !important;
        font-size: 0.95rem !important;
        color: #1e293b !important;
        transition: all 0.3s ease;
    }

    .form-control-premium:focus, .form-select-premium:focus {
        background-color: #ffffff !important;
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1) !important;
    }

    /* Primary Action Button */
    .btn-update-premium {
        background: linear-gradient(135deg, #0f172a 0%, #334155 100%) !important;
        color: white !important;
        border: none !important;
        border-radius: 12px !important;
        padding: 14px 50px !important;
        font-weight: 700 !important;
        font-size: 0.95rem;
        letter-spacing: 0.5px;
        box-shadow: 0 10px 15px -3px rgba(15, 23, 42, 0.2);
        transition: all 0.3s ease;
    }

    .btn-update-premium:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 20px -5px rgba(15, 23, 42, 0.3);
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
                            <i class="bi bi-person-gear text-primary me-2"></i> Teacher Profile Management
                        </h1>
                        <nav aria-label="breadcrumb" class="mt-2">
                            <ol class="breadcrumb breadcrumb-premium mb-0">
                                <li class="breadcrumb-item"><a href="{{route('home')}}" class="text-decoration-none text-muted">Home</a></li>
                                <li class="breadcrumb-item"><a href="{{url()->previous()}}" class="text-decoration-none text-muted">Teacher List</a></li>
                                <li class="breadcrumb-item active fw-bold text-primary">Edit Teacher</li>
                            </ol>
                        </nav>
                    </div>

                    @include('session-messages')

                    <!-- Main Edit Interface -->
                    <div class="edit-card border shadow-sm">
                        <form action="{{route('school.teacher.update')}}" method="POST">
                            <input type="hidden" name="zip" value="0000">
                            @csrf
                            {{-- Keeping original hidden logic --}}
                            <input type="hidden" name="teacher_id" value="{{$teacher->id}}">

                            <!-- SECTION 1: CORE IDENTITY -->
                            <div class="section-label">
                                <i class="bi bi-person-badge-fill me-2"></i> 01. Professional Identity
                            </div>
                            
                            <div class="row g-4 mb-5">
                                <div class="col-md-3">
                                    <label class="form-label-premium">First Name<span class="required-mark">*</span></label>
                                    <input type="text" class="form-control form-control-premium" name="first_name" required value="{{$teacher->first_name}}">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label-premium">Last Name<span class="required-mark">*</span></label>
                                    <input type="text" class="form-control form-control-premium" name="last_name" required value="{{$teacher->last_name}}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label-premium">Official Email<span class="required-mark">*</span></label>
                                    <input type="email" class="form-control form-control-premium" name="email" required value="{{$teacher->email}}">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label-premium">Gender<span class="required-mark">*</span></label>
                                    <select class="form-select form-select-premium" name="gender" required>
                                        <option value="Male" {{($teacher->gender == 'Male')?'selected':null}}>Male</option>
                                        <option value="Female" {{($teacher->gender == 'Female')?'selected':null}}>Female</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label-premium">Phone Number<span class="required-mark">*</span></label>
                                    <input type="text" class="form-control form-control-premium" name="phone" required value="{{$teacher->phone}}">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label-premium">Nationality<span class="required-mark">*</span></label>
                                    <input type="text" class="form-control form-control-premium" name="nationality" required value="{{$teacher->nationality}}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-premium">Change Profile Photo</label>
                                    <input class="form-control form-control-premium" type="file" id="formFile" onchange="previewFile()">
                                    <div id="previewPhoto"></div>
                                    <input type="hidden" id="photoHiddenInput" name="photo" value="">
                                </div>
                            </div>

                            <!-- SECTION 2: RESIDENTIAL DATA -->
                            <div class="section-label">
                                <i class="bi bi-geo-alt-fill me-2"></i> 02. Residential Records
                            </div>

                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="form-label-premium">Primary Address<span class="required-mark">*</span></label>
                                    <input type="text" class="form-control form-control-premium" name="address" required value="{{$teacher->address}}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-premium">Secondary Address (Optional)</label>
                                    <input type="text" class="form-control form-control-premium" name="address2" value="{{$teacher->address2}}">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label-premium">City / Region<span class="required-mark">*</span></label>
                                    <input type="text" class="form-control form-control-premium" name="city" required value="{{$teacher->city}}">
                                </div>
                            </div>

                            <!-- ACTION FOOTER -->
                            <div class="mt-5 pt-4 border-top d-flex align-items-center justify-content-between">
                                <a href="{{url()->previous()}}" class="text-muted text-decoration-none small fw-bold">
                                    <i class="bi bi-arrow-left-circle me-1"></i> Discard Changes
                                </a>
                                <button type="submit" class="btn btn-update-premium shadow-lg">
                                    <i class="bi bi-person-check-fill me-2"></i> Commit Profile Updates
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="mt-2">
                @include('layouts.footer')
            </div>
        </div>
    </div>
</div>

@include('components.photos.photo-input')
@endsection
