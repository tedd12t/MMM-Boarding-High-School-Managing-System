@extends('layouts.app')

@section('content')
<style>
    /* High-Level UI for Faculty Registry */
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

    /* Premium Data Card */
    .registry-card {
        background: #ffffff;
        border-radius: 24px;
        border: none;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        margin-top: 20px;
    }

    .premium-table thead th {
        background-color: #0f172a; /* Industrial Slate */
        color: #ffffff;
        padding: 18px 25px;
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        font-weight: 700;
        border: none;
    }

    .premium-table tbody tr {
        transition: all 0.2s ease;
    }

    .premium-table tbody tr:hover {
        background-color: #f8fafc;
    }

    .premium-table td {
        padding: 15px 25px;
        vertical-align: middle;
        color: #1e293b;
        font-weight: 500;
        border-bottom: 1px solid #f1f5f9;
    }

    /* Faculty Avatar Styling */
    .faculty-avatar {
        width: 45px;
        height: 45px;
        object-fit: cover;
        border-radius: 12px;
        border: 2px solid #3b82f6;
        padding: 2px;
        background: #fff;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
    }

    .avatar-placeholder {
        width: 45px;
        height: 45px;
        background: #f1f5f9;
        color: #94a3b8;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        font-size: 1.4rem;
        border: 2px solid #e2e8f0;
    }

    /* Contact Info Stacking */
    .contact-cell {
        display: flex;
        flex-direction: column;
    }

    .contact-main {
        font-weight: 700;
        color: #0f172a;
        font-size: 0.9rem;
    }

    .contact-sub {
        font-size: 0.75rem;
        color: #64748b;
        margin-top: 2px;
    }

    /* Action Pill Styling */
    .btn-action-pill {
        border-radius: 10px !important;
        padding: 6px 14px !important;
        font-size: 0.8rem !important;
        font-weight: 700 !important;
        text-transform: uppercase;
        letter-spacing: 0.5px;
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

    .status-indicator {
        width: 8px;
        height: 8px;
        background: #10b981;
        border-radius: 50%;
        display: inline-block;
        margin-right: 8px;
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
                    <div class="mb-4 d-md-flex align-items-center justify-content-between">
                        <div>
                            <h1 class="page-header mb-1">
                                <i class="bi bi-person-workspace text-primary me-2"></i> Faculty Registry
                            </h1>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb breadcrumb-premium mb-0">
                                    <li class="breadcrumb-item"><a href="{{route('home')}}" class="text-decoration-none">Home</a></li>
                                    <li class="breadcrumb-item active fw-bold text-primary">Teacher List</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="mt-3 mt-md-0">
                            <span class="badge bg-soft-primary text-primary border border-primary px-3 py-2 rounded-pill">
                                <i class="bi bi-people-fill me-1"></i> Total Faculty: {{ count($teachers) }}
                            </span>
                        </div>
                    </div>

                    @include('session-messages')

                    <!-- Main Data Table Card -->
                    <div class="registry-card border shadow-sm mb-5">
                        <div class="table-responsive">
                            <table class="table premium-table mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col" style="width: 80px;">Profile</th>
                                        <th scope="col">Teacher Identity</th>
                                        <th scope="col">Communication</th>
                                        <th scope="col">Access Level</th>
                                        <th scope="col" class="text-end">Management</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($teachers) > 0)
                                        @foreach ($teachers as $teacher)
                                        <tr>
                                            <td>
                                                @if (isset($teacher->photo))
                                                    <img src="{{asset('/storage'.$teacher->photo)}}" class="faculty-avatar shadow-sm" alt="Faculty Photo">
                                                @else
                                                    <div class="avatar-placeholder shadow-sm">
                                                        <i class="bi bi-person-fill"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="contact-cell">
                                                    <span class="contact-main">{{$teacher->first_name}} {{$teacher->last_name}}</span>
                                                    <span class="contact-sub text-uppercase fw-bold"><i class="bi bi-shield-check text-success me-1"></i>Verified Faculty</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="contact-cell">
                                                    <span class="small fw-bold text-dark"><i class="bi bi-envelope-at me-2 opacity-50"></i>{{$teacher->email}}</span>
                                                    <span class="small text-muted mt-1"><i class="bi bi-phone me-2 opacity-50"></i>{{$teacher->phone}}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-light text-dark border px-3 py-2 fw-700 shadow-sm" style="font-size: 0.7rem;">
                                                    <span class="status-indicator"></span>INSTRUCTOR
                                                </span>
                                            </td>
                                            <td class="text-end">
                                                <div class="btn-group gap-2">
                                                    <a href="{{url('teachers/view/profile/'.$teacher->id)}}" class="btn btn-action-pill">
                                                        <i class="bi bi-person-vcard me-1"></i> Profile
                                                    </a>
                                                    
                                                    @can('edit users')
                                                    <a href="{{route('teacher.edit.show', ['id' => $teacher->id])}}" class="btn btn-action-pill">
                                                        <i class="bi bi-pencil-square text-primary"></i>
                                                    </a>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5" class="py-5 text-center text-muted">
                                                <i class="bi bi-person-x display-1 opacity-10 d-block mb-3"></i>
                                                No faculty records found in the database.
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
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