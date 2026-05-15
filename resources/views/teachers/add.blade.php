@extends('layouts.app')

@section('content')
<style>
    /* High-Level UI for Faculty Management */
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

    /* Elevated Enrollment Card */
    .enrollment-card {
        background: #ffffff;
        border-radius: 24px;
        border: none;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
        padding: 40px;
    }

    .section-divider {
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 1.5px;
        color: #3b82f6;
        display: flex;
        align-items: center;
        margin: 30px 0 20px;
    }

    .section-divider::after {
        content: "";
        flex: 1;
        height: 1px;
        background: #f1f5f9;
        margin-left: 15px;
    }

    /* Professional Form Elements */
    .form-label-premium {
        font-weight: 700;
        font-size: 0.8rem;
        color: #475569;
        margin-bottom: 8px;
    }

    .form-control-premium, .form-select-premium {
        background-color: #f1f5f9 !important;
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

    /* Photo Upload Interface */
    .upload-surface {
        border: 2px dashed #cbd5e1;
        border-radius: 16px;
        padding: 20px;
        background: #f8fafc;
        text-align: center;
        transition: all 0.2s;
    }

    #previewPhoto img {
        width: 100px;
        height: 100px;
        border-radius: 12px;
        object-fit: cover;
        margin-top: 15px;
        border: 3px solid #ffffff;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    /* Primary Action Button */
    .btn-enroll {
        background: linear-gradient(135deg, #0f172a 0%, #334155 100%) !important;
        color: white !important;
        border: none !important;
        border-radius: 12px !important;
        padding: 14px 45px !important;
        font-weight: 700 !important;
        font-size: 1rem;
        letter-spacing: 0.5px;
        box-shadow: 0 10px 15px -3px rgba(15, 23, 42, 0.2);
        transition: all 0.3s ease;
    }

    .btn-enroll:hover {
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
        <!-- Professional Sidebar -->
        @include('layouts.left-menu')

        <div class="col-lg-10">
            <div class="row pt-4">
                <div class="col-12 ps-lg-5">
                    
                    <!-- Header & Navigation -->
                    <div class="mb-4">
                        <h1 class="page-header mb-1">
                            <i class="bi bi-person-plus-fill text-primary me-2"></i> Faculty Recruitment Portal
                        </h1>
                        <nav aria-label="breadcrumb" class="mt-2">
                            <ol class="breadcrumb breadcrumb-premium mb-0">
                                <li class="breadcrumb-item"><a href="{{route('home')}}" class="text-decoration-none">Home</a></li>
                                <li class="breadcrumb-item active fw-bold text-primary">Add Faculty Member</li>
                            </ol>
                        </nav>
                    </div>

                    @include('session-messages')

                    <!-- Main Enrollment Surface -->
                    <div class="enrollment-card border shadow-sm mb-5">
                        <form action="{{route('school.teacher.create')}}" method="POST">
                            @csrf

                            <!-- SECTION 1: CORE IDENTITY -->
                            <div class="section-divider">
                                <i class="bi bi-person-badge-fill me-2"></i> 01. Personal Identity
                            </div>
                            
                            <div class="row g-4">
                                <div class="col-md-3">
                                    <label class="form-label-premium">Given Name<span class="required-mark">*</span></label>
                                    <input type="text" class="form-control form-control-premium" name="first_name" placeholder="First Name" required value="{{old('first_name')}}">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label-premium">Family Name<span class="required-mark">*</span></label>
                                    <input type="text" class="form-control form-control-premium" name="last_name" placeholder="Last Name" required value="{{old('last_name')}}">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label-premium">Gender<span class="required-mark">*</span></label>
                                    <select class="form-select form-select-premium" name="gender" required>
                                        <option value="Male" {{old('gender') == 'male' ? 'selected' : ''}}>Male</option>
                                        <option value="Female" {{old('gender') == 'female' ? 'selected' : ''}}>Female</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label-premium">Nationality<span class="required-mark">*</span></label>
                                    <input type="text" class="form-control form-control-premium" name="nationality" placeholder="Ethiopian" required value="{{old('nationality')}}">
                                </div>
                            </div>

                            <!-- SECTION 2: DIGITAL CREDENTIALS -->
                            <div class="section-divider">
                                <i class="bi bi-shield-lock-fill me-2"></i> 02. Portal Access & Bio
                            </div>
                            
                            <div class="row g-4 align-items-center">
                                <div class="col-md-4">
                                    <label class="form-label-premium">Institutional Email<span class="required-mark">*</span></label>
                                    <input type="email" class="form-control form-control-premium" name="email" placeholder="faculty@ut.com" required value="{{old('email')}}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label-premium">Initial Password<span class="required-mark">*</span></label>
                                    <input type="password" class="form-control form-control-premium" name="password" required>
                                </div>
                                <div class="col-md-4">
                                    <div class="upload-surface shadow-sm">
                                        <label class="form-label-premium mb-2">Profile Image</label>
                                        <input class="form-control form-control-sm" type="file" id="formFile" onchange="previewFile()">
                                        <div id="previewPhoto"></div>
                                        <input type="hidden" id="photoHiddenInput" name="photo" value="">
                                    </div>
                                </div>
                            </div>

                            <!-- SECTION 3: CONTACT & RESIDENCE -->
                            <div class="section-divider">
                                <i class="bi bi-geo-alt-fill me-2"></i> 03. Contact & Residence
                            </div>
                            
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="form-label-premium">Primary Phone<span class="required-mark">*</span></label>
                                    <input type="text" class="form-control form-control-premium" name="phone" placeholder="+251 ..." required value="{{old('phone')}}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-premium">Permanent Address<span class="required-mark">*</span></label>
                                    <input type="text" class="form-control form-control-premium" name="address" placeholder="Street / Sub-city" required value="{{old('address')}}">
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label-premium">Secondary Address (Optional)</label>
                                    <input type="text" class="form-control form-control-premium" name="address2" placeholder="Building / Apartment" value="{{old('address2')}}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-premium">City / Region<span class="required-mark">*</span></label>
                                    <input type="text" class="form-control form-control-premium" name="city" placeholder="Maychew" required value="{{old('city')}}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-premium">Postal Code / Zip<span class="required-mark">*</span></label>
                                    <input type="text" class="form-control form-control-premium" name="zip" placeholder="1000" required value="{{old('zip')}}">
                                </div>
                            </div>

                            <!-- ACTION FOOTER -->
                            <div class="mt-5 pt-4 border-top text-end">
                                <a href="{{url()->previous()}}" class="btn btn-link text-muted text-decoration-none fw-bold me-4">Discard Changes</a>
                                <button type="submit" class="btn btn-enroll shadow-lg">
                                    <i class="bi bi-person-check-fill me-2"></i> Initialize Faculty Record
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