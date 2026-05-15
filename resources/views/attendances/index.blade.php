@extends('layouts.app')

@section('content')
<style>
    .page-header h1 {
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -1px;
    }
    .class-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        overflow: hidden;
        margin-bottom: 25px;
    }

    .class-card:hover {
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        transform: translateY(-2px);
    }

    .class-card-header {
        background: #f8fafc;
        padding: 15px 20px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        font-weight: 700;
        color: #1e293b;
    }

    .class-card-header i {
        color: #3b82f6;
        margin-right: 10px;
    }
    .attendance-action-group {
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid #f1f5f9;
    }
    .action-item {
        padding: 12px 20px !important;
        border: none !important;
        border-bottom: 1px solid #f1f5f9 !important;
        font-weight: 500;
        color: #475569 !important;
        transition: all 0.2s;
        display: flex;
        align-items: center;
    }
    .action-item:last-child {
        border-bottom: none !important;
    }
    .action-item:hover {
        background-color: #eff6ff !important;
        color: #2563eb !important;
        padding-left: 25px !important;
    }
    .action-item i {
        margin-right: 12px;
        font-size: 1.1rem;
        opacity: 0.7;
    }
    .accordion-item {
        border: 1px solid #f1f5f9 !important;
        border-radius: 12px !important;
        margin-bottom: 10px;
        overflow: hidden;
    }
    .accordion-button {
        background: #ffffff !important;
        font-weight: 600;
        color: #334155 !important;
        box-shadow: none !important;
        padding: 15px 20px;
    }
    .accordion-button:not(.collapsed) {
        color: #2563eb !important;
        background: #f8fafc !important;
    }
    .course-title-badge {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #64748b;
        margin-bottom: 10px;
        display: block;
        font-weight: 700;
    }
</style>

<div class="container-fluid px-4">
    <div class="row">
        @include('layouts.left-menu')

        <div class="col-lg-10">
            <div class="row pt-4">
                <div class="col-12 ps-lg-5">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div>
                            <h1 class="page-header mb-1">
                                <i class="bi bi-calendar2-check text-primary me-2"></i> Attendance Managment
                            </h1>
                            <p class="text-muted">Select a class or course to manage student presence.</p>
                        </div>
                        <div class="badge bg-soft-primary text-primary p-2 px-3 rounded-pill border border-primary">
                            <i class="bi bi-gear-fill me-1"></i> Mode: {{ ucfirst($academic_setting->attendance_type) }}
                        </div>
                    </div>

                    <div class="row">
                        @foreach ($classes_and_sections['school_classes'] as $school_class)
                        <div class="col-xl-6 col-xxl-4">
                            <div class="class-card">
                                <div class="class-card-header">
                                    <i class="bi bi-mortarboard-fill"></i>
                                    {{$school_class->class_name}}
                                </div>
                                <div class="card-body">
                                    
                                    @if ($academic_setting->attendance_type == 'course')
                                        {{-- COURSE MODE DESIGN --}}
                                        @foreach ($courses as $course)
                                            @if ($course->class_id == $school_class->id)
                                                <span class="course-title-badge">Course: {{$course->course_name}}</span>
                                                <div class="attendance-action-group mb-4">
                                                    <a href="{{url('attendances/view?class_id='.$school_class->id.'&class_name='.$school_class->class_name.'&course_id='.$course->id.'&course_name='.$course->course_name)}}" 
                                                       class="action-item list-group-item-action">
                                                        <i class="bi bi-eye"></i> View History
                                                    </a>
                                                    <a href="{{url('attendances/take?class_id='.$school_class->id.'&class_name='.$school_class->class_name.'&course_id='.$course->id.'&course_name='.$course->course_name)}}" 
                                                       class="action-item list-group-item-action">
                                                        <i class="bi bi-check2-square text-success"></i> Take Attendance
                                                    </a>
                                                </div>   
                                            @endif
                                        @endforeach
                                    @else
                                        {{-- SECTION MODE DESIGN --}}
                                        <div class="accordion accordion-flush" id="accordionClass{{$school_class->id}}">
                                            @foreach ($classes_and_sections['school_sections'] as $school_section)
                                                @if($school_section->class_id == $school_class->id) {{-- Optional logic check --}}
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header">
                                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseClass{{$school_class->id}}Section{{$school_section->id}}">
                                                            Section: {{$school_section->section_name}}
                                                        </button>
                                                    </h2>
                                                    <div id="collapseClass{{$school_class->id}}Section{{$school_section->id}}" class="accordion-collapse collapse" data-bs-parent="#accordionClass{{$school_class->id}}">
                                                        <div class="accordion-body p-0">
                                                            <div class="attendance-action-group">
                                                                <a href="{{url('attendances/view?class_id='.$school_class->id.'&section_id='.$school_section->id.'&class_name='.$school_class->class_name.'&section_name='.$school_section->section_name)}}" 
                                                                   class="action-item list-group-item-action">
                                                                    <i class="bi bi-calendar-range"></i> View Attendance Records
                                                                </a>
                                                                <a href="{{url('attendances/take?class_id='.$school_class->id.'&class_name='.$school_class->class_name.'&section_id='.$school_section->id.'&section_name='.$school_section->section_name)}}" 
                                                                   class="action-item list-group-item-action">
                                                                    <i class="bi bi-person-check-fill text-success"></i> Launch Attendance Sheet
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    @endif

                                </div>
                            </div>
                        </div>
                        @endforeach
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
