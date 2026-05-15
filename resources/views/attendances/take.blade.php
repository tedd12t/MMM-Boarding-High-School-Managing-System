@extends('layouts.app')

@section('content')
<style>
    /* High-Level UI for Data Entry */
    .attendance-header-box {
        background: white;
        border-radius: 16px;
        padding: 25px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        border: 1px solid #e2e8f0;
        margin-bottom: 25px;
    }

    .context-badge {
        background: #f1f5f9;
        color: #475569;
        padding: 6px 14px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.85rem;
        border: 1px solid #e2e8f0;
    }

    /* Modern Table Styling */
    .sheet-card {
        background: #ffffff;
        border-radius: 20px;
        border: none;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    .sheet-table thead th {
        background-color: #f8fafc;
        padding: 18px 25px;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 700;
        color: #64748b;
        border-bottom: 1px solid #e2e8f0;
    }

    .sheet-table tbody tr {
        transition: background 0.2s;
        cursor: pointer;
    }

    .sheet-table tbody tr:hover {
        background-color: #f8fafc;
    }

    .sheet-table td {
        padding: 15px 25px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
    }

    /* ID Badge */
    .id-badge {
        background: #0f172a;
        color: white;
        padding: 4px 10px;
        border-radius: 6px;
        font-family: monospace;
        font-size: 0.9rem;
    }

    /* Modern Checkbox/Switch */
    .form-check-input {
        width: 1.5em;
        height: 1.5em;
        cursor: pointer;
        border: 2px solid #cbd5e1;
    }

    .form-check-input:checked {
        background-color: #10b981;
        border-color: #10b981;
    }

    /* Floating Submit Bar */
    .submit-bar {
        background: #ffffff;
        border-top: 1px solid #e2e8f0;
        padding: 20px 0;
        margin-top: 20px;
    }

    .btn-submit-premium {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%) !important;
        color: white !important;
        border: none !important;
        border-radius: 12px !important;
        padding: 12px 40px !important;
        font-weight: 700 !important;
        box-shadow: 0 4px 14px rgba(59, 130, 246, 0.4);
        transition: transform 0.2s;
    }

    .btn-submit-premium:hover {
        transform: translateY(-2px);
    }
</style>

<div class="container-fluid px-4">
    <div class="row">
        <!-- Sidebar Inclusion -->
        @include('layouts.left-menu')

        <div class="col-lg-10">
            <div class="row pt-4">
                <div class="col-12 ps-lg-5">
                    
                    <!-- Top Header -->
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div>
                            <h1 class="fw-800 text-dark mb-1">
                                <i class="bi bi-person-check text-primary me-2"></i> Take Attendance
                            </h1>
                            <p class="text-muted"><i class="bi bi-clock me-1"></i> Current Session: {{ date('F d, Y | h:i A') }}</p>
                        </div>
                    </div>

                    @include('session-messages')

                    <!-- Context Box -->
                    <div class="attendance-header-box d-flex align-items-center flex-wrap">
                        <div class="me-4">
                            <span class="text-muted small d-block mb-1 text-uppercase fw-bold">Active Class</span>
                            <span class="context-badge"><i class="bi bi-mortarboard me-2"></i>{{request()->query('class_name')}}</span>
                        </div>
                        <div>
                            <span class="text-muted small d-block mb-1 text-uppercase fw-bold">
                                {{ ($academic_setting->attendance_type == 'course') ? 'Active Course' : 'Active Section' }}
                            </span>
                            <span class="context-badge">
                                <i class="bi bi-bookmark-star me-2"></i>
                                {{ ($academic_setting->attendance_type == 'course') ? request()->query('course_name') : request()->query('section_name') }}
                            </span>
                        </div>
                    </div>

                    <!-- Attendance Table Card -->
                    <div class="sheet-card shadow-sm border mb-5">
                        <form action="{{route('attendances.store')}}" method="POST">
                            @csrf
                            {{-- Original Logic Hidden Inputs --}}
                            <input type="hidden" name="session_id" value="{{$current_school_session_id}}">
                            <input type="hidden" name="class_id" value="{{request()->query('class_id')}}">
                            @if ($academic_setting->attendance_type == 'course')
                                <input type="hidden" name="course_id" value="{{request()->query('course_id')}}">
                                <input type="hidden" name="section_id" value="0">
                            @else
                                <input type="hidden" name="course_id" value="0">
                                <input type="hidden" name="section_id" value="{{request()->query('section_id')}}">
                            @endif

                            <table class="table sheet-table mb-0">
                                <thead>
                                    <tr>
                                        <th style="width: 200px;">ID Number</th>
                                        <th>Student Full Name</th>
                                        <th class="text-center" style="width: 150px;">Status (Present)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($student_list as $student)
                                    <input type="hidden" name="student_ids[]" value="{{$student->student_id}}">
                                    <tr onclick="this.querySelector('.form-check-input').click()">
                                        <td>
                                            <span class="id-badge">{{$student->id_card_number}}</span>
                                        </td>
                                        <td>
                                            <span class="fw-bold text-dark">{{$student->student->first_name}} {{$student->student->last_name}}</span>
                                        </td>
                                        <td class="text-center">
                                            <input class="form-check-input" type="checkbox" name="status[{{$student->student_id}}]" checked onclick="event.stopPropagation()">
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <!-- Action Bar -->
                            @if(count($student_list) > 0 && $attendance_count < 1)
                            <div class="submit-bar text-center">
                                <button type="submit" class="btn btn-submit-premium">
                                    <i class="bi bi-cloud-check-fill me-2"></i> Submit Final Attendance
                                </button>
                                <p class="text-muted small mt-2">Check all students before submitting. This action is recorded.</p>
                            </div>
                            @elseif($attendance_count > 0)
                            <div class="p-4 text-center bg-light">
                                <span class="text-success fw-bold"><i class="bi bi-check-circle-fill me-2"></i> Attendance for this session has already been recorded.</span>
                            </div>
                            @endif
                        </form>
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