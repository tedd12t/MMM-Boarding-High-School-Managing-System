@extends('layouts.app')

@section('content')
<style>
    /* High-Level UI for Profile Dossier */
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

    /* Left Profile Sidebar Card */
    .identity-card {
        background: #ffffff;
        border-radius: 24px;
        border: none;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
        text-align: center;
        padding: 30px 20px;
        position: sticky;
        top: 100px;
    }

    .profile-avatar-wrapper {
        width: 130px;
        height: 130px;
        margin: 0 auto 20px;
        padding: 5px;
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        border-radius: 50%;
        box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.3);
    }

    .profile-avatar-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
        border: 4px solid #ffffff;
    }

    .profile-avatar-wrapper i {
        font-size: 4rem;
        color: white;
        line-height: 120px;
    }

    .id-pill {
        background: #f1f5f9;
        color: #475569;
        padding: 6px 15px;
        border-radius: 50px;
        font-family: 'JetBrains Mono', monospace;
        font-weight: 700;
        font-size: 0.85rem;
        display: inline-block;
        margin-top: 10px;
    }

    /* Right Data Cards */
    .dossier-section {
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        margin-bottom: 25px;
        overflow: hidden;
    }

    .dossier-header {
        background: #f8fafc;
        padding: 15px 25px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        font-weight: 700;
        color: #0f172a;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 1px;
    }

    .dossier-header i {
        color: #3b82f6;
        margin-right: 12px;
        font-size: 1.1rem;
    }

    /* Clean Data Grid */
    .info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        padding: 25px;
    }

    .info-item {
        display: flex;
        flex-direction: column;
    }

    .info-label {
        font-size: 0.7rem;
        text-transform: uppercase;
        font-weight: 700;
        color: #94a3b8;
        margin-bottom: 4px;
        letter-spacing: 0.5px;
    }

    .info-value {
        font-size: 0.95rem;
        font-weight: 600;
        color: #1e293b;
    }

    .status-active {
        color: #10b981;
        background: #ecfdf5;
        padding: 2px 8px;
        border-radius: 5px;
        font-size: 0.75rem;
    }
</style>

<div class="container-fluid px-4">
    <div class="row">
        <!-- Professional Sidebar Inclusion -->
        @include('layouts.left-menu')

        <div class="col-lg-10">
            <div class="row pt-4">
                <div class="col-12 ps-lg-5">
                    
                    <!-- Header Section -->
                    <div class="mb-4">
                        <h1 class="page-header mb-1">
                            <i class="bi bi-person-bounding-box text-primary me-2"></i> Student Master Profile
                        </h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-premium mb-0">
                                <li class="breadcrumb-item"><a href="{{route('home')}}" class="text-decoration-none">Home</a></li>
                                <li class="breadcrumb-item"><a href="{{route('student.list.show')}}" class="text-decoration-none">Registry</a></li>
                                <li class="breadcrumb-item active fw-bold text-primary">Student Profile</li>
                            </ol>
                        </nav>
                    </div>

                    <div class="row g-4 mb-5">
                        <!-- Left Panel: Physical Identity -->
                        <div class="col-xl-3 col-md-4">
                            <div class="identity-card border shadow-sm">
                                <div class="profile-avatar-wrapper">
                                    @if (isset($student->photo))
                                        <img src="{{asset('/storage'.$student->photo)}}" alt="Student Photo">
                                    @else
                                        <i class="bi bi-person-fill"></i>
                                    @endif
                                </div>
                                <h4 class="fw-bold text-dark mb-1">{{$student->first_name}} {{$student->last_name}}</h4>
                                <span class="status-active"><i class="bi bi-check-circle-fill me-1"></i>Enrolled</span>
                                <br>
                                <div class="id-pill">
                                    <i class="bi bi-hash"></i>{{$promotion_info->id_card_number}}
                                </div>
                                
                                <hr class="my-4 opacity-10">
                                
                                <div class="text-start px-3">
                                    <div class="mb-3">
                                        <label class="info-label">Contact</label>
                                        <div class="info-value small"><i class="bi bi-telephone text-primary me-2"></i>{{$student->phone}}</div>
                                    </div>
                                    <div>
                                        <label class="info-label">Email</label>
                                        <div class="info-value small text-truncate"><i class="bi bi-envelope text-primary me-2"></i>{{$student->email}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Panel: Data Canvas -->
                        <div class="col-xl-9 col-md-8">
                            
                            <!-- 1. Bio & Residence -->
                            <div class="dossier-section border shadow-sm">
                                <div class="dossier-header">
                                    <i class="bi bi-person-vcard-fill"></i> Personal Biography & Residence
                                </div>
                                <div class="info-grid">
                                    <div class="info-item">
                                        <span class="info-label">Full Name</span>
                                        <span class="info-value">{{$student->first_name}} {{$student->last_name}}</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Date of Birth</span>
                                        <span class="info-value"><i class="bi bi-calendar-event me-2 opacity-50"></i>{{$student->birthday}}</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Nationality</span>
                                        <span class="info-value">{{$student->nationality}}</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Religion</span>
                                        <span class="info-value">{{$student->religion}}</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Blood Type</span>
                                        <span class="info-value text-danger"><i class="bi bi-droplet-fill me-1"></i>{{$student->blood_type}}</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Gender</span>
                                        <span class="info-value">{{$student->gender}}</span>
                                    </div>
                                    <div class="info-item" style="grid-column: span 2;">
                                        <span class="info-label">Primary Address</span>
                                        <span class="info-value"><i class="bi bi-geo-alt-fill text-danger me-2"></i>{{$student->address}}, {{$student->address2}}, {{$student->city}}, {{$student->zip}}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- 2. Parents' Information -->
                            <div class="dossier-section border shadow-sm">
                                <div class="dossier-header">
                                    <i class="bi bi-people-fill"></i> Guardian & Parent Records
                                </div>
                                <div class="info-grid">
                                    <div class="info-item">
                                        <span class="info-label">Father's Name</span>
                                        <span class="info-value">{{$student->parent_info->father_name}}</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Mother's Name</span>
                                        <span class="info-value">{{$student->parent_info->mother_name}}</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Father's Contact</span>
                                        <span class="info-value"><i class="bi bi-phone me-1 opacity-50"></i>{{$student->parent_info->father_phone}}</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Mother's Contact</span>
                                        <span class="info-value"><i class="bi bi-phone me-1 opacity-50"></i>{{$student->parent_info->mother_phone}}</span>
                                    </div>
                                    <div class="info-item" style="grid-column: span 2;">
                                        <span class="info-label">Guardian Permanent Residence</span>
                                        <span class="info-value">{{$student->parent_info->parent_address}}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- 3. Academic Information -->
                            <div class="dossier-section border shadow-sm">
                                <div class="dossier-header">
                                    <i class="bi bi-mortarboard-fill"></i> Institutional Placement
                                </div>
                                <div class="info-grid">
                                    <div class="info-item">
                                        <span class="info-label">Current Grade / Class</span>
                                        <span class="info-value text-primary fw-bold">{{$promotion_info->section->schoolClass->class_name}}</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Section Assignment</span>
                                        <span class="info-value">{{$promotion_info->section->section_name}}</span>
                                    </div>
                                    <div class="info-item" style="grid-column: span 2;">
                                        <span class="info-label">Board Registration Number</span>
                                        <span class="info-value fw-bold" style="letter-spacing: 1px;">{{$student->academic_info->board_reg_no}}</span>
                                    </div>
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
@endsection