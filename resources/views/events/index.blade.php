@extends('layouts.app')

@section('content')
<style>
    /* High-Level UI for Management Surfaces */
    .page-title {
        font-weight: 800;
        color: #ffffff !important;
        letter-spacing: -1px;
    }

    /* Professional Workspace Card */
    .calendar-workspace-card {
        background: #ffffff;
        border-radius: 24px;
        border: none;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
        padding: 35px;
        margin-top: 20px;
    }

    .management-badge {
        background: #eff6ff;
        color: #1e40af;
        border: 1px solid #dbeafe;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        padding: 6px 16px;
        border-radius: 50px;
    }

    /* Helper Instruction Box */
    .instruction-box {
        background: #f8fafc;
        border-radius: 16px;
        padding: 20px;
        border-left: 5px solid #3b82f6;
        margin-bottom: 25px;
    }

    .instruction-box h6 {
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 5px;
    }

    .instruction-box p {
        font-size: 0.85rem;
        color: #64748b;
        margin-bottom: 0;
    }

    /* Breadcrumb Refinement */
    .breadcrumb-premium {
        background: transparent;
        padding: 0;
        margin-bottom: 10px;
    }

    .breadcrumb-item a {
        color: #94a3b8;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.2s;
    }

    .breadcrumb-item a:hover {
        color: #3b82f6;
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
                    <div class="d-md-flex align-items-center justify-content-between mb-2">
                        <div>
                            <nav aria-label="breadcrumb" class="breadcrumb-premium">
                                <ol class="breadcrumb mb-1">
                                    <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                                    <li class="breadcrumb-item active fw-bold text-primary">Academic Events</li>
                                </ol>
                            </nav>
                            <h1 class="page-title mb-1">
                                <i class="bi bi-calendar-check-fill text-primary me-2"></i> Event Planning Center
                            </h1>
                        </div>
                        <div class="mt-3 mt-md-0">
                            <span class="management-badge">
                                <i class="bi bi-shield-lock-fill me-2"></i> Administrator Access
                            </span>
                        </div>
                    </div>

                    <!-- User Guidance Box -->
                    <div class="instruction-box shadow-sm mt-4">
                        <div class="d-flex align-items-center">
                            <div class="me-3 fs-3 text-primary">
                                <i class="bi bi-info-circle-fill"></i>
                            </div>
                            <div>
                                <h6>Interactive Scheduling</h6>
                                <p>Click on any date to create a new event. You can drag and drop existing events to reschedule them instantly across the academic year.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Main Calendar Surface -->
                    <div class="calendar-workspace-card border shadow-sm mb-5">
                        <div class="p-1">
                            {{-- Logic preserved exactly as original --}}
                            @include('components.events.event-calendar', [
                                'editable' => 'true', 
                                'selectable' => 'true'
                            ])
                        </div>
                    </div>

                </div>
            </div>

            <div class="mt-4">
                @include('layouts.footer')
            </div>
        </div>
    </div>
</div>
@endsection
