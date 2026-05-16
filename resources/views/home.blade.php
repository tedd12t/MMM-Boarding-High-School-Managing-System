@extends('layouts.app')

@section('content')
<style>
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
        color: #ffffff;
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
    .gender-analysis-card, .section-card {
        background: #1e293b !important; /* Matches the top stat cards */
        border: 1px solid rgba(255, 255, 255, 0.05) !important;
        border-radius: 20px !important;
        color: #ffffff !important;
    }
    .section-card-header {
        background: rgba(255, 255, 255, 0.03) !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
        padding: 15px 25px !important;
    }

    .section-card-header h5 {
        color: #ffffff !important;
        font-weight: 700 !important;
    }
    .accordion-item {
        background: transparent !important;
        border-color: rgba(255, 255, 255, 0.05) !important;
    }

    .accordion-button {
        background: transparent !important;
        color: #ffffff !important;
        box-shadow: none !important;
    }

    .accordion-button:not(.collapsed) {
        background: rgba(59, 130, 246, 0.1) !important;
        color: #60a5fa !important;
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
    .scroll-container {
        max-height: 400px;
        overflow-y: auto;
    }

    .scroll-container::-webkit-scrollbar { width: 5px; }
    .scroll-container::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    #full_calendar_events {
        color: #ffffff !important;
    }
    .fc-day-number, .fc-col-header-cell-cushion {
        color: #ffffff !important;
    .gender-analysis-card {
       width: 100% !important;
       margin-left: 0 !important;
       margin-right: 0 !important;
       box-sizing: border-box !important;
   }
   .progress {
       margin: 10px 0 !important;
   }
    }
</style>

<div class="container-fluid">
    <div class="row g-0">
        <!-- Sidebar Inclusion -->
        @include('layouts.left-menu')

        <div class="col-lg-10 p-0">
            <div class="pt-2">
                
                <!-- 1. HIGH-LEVEL HERO BANNER -->
                <div class="dashboard-hero shadow-lg">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h1 class="display-5 fw-800 mb-2">Maychew Martyrs Memorial Special Boarding School</h1>
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
                                <div class="stat-label">Teacher Members</div>
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
                <!-- 3. GENDER DEMOGRAPHICS (Aligned Width) -->
                @if($studentCount > 0)
                <div class="row g-4 mb-4"> <!-- This row and g-4 makes it align with the top cards -->
                    <div class="col-12">
                        <div class="gender-analysis-card border shadow-sm p-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="fw-800 text-uppercase small text-white-50 mb-0">Student Body Composition</h6>
                                <div class="d-flex gap-3">
                                    <small class="text-white"><i class="bi bi-circle-fill me-1" style="color: #3b82f6;"></i> Male</small>
                                    <small class="text-white"><i class="bi bi-circle-fill me-1" style="color: #60a5fa;"></i> Female</small>
                                </div>
                            </div>
                            @php
                                $count = $studentCount ?? 1;
                                $males = $maleStudentsBySession ?? 0;
                                $malePercent = round(($males / $count) * 100);
                                $femalePercent = 100 - $malePercent;
                            @endphp
                            <div class="progress" style="height: 12px; background: rgba(0,0,0,0.3); border-radius: 50px;">
                                <div class="progress-bar" role="progressbar" style="width: {{ $malePercent }}%; background-color: #3b82f6;"></div>
                                <div class="progress-bar" role="progressbar" style="width: {{ $femalePercent }}%; background-color: #60a5fa;"></div>
                            </div>
                            <div class="d-flex justify-content-between mt-2">
                                <span class="fw-bold text-white small">{{ $malePercent }}% Male</span>
                                <span class="fw-bold text-white small">{{ $femalePercent }}% Female</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                <!-- 4. EVENTS & NOTICES -->
                <div class="row g-4 mt-4">
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
                                <h5><i class="bi bi-broadcast text-primary me-2"></i>Official Announcements</h5>
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
                 @include('layouts.footer')
            </div>
        </div>
    </div>
</div>
@endsection
