@extends('layouts.app')

@section('content')
<style>
    /* High-Level UI for Profile Management */
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

    /* Sectional Cards */
    .profile-card {
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        padding: 35px;
        margin-bottom: 30px;
    }

    .card-indicator {
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
        padding: 10px 15px !important;
        font-size: 0.95rem !important;
        color: #1e293b !important;
        transition: all 0.3s ease;
    }

    .form-control-premium:focus, .form-select-premium:focus {
        background-color: #ffffff !important;
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1) !important;
    }

    /* High-Level Primary Button */
    .btn-update-premium {
        background: linear-gradient(135deg, #0f172a 0%, #334155 100%) !important;
        color: white !important;
        border: none !important;
        border-radius: 12px !important;
        padding: 14px 50px !important;
        font-weight: 700 !important;
        box-shadow: 0 10px 15px -3px rgba(15, 23, 42, 0.2);
        transition: transform 0.2s ease;
    }

    .btn-update-premium:hover {
        transform: translateY(-2px);
    }

    .required-mark {
        color: #3b82f6;
        margin-left: 3px;
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
                            <i class="bi bi-person-gear text-primary me-2"></i> Edit Student Profile
                        </h1>
                        <nav aria-label="breadcrumb" class="mt-2">
                            <ol class="breadcrumb breadcrumb-premium mb-0">
                                <li class="breadcrumb-item"><a href="{{route('home')}}" class="text-decoration-none">Home</a></li>
                                <li class="breadcrumb-item"><a href="{{url()->previous()}}" class="text-decoration-none">Student Registry</a></li>
                                <li class="breadcrumb-item active fw-bold text-primary">Modify Record</li>
                            </ol>
                        </nav>
                    </div>

                    @include('session-messages')

                    <form action="{{route('school.student.update')}}" method="POST">
                        @csrf
                        <input type="hidden" name="student_id" value="{{$student->id}}">

                        <!-- CARD 1: CORE IDENTITY & BIO -->
                        <div class="profile-card border shadow-sm">
                            <div class="card-indicator">
                                <i class="bi bi-fingerprint me-2"></i> 01. Academic Identity & Bio
                            </div>
                            
                            <div class="row g-4">
                                <div class="col-md-3">
                                    <label class="form-label-premium">First Name<span class="required-mark">*</span></label>
                                    <input type="text" class="form-control form-control-premium" name="first_name" value="{{$student->first_name}}" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label-premium">Last Name<span class="required-mark">*</span></label>
                                    <input type="text" class="form-control form-control-premium" name="last_name" value="{{$student->last_name}}" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label-premium">Institutional Email<span class="required-mark">*</span></label>
                                    <input type="email" class="form-control form-control-premium" name="email" value="{{$student->email}}" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label-premium">Date of Birth<span class="required-mark">*</span></label>
                                    <input type="date" class="form-control form-control-premium" name="birthday" value="{{$student->birthday}}" required>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label-premium">Gender</label>
                                    <select class="form-select form-select-premium" name="gender" required>
                                        <option value="Male" {{($student->gender == 'Male')?'selected':null}}>Male</option>
                                        <option value="Female" {{($student->gender == 'Female')?'selected':null}}>Female</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label-premium">Nationality</label>
                                    <input type="text" class="form-control form-control-premium" name="nationality" value="{{$student->nationality}}" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label-premium">Blood Group</label>
                                    <select class="form-select form-select-premium" name="blood_type" required>
                                        @foreach(['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-', 'Other'] as $bt)
                                            <option value="{{$bt}}" {{($student->blood_type == $bt)?'selected':null}}>{{$bt}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label-premium">Religion</label>
                                    <select class="form-select form-select-premium" name="religion" required>
                                        @foreach(['Islam', 'Hinduism', 'Christianity', 'Buddhism', 'Judaism', 'Other'] as $rel)
                                            <option value="{{$rel}}" {{($student->religion == $rel)?'selected':null}}>{{$rel}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label-premium">Primary Phone Number</label>
                                    <input type="text" class="form-control form-control-premium" name="phone" value="{{$student->phone}}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-premium">Assigned ID Card Number<span class="required-mark">*</span></label>
                                    <input type="text" class="form-control form-control-premium fw-bold text-primary" name="id_card_number" value="{{$promotion_info->id_card_number}}" required>
                                </div>
                            </div>
                        </div>

                        <!-- CARD 2: GUARDIAN & RESIDENCE -->
                        <div class="profile-card border shadow-sm">
                            <div class="card-indicator">
                                <i class="bi bi-house-door-fill me-2"></i> 02. Residence & Guardian Records
                            </div>
                            
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="form-label-premium">Physical Address Line 1</label>
                                    <input type="text" class="form-control form-control-premium" name="address" value="{{$student->address}}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-premium">Physical Address Line 2</label>
                                    <input type="text" class="form-control form-control-premium" name="address2" value="{{$student->address2}}">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label-premium">City</label>
                                    <input type="text" class="form-control form-control-premium" name="city" value="{{$student->city}}" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label-premium">Postal / Zip Code</label>
                                    <input type="text" class="form-control form-control-premium" name="zip" value="{{$student->zip}}" required>
                                </div>

                                <div class="col-12 mt-4">
                                    <h6 class="fw-bold text-dark small text-uppercase">Emergency Contact Details</h6>
                                    <hr class="opacity-10">
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label-premium">Father's Full Name</label>
                                    <input type="text" class="form-control form-control-premium" name="father_name" value="{{$parent_info->father_name}}" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label-premium">Father's Contact</label>
                                    <input type="text" class="form-control form-control-premium" name="father_phone" value="{{$parent_info->father_phone}}" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label-premium">Mother's Full Name</label>
                                    <input type="text" class="form-control form-control-premium" name="mother_name" value="{{$parent_info->mother_name}}" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label-premium">Mother's Contact</label>
                                    <input type="text" class="form-control form-control-premium" name="mother_phone" value="{{$parent_info->mother_phone}}" required>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label-premium">Guardian Permanent Residence</label>
                                    <input type="text" class="form-control form-control-premium" name="parent_address" value="{{$parent_info->parent_address}}" required>
                                </div>
                            </div>
                        </div>

                        <!-- Action Footer -->
                        <div class="text-end mb-5">
                            <a href="{{url()->previous()}}" class="btn btn-link text-muted text-decoration-none fw-bold me-4">Discard Changes</a>
                            <button type="submit" class="btn btn-update-premium">
                                <i class="bi bi-cloud-check-fill me-2"></i> Commit Profile Updates
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @include('layouts.footer')
        </div>
    </div>
</div>

@include('components.photos.photo-input')
@endsection