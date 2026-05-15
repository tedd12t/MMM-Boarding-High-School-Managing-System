@extends('layouts.app')

@section('content')
<style>
    /* High-Level Dashboard UI */
    .dashboard-hero {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        border-radius: 24px;
        padding: 40px;
        color: white;
        margin-bottom: 30px;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        position: relative;
        overflow: hidden;
    }

    .dashboard-hero::after {
        content: "";
        position: absolute;
        right: -50px;
        bottom: -50px;
        width: 200px;
        height: 200px;
        background: rgba(59, 130, 246, 0.1);
        border-radius: 50%;
    }

    /* Stat Cards Architecture */
    .stat-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        padding: 25px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        height: 100%;
        display: flex;
        align-items: center;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05);
        border-color: #3b82f6;
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        margin-right: 20px;
    }

    .icon-students { background: #eff6ff; color: #3b82f6; }
    .icon-teachers { background: #ecfdf5; color: #10b981; }
    .icon-classes { background: #fffbeb; color: #f59e0b; }

    .stat-label {
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #64748b;
        margin-bottom: 2px;
    }

    .stat-value {
        font-size: 1.8rem;
        font-weight: 800;
        color: #0f172a;
        line-height: 1;
    }

    /* Progress & Demographics */
    .gender-analysis-card {
        background: white;
        border-radius: 20px;
        padding: 20px 30px;
        border: 1px solid #e2e8f0;
    }

    .progress {
        height: 12px;
        border-radius: 50px;
        background: #f1f5f9;
        overflow: hidden;
    }

    /* Notice & Event Components */
    .section-card {
        background: white;
        border-radius: 24px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        height: 100%;
    }

    .section-card-header {
        padding: 20px 25px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .section-card-header h5 {
        font-weight: 800;
        font-size: 1rem;
        color: #0f172a;
        margin-bottom: 0;
    }

    .notice-item {
        border: none !important;
        border-bottom: 1px solid #f8fafc !important;
        padding: 15px 20px !important;
    }

    .notice-date {
        font-size: 0.75rem;
        font-weight: 600;
        color: #3b82f6;
        text-transform: uppercase;
    }

    /* Scrollbar for 4GB RAM Efficiency */
    .scroll-container {
        max-height: 400px;
        overflow-y: auto;
    }

    .scroll-container::-webkit-scrollbar { width: 5px; }
    .scroll-container::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
</style>

<div class="container-fluid">
    <div class="row g-0">
        <!-- Sidebar Inclusion -->
        @include('layouts.left-menu')

        <div class="col-12 px-0">
            <div class="pt-3">
                
                <!-- 1. HIGH-LEVEL HERO BANNER -->
                <div class="dashboard-hero shadow-lg">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <span class="badge bg-primary mb-3 px-3 py-2 rounded-pill fw-bold" style="background: rgba(59, 130, 246, 0.2) !important;">
                                <i class="bi bi-shield-check me-2"></i> Authorized Administrative Session
                            </span>
                            <h1 class="display-5 fw-800 mb-2">Command Center</h1>
                            <p class="lead opacity-75">Maychew Martyrs Memorial Special Boarding School</p>
                        </div>
                        <div class="col-md-4 text-end d-none d-md-block">
                            <i class="bi bi-cpu fs-1 opacity-25" style="font-size: 6rem !important;"></i>
                        </div>
                    </div>
                </div>

                <!-- 2. ANALYTICS GRID -->
                <div class="row g-4 mb-4">
                    <!-- Students -->
                    <div class="col-md-4">
                        <div class="stat-card border">
                            <div class="stat-icon icon-students shadow-sm">
                                <i class="bi bi-people-fill"></i>
                            </div>
                            <div>
                                <div class="stat-label">Total Enrollment</div>
                                <div class="stat-value">{{ $studentCount ?? 0 }}</div>
                            </div>
                        </div>
                    </div>
                    <!-- Teachers -->
                    <div class="col-md-4">
                        <div class="stat-card border">
                            <div class="stat-icon icon-teachers shadow-sm">
                                <i class="bi bi-person-workspace"></i>
                            </div>
                            <div>
                                <div class="stat-label">Faculty Members</div>
                                <div class="stat-value">{{ $teacherCount ?? 0 }}</div>
                            </div>
                        </div>
                    </div>
                    <!-- Classes -->
                    <div class="col-md-4">
                        <div class="stat-card border">
                            <div class="stat-icon icon-classes shadow-sm">
                                <i class="bi bi-diagram-3-fill"></i>
                            </div>
                            <div>
                                <div class="stat-label">Active Classes</div>
                                <div class="stat-value">{{ $classCount ?? 0 }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 3. GENDER DEMOGRAPHICS (Original Logic) -->
                @if($studentCount > 0)
                <div class="gender-analysis-card border shadow-sm mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-800 text-uppercase small text-muted mb-0">Student Body Composition</h6>
                        <div class="d-flex gap-3">
                            <small><i class="bi bi-circle-fill text-primary me-1"></i> Male</small>
                            <small><i class="bi bi-circle-fill me-1" style="color: #60a5fa;"></i> Female</small>
                        </div>
                    </div>
                    @php
                        $maleStudentPercentage = round(($maleStudentsBySession/$studentCount), 2) * 100;
                        $femaleStudentPercentage = 100 - $maleStudentPercentage;
                    @endphp
                    <div class="progress shadow-inner">
                        <div class="progress-bar progress-bar-animated" role="progressbar" style="background-color: #3b82f6; width: {{$maleStudentPercentage}}%" aria-valuenow="{{$maleStudentPercentage}}" aria-valuemin="0" aria-valuemax="100"></div>
                        <div class="progress-bar" role="progressbar" style="background-color: #60a5fa; width: {{$femaleStudentPercentage}}%" aria-valuenow="{{$femaleStudentPercentage}}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="d-flex justify-content-between mt-2">
                        <span class="small fw-bold">{{$maleStudentPercentage}}%</span>
                        <span class="small fw-bold">{{$femaleStudentPercentage}}%</span>
                    </div>
                </div>
                @endif

                <!-- 4. EVENTS & NOTICES -->
                <div class="row g-4 mb-5">
                    <!-- Events -->
                    <div class="col-lg-6">
                        <div class="section-card border shadow-sm">
                            <div class="section-card-header">
                                <h5><i class="bi bi-calendar3 text-primary me-2"></i>Institutional Calendar</h5>
                                <a href="{{ route('events.show') }}" class="btn btn-sm btn-light border small">Manage</a>
                            </div>
                            <div class="card-body">
                                @include('components.events.event-calendar', ['editable' => 'false', 'selectable' => 'false'])
                            </div>
                        </div>
                    </div>

                    <!-- Notices -->
                    <div class="col-lg-6">
                        <div class="section-card border shadow-sm">
                            <div class="section-card-header">
                                <h5><i class="bi bi-broadcast text-primary me-2"></i>Official Notices</h5>
                                <div class="small">{{ $notices->links() }}</div>
                            </div>
                            <div class="card-body p-0">
                                <div class="scroll-container">
                                    @isset($notices)
                                    <div class="accordion accordion-flush" id="noticeAccordion">
                                        @foreach ($notices as $notice)
                                        <div class="accordion-item notice-item">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button collapsed py-2 px-0 bg-transparent shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#not{{$notice->id}}">
                                                    <div>
                                                        <span class="notice-date d-block">Published: {{ $notice->created_at->format('M d, Y') }}</span>
                                                        <span class="fw-bold text-dark">Subject: {{ Str::limit(strip_tags($notice->notice), 40) }}</span>
                                                    </div>
                                                </button>
                                            </h2>
                                            <div id="not{{$notice->id}}" class="accordion-collapse collapse" data-bs-parent="#noticeAccordion">
                                                <div class="accordion-body pt-2 pb-3 px-0 small text-muted">
                                                    {!! Purify::clean($notice->notice) !!}
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    @else
                                        <div class="p-5 text-center text-muted">
                                            <i class="bi bi-chat-dots display-4 opacity-10"></i>
                                            <p class="mt-2">No active announcements</p>
                                        </div>
                                    @endisset
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            @include('layouts.footer')
        </div>
    </div>
</div>
@endsection
