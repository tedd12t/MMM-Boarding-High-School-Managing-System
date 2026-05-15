@extends('layouts.app')

@section('content')
<style>
    /* High-Level UI for Historical Data */
    .page-header h1 {
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -1px;
    }

    /* Professional Class Container */
    .class-history-card {
        background: #ffffff;
        border: none !important;
        border-radius: 20px !important;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05) !important;
        overflow: hidden;
        border-left: 6px solid #3b82f6 !important; /* Cyber Blue Accent */
    }

    .class-header-title {
        font-weight: 700;
        color: #1e293b;
        font-size: 1.1rem;
        padding: 20px 25px;
        background: #f8fafc;
    }

    /* Refined Accordion */
    .accordion-item {
        border: none !important;
        border-bottom: 1px solid #f1f5f9 !important;
    }

    .accordion-button {
        background: #ffffff !important;
        font-weight: 600;
        color: #475569 !important;
        padding: 18px 25px;
        box-shadow: none !important;
    }

    .accordion-button:not(.collapsed) {
        color: #2563eb !important;
        background: #eff6ff !important;
    }

    /* PREMIUM TIMELINE DESIGN */
    .timeline-container {
        padding-left: 20px;
        position: relative;
    }

    .timeline-line {
        position: absolute;
        left: 31px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #e2e8f0;
    }

    .timeline-item {
        position: relative;
        margin-bottom: 30px;
        padding-left: 45px;
    }

    .timeline-dot {
        position: absolute;
        left: 23px;
        top: 5px;
        width: 18px;
        height: 18px;
        background: #ffffff;
        border: 4px solid #3b82f6;
        border-radius: 50%;
        z-index: 2;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
    }

    /* High-Level Event Card */
    .event-card {
        background: #ffffff;
        border: 1px solid #f1f5f9 !important;
        border-radius: 16px !important;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.03) !important;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .event-card:hover {
        transform: translateX(5px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05) !important;
        border-color: #dbeafe !important;
    }

    .event-type-badge {
        background: #0f172a; /* Slate Dark */
        color: #ffffff;
        padding: 4px 12px;
        border-radius: 6px;
        font-weight: 700;
        font-size: 0.7rem;
        text-transform: uppercase;
    }

    .course-badge {
        background: #eff6ff;
        color: #2563eb;
        border: 1px solid #dbeafe;
        padding: 4px 12px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.75rem;
    }

    .marks-badge {
        background: #f8fafb;
        color: #64748b;
        border: 1px solid #e2e8f0;
        padding: 4px 12px;
        border-radius: 6px;
        font-weight: 700;
        font-size: 0.75rem;
    }

    .timestamp-top {
        font-size: 0.8rem;
        color: #94a3b8;
        font-weight: 600;
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
                            <i class="bi bi-clock-history text-primary me-2"></i> Academic Examination History
                        </h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="{{route('home')}}" class="text-decoration-none text-muted">Home</a></li>
                                <li class="breadcrumb-item active fw-bold text-primary">Exam Logs</li>
                            </ol>
                        </nav>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <!-- Class Level Card -->
                            <div class="class-history-card mb-5">
                                <div class="class-header-title d-flex align-items-center">
                                    <i class="bi bi-mortarboard-fill text-primary me-3 fs-4"></i>
                                    <span>Class #1</span>
                                </div>
                                
                                <div class="card-body p-0">
                                    <div class="accordion accordion-flush" id="historyAccordion">
                                        
                                        <!-- Section Block -->
                                        <div class="accordion-item">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#secOne">
                                                    <i class="bi bi-door-open me-2 opacity-50"></i> Section #1
                                                </button>
                                            </h2>
                                            <div id="secOne" class="accordion-collapse collapse" data-bs-parent="#historyAccordion">
                                                <div class="accordion-body bg-light bg-opacity-50 p-4">
                                                    
                                                    <!-- START TIMELINE -->
                                                    <div class="timeline-container">
                                                        <div class="timeline-line"></div>

                                                        <!-- Timeline Item 1 -->
                                                        <div class="timeline-item">
                                                            <div class="timeline-dot"></div>
                                                            <div class="event-card card">
                                                                <div class="card-body p-4">
                                                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                                                        <div>
                                                                            <h4 class="fw-bold text-dark mb-1">Quiz 1</h4>
                                                                            <span class="timestamp-top"><i class="bi bi-calendar3 me-1"></i> Jan 09, 2021 | 09:00 AM</span>
                                                                        </div>
                                                                        <span class="event-type-badge shadow-sm">Category: Quiz</span>
                                                                    </div>
                                                                    
                                                                    <div class="row align-items-center mb-3">
                                                                        <div class="col text-muted small">
                                                                            <i class="bi bi-layers me-1"></i> Part of: <strong>First Semester</strong>
                                                                        </div>
                                                                        <div class="col text-end small text-muted">
                                                                            <i class="bi bi-clock-history me-1"></i> Range: Jan 09 - Jan 15
                                                                        </div>
                                                                    </div>

                                                                    <div class="d-flex gap-2 border-top pt-3 mt-2">
                                                                        <span class="course-badge"><i class="bi bi-book me-1"></i> Mathematics</span>
                                                                        <span class="marks-badge"><i class="bi bi-award me-1"></i> Total Marks: 100</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Timeline Item 2 -->
                                                        <div class="timeline-item">
                                                            <div class="timeline-dot" style="border-color: #94a3b8;"></div>
                                                            <div class="event-card card">
                                                                <div class="card-body p-4">
                                                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                                                        <h5 class="fw-bold text-dark mb-0">Mid-Term Assessment</h5>
                                                                        <span class="timestamp-top">Jan 10, 2021 | 08:30 AM</span>
                                                                    </div>
                                                                    <p class="text-muted small mb-0">General session for all students to sign-up for semester lesson blocks and meet with course instructors.</p>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Timeline Item 3 -->
                                                        <div class="timeline-item">
                                                            <div class="timeline-dot" style="border-color: #10b981;"></div>
                                                            <div class="event-card card">
                                                                <div class="card-body p-4">
                                                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                                                        <h5 class="fw-bold text-dark mb-0">Orientation Day</h5>
                                                                        <span class="timestamp-top">Jan 09, 2021 | 07:00 AM</span>
                                                                    </div>
                                                                    <p class="text-muted small mb-0">Official welcome to the campus, campus safety tours, and distribution of library resources.</p>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <!-- END TIMELINE -->

                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
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