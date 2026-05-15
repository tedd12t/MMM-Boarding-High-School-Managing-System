@extends('layouts.app')

@section('content')
<style>
    /* High-Level UI for Administrative Migration */
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

    /* Modern Filter Surface */
    .filter-card {
        background: #ffffff;
        border-radius: 20px;
        padding: 25px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        margin-bottom: 30px;
    }

    .filter-label {
        font-weight: 700;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #64748b;
        margin-bottom: 8px;
        display: block;
    }

    /* Premium Data Grid */
    .registry-card {
        background: #ffffff;
        border-radius: 24px;
        border: none;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    .premium-table thead th {
        background-color: #0f172a; /* Institutional Slate */
        color: #ffffff;
        padding: 18px 25px;
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        font-weight: 700;
        border: none;
    }

    .premium-table td {
        padding: 18px 25px;
        vertical-align: middle;
        color: #1e293b;
        font-weight: 500;
        border-bottom: 1px solid #f1f5f9;
    }

    /* Status Badging */
    .status-badge {
        padding: 6px 14px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 0.75rem;
        display: inline-flex;
        align-items: center;
    }
    .status-promoted {
        background: #ecfdf5;
        color: #059669;
        border: 1px solid #10b981;
    }
    .status-pending {
        background: #f1f5f9;
        color: #64748b;
        border: 1px solid #e2e8f0;
    }

    /* Action Button Styling */
    .btn-promote-pill {
        background-color: #ffffff !important;
        border: 1px solid #3b82f6 !important;
        color: #2563eb !important;
        border-radius: 10px !important;
        padding: 8px 20px !important;
        font-weight: 700 !important;
        font-size: 0.8rem !important;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.2s;
    }

    .btn-promote-pill:hover {
        background-color: #3b82f6 !important;
        color: #ffffff !important;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        transform: translateY(-1px);
    }

    .btn-load {
        background: #0f172a !important;
        color: white !important;
        border: none !important;
        border-radius: 10px !important;
        padding: 10px 25px !important;
        font-weight: 700 !important;
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
                            <i class="bi bi-arrow-up-circle text-primary me-2"></i> Section Promotion Registry
                        </h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-premium mb-0">
                                <li class="breadcrumb-item"><a href="{{route('home')}}" class="text-decoration-none">Home</a></li>
                                <li class="breadcrumb-item active fw-bold text-primary">Promote Sections</li>
                            </ol>
                        </nav>
                    </div>

                    <!-- Filter Station -->
                    <div class="filter-card border shadow-sm">
                        <form action="{{route('promotions.index')}}" method="GET">
                            <div class="row align-items-end g-3">
                                <div class="col-md-4">
                                    <label class="filter-label">Select Source Class</label>
                                    <select class="form-select border-2" name="class_id" required style="border-radius: 10px; padding: 10px;">
                                        @isset($previousSessionClasses)
                                            <option selected disabled>Choose Class...</option>
                                            @foreach ($previousSessionClasses as $school_class)
                                            <option value="{{$school_class->schoolClass->id}}">{{$school_class->schoolClass->class_name}}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-load w-100 shadow-sm">
                                        <i class="bi bi-funnel-fill me-2"></i> Load Sections
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Data Grid Card -->
                    <div class="registry-card border shadow-sm mb-5">
                        <div class="table-responsive">
                            <table class="table premium-table mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col">Academic Section</th>
                                        <th scope="col" class="text-center">Migration Status</th>
                                        <th scope="col" class="text-end">Operational Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @isset($previousSessionSections)
                                        @if(count($previousSessionSections) > 0)
                                            @foreach ($previousSessionSections as $previousSessionSection)
                                            <tr>
                                                <td class="fw-bold fs-6">
                                                    <i class="bi bi-door-open me-2 text-primary opacity-50"></i>
                                                    {{$previousSessionSection->section->section_name}}
                                                </td>
                                                <td class="text-center">
                                                    @if ($currentSessionSectionsCounts > 0)
                                                        <span class="status-badge status-promoted">
                                                            <i class="bi bi-check-circle-fill me-2"></i>PROMOTED
                                                        </span>
                                                    @else
                                                        <span class="status-badge status-pending">
                                                            <i class="bi bi-clock-history me-2"></i>PENDING
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="text-end">
                                                    @if ($currentSessionSectionsCounts > 0)
                                                        <span class="text-muted small fw-bold italic">
                                                            <i class="bi bi-shield-check me-1"></i> Finalized
                                                        </span>
                                                    @else
                                                        {{-- Original Logic: Route Parameters Preserved --}}
                                                        <a href="{{route('promotions.create', ['previousSessionId' => $previousSessionId,'previous_section_id' => $previousSessionSection->section->id, 'previous_class_id' => $class_id])}}" 
                                                           class="btn btn-promote-pill">
                                                            <i class="bi bi-arrow-up-right-circle me-1"></i> Start Promotion
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="3" class="py-5 text-center text-muted">
                                                    <i class="bi bi-inbox display-1 opacity-10 d-block mb-3"></i>
                                                    No sections found for this class in the previous session.
                                                </td>
                                            </tr>
                                        @endif
                                    @endisset
                                </tbody>
                            </table>
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