@extends('layouts.app')

@section('content')
<style>
    /* High-Level UI for Grading Architecture */
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

    /* Premium Table Surface */
    .table-container-card {
        background: #ffffff;
        border-radius: 20px;
        border: none;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        margin-top: 20px;
    }

    .premium-table thead th {
        background-color: #f8fafc;
        padding: 18px 25px;
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        font-weight: 700;
        color: #64748b;
        border-bottom: 1px solid #e2e8f0;
    }

    .premium-table tbody tr {
        transition: all 0.2s ease;
    }

    .premium-table tbody tr:hover {
        background-color: #f1f5f9;
    }

    .premium-table td {
        padding: 20px 25px;
        vertical-align: middle;
        color: #1e293b;
        font-weight: 500;
        border-bottom: 1px solid #f1f5f9;
    }

    /* Metadata Badges */
    .meta-pills {
        background: #eff6ff;
        color: #3b82f6;
        padding: 4px 12px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 0.75rem;
        border: 1px solid #dbeafe;
        display: inline-flex;
        align-items: center;
    }

    .timestamp-text {
        font-size: 0.8rem;
        color: #94a3b8;
        font-family: monospace;
    }

    /* Action Buttons Architecture */
    .btn-action-pill {
        border-radius: 10px !important;
        padding: 8px 16px !important;
        font-size: 0.85rem !important;
        font-weight: 700 !important;
        border: 1px solid #e2e8f0 !important;
        background: white !important;
        color: #475569 !important;
        transition: all 0.2s;
    }

    .btn-action-pill:hover {
        background: #3b82f6 !important;
        color: white !important;
        border-color: #3b82f6 !important;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.25);
    }

    .btn-add-rule {
        border-color: #10b981 !important;
        color: #059669 !important;
    }

    .btn-add-rule:hover {
        background: #10b981 !important;
        color: white !important;
        border-color: #10b981 !important;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.25);
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
                            <i class="bi bi-layers-half text-primary me-2"></i> Grading Frameworks
                        </h1>
                        <nav aria-label="breadcrumb" class="mt-2">
                            <ol class="breadcrumb breadcrumb-premium mb-0">
                                <li class="breadcrumb-item"><a href="{{route('home')}}" class="text-decoration-none text-muted">Home</a></li>
                                <li class="breadcrumb-item active fw-bold text-primary">Grading Systems</li>
                            </ol>
                        </nav>
                    </div>

                    @include('session-messages')

                    <!-- Main List Card -->
                    <div class="table-container-card border shadow-sm mb-5">
                        <div class="table-responsive">
                            <table class="table premium-table mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col" style="width: 30%;">System Nomenclature</th>
                                        <th scope="col">Academic Level</th>
                                        <th scope="col">Semester</th>
                                        <th scope="col">Initialized</th>
                                        <th scope="col" class="text-end">Management</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @isset($gradingSystems)
                                        @if(count($gradingSystems) > 0)
                                            @foreach ($gradingSystems as $gradingSystem)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="me-3" style="width: 35px; height: 35px; background: #f1f5f9; color: #475569; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                                            <i class="bi bi-gear-wide-connected"></i>
                                                        </div>
                                                        <span class="fw-800 text-dark">{{$gradingSystem->system_name}}</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="meta-pills shadow-sm">
                                                        <i class="bi bi-mortarboard me-2"></i>{{$gradingSystem->schoolClass->class_name}}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="text-muted fw-bold small">
                                                        <i class="bi bi-calendar3 me-2"></i>{{$gradingSystem->semester->semester_name}}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="timestamp-text">
                                                        {{ \Carbon\Carbon::parse($gradingSystem->created_at)->format('Y-m-d') }}
                                                    </span>
                                                </td>
                                                <td class="text-end">
                                                    <div class="btn-group gap-2">
                                                        {{-- Original Logic: Route Parameters Preserved --}}
                                                        <a href="{{route('exam.grade.system.rule.create', ['grading_system_id' => $gradingSystem->id])}}" 
                                                           class="btn btn-action-pill btn-add-rule">
                                                            <i class="bi bi-plus-lg me-1"></i> Add Rule
                                                        </a>
                                                        
                                                        <a href="{{route('exam.grade.system.rule.show', ['grading_system_id' => $gradingSystem->id])}}" 
                                                           class="btn btn-action-pill">
                                                            <i class="bi bi-eye-fill me-1"></i> Rules
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="5" class="py-5 text-center text-muted">
                                                    <i class="bi bi-clipboard-x display-4 d-block mb-3 opacity-25"></i>
                                                    No grading systems defined yet. 
                                                    <a href="{{ url('academics/settings') }}" class="d-block mt-2 text-primary fw-bold text-decoration-none">Create one in Academic Settings</a>
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

            <div class="mt-5">
                @include('layouts.footer')
            </div>
        </div>
    </div>
</div>
@endsection