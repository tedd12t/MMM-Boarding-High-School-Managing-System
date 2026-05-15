@extends('layouts.app')

@section('content')
<style>
    /* High-Level UI for Faculty Dossier */
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

    /* Left Faculty Sidebar Card */
    .faculty-identity-card {
        background: #ffffff;
        border-radius: 24px;
        border: none;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
        text-align: center;
        padding: 30px 20px;
        position: sticky;
        top: 100px;
    }

    .faculty-avatar-wrapper {
        width: 140px;
        height: 140px;
        margin: 0 auto 20px;
        padding: 5px;
        background: linear-gradient(135deg, #0f172a 0%, #334155 100%);
        border-radius: 20px; /* Modern squircle look */
        box-shadow: 0 10px 15px -3px rgba(15, 23, 42, 0.3);
    }

    .faculty-avatar-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 15px;
        border: 4px solid #ffffff;
    }

    .faculty-avatar-wrapper i {
        font-size: 4.5rem;
        color: white;
        line-height: 130px;
    }

    .faculty-status-badge {
        background: #ecfdf5;
        color: #059669;
        padding: 5px 12px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        border: 1px solid #10b981;
    }

    /* Right Data Cards */
    .dossier-card {
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

    /* Clean Info Grid */
    .info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 24px;
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
        font-size: 1rem;
        font-weight: 600;
        color: #1e293b;
    }

    .info-value i {
        color: #3b82f6;
        margin-right: 8px;
        opacity: 0.7;
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
                            <i class="bi bi-person-workspace text-primary me-2"></i> Faculty Master Profile
                        </h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-premium mb-0">
                                <li class="breadcrumb-item"><a href="{{route('home')}}" class="text-decoration-none">Home</a></li>
                                <li class="breadcrumb-item"><a href="{{route('teacher.list.show')}}" class="text-decoration-none">Faculty Registry</a></li>
                                <li class="breadcrumb-item active fw-bold text-primary">Profile</li>
                            </ol>
                        </nav>
                    </div>

                    <div class="row g-4 mb-5">
                        <!-- Left Panel: Professional Identity -->
                        <div class="col-xl-3 col-md-4">
                            <div class="faculty-identity-card border shadow-sm">
                                <div class="faculty-avatar-wrapper">
                                    @if (isset($teacher->photo))
                                        <img src="{{asset('/storage'.$teacher->photo)}}" alt="Teacher Photo">
                                    @else
                                        <i class="bi bi-person-fill"></i>
                                    @endif
                                </div>
                                <h4 class="fw-bold text-dark mb-2">{{$teacher->first_name}} {{$teacher->last_name}}</h4>
                                <span class="faculty-status-badge"><i class="bi bi-shield-check me-1"></i>Active Faculty</span>
                                
                                <hr class="my-4 opacity-10">
                                
                                <div class="text-start px-2">
                                    <div class="mb-3">
                                        <label class="info-label">Official Email</label>
                                        <div class="info-value small text-truncate"><i class="bi bi-envelope-at text-primary"></i>{{$teacher->email}}</div>
                                    </div>
                                    <div class="mb-0">
                                        <label class="info-label">Phone</label>
                                        <div class="info-value small"><i class="bi bi-telephone-fill text-primary"></i>{{$teacher->phone}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Panel: Data Canvas -->
                        <div class="col-xl-9 col-md-8">
                            
                            <!-- 1. General Professional Information -->
                            <div class="dossier-card border shadow-sm">
                                <div class="dossier-header">
                                    <i class="bi bi-person-vcard-fill"></i> General Professional Information
                                </div>
                                <div class="info-grid">
                                    <div class="info-item">
                                        <span class="info-label">Full Legal Name</span>
                                        <span class="info-value">{{$teacher->first_name}} {{$teacher->last_name}}</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Nationality</span>
                                        <span class="info-value"><i class="bi bi-globe-americas"></i>{{$teacher->nationality}}</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Gender Identification</span>
                                        <span class="info-value">{{$teacher->gender}}</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Account Verification</span>
                                        <span class="info-value text-success"><i class="bi bi-patch-check-fill"></i>System Verified</span>
                                    </div>
                                </div>
                            </div>

                            <!-- 2. Residential & Contact Records -->
                            <div class="dossier-card border shadow-sm">
                                <div class="dossier-header">
                                    <i class="bi bi-geo-alt-fill"></i> Residential & Contact Records
                                </div>
                                <div class="info-grid">
                                    <div class="info-item" style="grid-column: span 2;">
                                        <span class="info-label">Primary Residence Address</span>
                                        <span class="info-value"><i class="bi bi-house-door-fill"></i>{{$teacher->address}}</span>
                                    </div>
                                    @if($teacher->address2)
                                    <div class="info-item" style="grid-column: span 2;">
                                        <span class="info-label">Secondary Address</span>
                                        <span class="info-value">{{$teacher->address2}}</span>
                                    </div>
                                    @endif
                                    <div class="info-item">
                                        <span class="info-label">City / Region</span>
                                        <span class="info-value">{{$teacher->city}}</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Postal / Zip Code</span>
                                        <span class="info-value fw-bold" style="font-family: monospace;">{{$teacher->zip}}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- 3. Security & Institutional Metadata (Extra High-Level Touch) -->
                            <div class="dossier-card border shadow-sm" style="border-left: 5px solid #3b82f6;">
                                <div class="dossier-header" style="background: white;">
                                    <i class="bi bi-lock-fill"></i> Institutional Metadata
                                </div>
                                <div class="info-grid py-3">
                                    <div class="info-item">
                                        <span class="info-label">System Member Since</span>
                                        <span class="info-value small text-muted">{{ $teacher->created_at->format('M d, Y') }}</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Primary Role</span>
                                        <span class="info-value"><span class="badge bg-primary px-3 rounded-pill">Academic Faculty</span></span>
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