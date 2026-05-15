@extends('layouts.app')

@section('content')
<style>
    .page-title {
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -1px;
    }
    .table-container-card {
        background: #ffffff;
        border-radius: 20px;
        border: none;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        padding: 0;
    }

    .premium-table {
        margin-bottom: 0;
    }

    .premium-table thead th {
        background-color: #f8fafc;
        padding: 18px 25px;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 700;
        color: #64748b;
        border-bottom: 1px solid #e2e8f0;
    }

    .premium-table tbody tr {
        transition: all 0.2s ease;
    }

    .premium-table tbody tr:hover {
        background-color: #f1f5f9;
        transform: scale(1.002);
    }

    .premium-table td {
        padding: 20px 25px;
        vertical-align: middle;
        color: #1e293b;
        font-weight: 500;
        border-bottom: 1px solid #f1f5f9;
    }
    .btn-download {
        background-color: #ffffff;
        border: 1px solid #e2e8f0;
        color: #2563eb;
        border-radius: 10px;
        padding: 8px 16px;
        font-weight: 600;
        font-size: 0.85rem;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }

    .btn-download:hover {
        background-color: #2563eb;
        color: #ffffff;
        border-color: #2563eb;
        box-shadow: 0 4px 10px rgba(37, 99, 235, 0.2);
    }

    .btn-download i {
        margin-right: 8px;
    }

    .file-icon-box {
        width: 40px;
        height: 40px;
        background: #eff6ff;
        color: #3b82f6;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        margin-right: 15px;
    }
    .empty-state {
        padding: 60px;
        text-align: center;
        color: #94a3b8;
    }
</style>

<div class="container-fluid px-4">
    <div class="row">
        @include('layouts.left-menu')

        <div class="col-lg-10">
            <div class="row pt-4">
                <div class="col-12 ps-lg-5">
                    <div class="d-md-flex align-items-center justify-content-between mb-4">
                        <div>
                            <h1 class="page-title mb-1">
                                <i class="bi bi-journal-check text-primary me-2"></i> Course Assignments
                            </h1>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item"><a href="{{route('home')}}" class="text-decoration-none text-muted">Home</a></li>
                                    <li class="breadcrumb-item"><a href="{{url()->previous()}}" class="text-decoration-none text-muted">Courses</a></li>
                                    <li class="breadcrumb-item active fw-bold text-primary">Assignments</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    @include('session-messages')
                    <div class="table-container-card mt-4">
                        <table class="table premium-table">
                            <thead>
                                <tr>
                                    <th scope="col" style="width: 70%;">Assignment Information</th>
                                    <th scope="col" class="text-end">Resources</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($assignments) > 0)
                                    @foreach ($assignments as $assignment)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="file-icon-box">
                                                        <i class="bi bi-file-earmark-text-fill fs-5"></i>
                                                    </div>
                                                    <div>
                                                        <span class="d-block fs-6 fw-bold text-dark">{{$assignment->assignment_name}}</span>
                                                        <small class="text-muted">Uploaded recently</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-end">
                                                <a href="{{asset('storage/'.$assignment->assignment_file_path)}}" 
                                                   class="btn btn-download" 
                                                   target="_blank">
                                                    <i class="bi bi-cloud-arrow-down"></i> Download
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="2" class="empty-state">
                                            <i class="bi bi-folder2-open display-1 opacity-25"></i>
                                            <p class="mt-3 fs-5">No assignments found for this course yet.</p>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
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
