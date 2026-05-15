@extends('layouts.app')

@section('content')
<style>
    /* High-Level UI for Document Repositories */
    .page-title {
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

    /* Modern Document Card */
    .repository-card {
        background: #ffffff;
        border-radius: 20px;
        border: none;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        margin-top: 20px;
    }

    /* Premium Table Styling */
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
        transform: scale(1.001);
    }

    .premium-table td {
        padding: 20px 25px;
        vertical-align: middle;
        color: #1e293b;
        font-weight: 500;
        border-bottom: 1px solid #f1f5f9;
    }

    /* Document Icon Decor */
    .doc-icon-box {
        width: 45px;
        height: 45px;
        background: #fef2f2; /* Soft red for PDF/Documents */
        color: #ef4444;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        margin-right: 15px;
        font-size: 1.3rem;
        box-shadow: 0 4px 6px -1px rgba(239, 68, 68, 0.1);
    }

    /* Premium Download Button */
    .btn-download-pill {
        background-color: #ffffff;
        border: 1px solid #e2e8f0;
        color: #2563eb;
        border-radius: 50px;
        padding: 8px 20px;
        font-weight: 700;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
    }

    .btn-download-pill:hover {
        background-color: #2563eb;
        color: #ffffff;
        border-color: #2563eb;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        transform: translateY(-1px);
    }

    .btn-download-pill i {
        margin-right: 8px;
    }

    /* Empty State */
    .empty-repo {
        padding: 80px 20px;
        text-align: center;
        color: #94a3b8;
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
                    <div class="d-md-flex align-items-center justify-content-between mb-4">
                        <div>
                            <h1 class="page-title mb-1">
                                <i class="bi bi-journal-richtext text-primary me-2"></i> Academic Syllabus Repository
                            </h1>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb breadcrumb-premium mb-0">
                                    <li class="breadcrumb-item"><a href="{{route('home')}}" class="text-decoration-none text-muted">Home</a></li>
                                    <li class="breadcrumb-item"><a href="{{url()->previous()}}" class="text-decoration-none text-muted">Courses</a></li>
                                    <li class="breadcrumb-item active fw-bold text-primary">Syllabus</li>
                                </ol>
                            </nav>
                        </div>
                    </div>

                    @include('session-messages')

                    <!-- Repository Table Card -->
                    <div class="repository-card border shadow-sm mb-5">
                        <div class="table-responsive">
                            <table class="table premium-table mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col" style="width: 70%;">Curriculum Document</th>
                                        <th scope="col" class="text-end">Resource Access</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($syllabi) > 0)
                                        @foreach ($syllabi as $syllabus)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="doc-icon-box">
                                                            <i class="bi bi-file-earmark-pdf-fill"></i>
                                                        </div>
                                                        <div>
                                                            <span class="d-block fs-6 fw-bold text-dark">{{$syllabus->syllabus_name}}</span>
                                                            <small class="text-muted">Institutional Curriculum Guide</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-end">
                                                    <a href="{{asset('storage/'.$syllabus->syllabus_file_path)}}" 
                                                       class="btn btn-download-pill" 
                                                       target="_blank">
                                                        <i class="bi bi-cloud-arrow-down-fill"></i> Download
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="2" class="empty-repo">
                                                <i class="bi bi-folder-x display-1 opacity-25"></i>
                                                <p class="mt-3 fs-5 fw-bold text-dark">No syllabus documents available.</p>
                                                <p class="small">The curriculum for this course has not been uploaded yet.</p>
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