@extends('layouts.app')

@section('content')
<!-- Modern Calendar & Professional UI Styles -->
<link rel="stylesheet" href="{{ asset('css/fullcalendar5.9.0.min.css') }}">
<script src="{{ asset('js/fullcalendar5.9.0.main.min.js') }}"></script>

<style>
    /* High-Level Calendar Overrides */
    #attendanceCalendar {
        background: #ffffff;
        padding: 20px;
        border-radius: 15px;
    }
    .fc-toolbar-title {
        font-size: 1.25rem !important;
        font-weight: 700 !important;
        color: #1e293b;
    }
    .fc-button-primary {
        background-color: #3b82f6 !important;
        border: none !important;
        text-transform: capitalize !important;
        padding: 8px 16px !important;
        border-radius: 8px !important;
    }
    .fc-daygrid-day-number {
        font-weight: 600;
        color: #64748b;
        text-decoration: none !important;
    }

    /* Student Profile Header */
    .student-profile-card {
        background: linear-gradient(135deg, #0f172a 0%, #334155 100%);
        color: white;
        border-radius: 20px;
        padding: 30px;
        margin-bottom: 30px;
        display: flex;
        align-items: center;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }
    .student-avatar-circle {
        width: 60px;
        height: 60px;
        background: rgba(255,255,255,0.1);
        border: 2px solid rgba(255,255,255,0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        margin-right: 20px;
        font-size: 1.5rem;
    }

    /* Premium Table Styling */
    .attendance-card {
        background: #ffffff;
        border-radius: 20px;
        border: none;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }
    .table-premium thead th {
        background: #f8fafc;
        color: #64748b;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 1px;
        padding: 15px 25px;
        border-bottom: 1px solid #e2e8f0;
    }
    .table-premium td {
        padding: 15px 25px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
    }

    /* Modern Badges */
    .badge-present {
        background: #ecfdf5 !important;
        color: #059669 !important;
        border: 1px solid #10b981;
        padding: 6px 12px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 0.7rem;
    }
    .badge-absent {
        background: #fef2f2 !important;
        color: #dc2626 !important;
        border: 1px solid #ef4444;
        padding: 6px 12px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 0.7rem;
    }
</style>

<div class="container-fluid px-4">
    <div class="row">
        @include('layouts.left-menu')

        <div class="col-lg-10">
            <div class="row pt-4">
                <div class="col-12 ps-lg-5">
                    
                    <!-- Page Header -->
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h1 class="fw-800 text-dark mb-0">
                            <i class="bi bi-calendar-check text-primary me-2"></i> Attendance Record
                        </h1>
                    </div>

                    <!-- Student Hero Card -->
                    <div class="student-profile-card">
                        <div class="student-avatar-circle">
                            <i class="bi bi-person-fill"></i>
                        </div>
                        <div>
                            <span class="text-primary-light small text-uppercase fw-bold opacity-75">Full Name</span>
                            <h3 class="mb-0 fw-bold">{{$student->first_name}} {{$student->last_name}}</h3>
                        </div>
                    </div>

                    <div class="row g-4">
                        <!-- Left: Calendar Column -->
                        <div class="col-xl-7">
                            <div class="attendance-card p-2 shadow-sm border">
                                <div id="attendanceCalendar"></div>
                            </div>
                        </div>

                        <!-- Right: Table History Column -->
                        <div class="col-xl-5">
                            <div class="attendance-card shadow-sm border">
                                <div class="p-3 border-bottom bg-light">
                                    <h6 class="mb-0 fw-bold"><i class="bi bi-clock-history me-2"></i>Recent History</h6>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-premium mb-0">
                                        <thead>
                                            <tr>
                                                <th>Status</th>
                                                <th>Date</th>
                                                <th>Context</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($attendances as $attendance)
                                                <tr>
                                                    <td>
                                                        @if ($attendance->status == "on")
                                                            <span class="badge-present">PRESENT</span>
                                                        @else
                                                            <span class="badge-absent">ABSENT</span>
                                                        @endif
                                                    </td>
                                                    <td class="small fw-bold text-muted">
                                                        {{ \Carbon\Carbon::parse($attendance->created_at)->format('M d, Y') }}
                                                    </td>
                                                    <td class="small">
                                                        {{ ($attendance->section == null) ? $attendance->course->course_name : $attendance->section->section_name }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
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

@php
$events = array();
if(count($attendances) > 0){
    foreach ($attendances as $attendance){
        // Using Emerald Green and Rose Red for the High-Level look
        if($attendance->status == "on"){
            $events[] = [
                'title'=> "✓ Present", 
                'start' => $attendance->created_at, 
                'backgroundColor'=>'#10b981', 
                'borderColor' => '#059669'
            ];
        } else {
            $events[] = [
                'title'=> "✗ Absent", 
                'start' => $attendance->created_at, 
                'backgroundColor'=>'#ef4444', 
                'borderColor' => '#b91c1c'
            ];
        }
    }
}
@endphp

<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('attendanceCalendar');
    var attEvents = @json($events);
                            
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,dayGridWeek'
        },
        height: 480,
        events: attEvents,
        dayMaxEvents: true,
        contentHeight: 'auto',
    });
    calendar.render();
});
</script>
@endsection