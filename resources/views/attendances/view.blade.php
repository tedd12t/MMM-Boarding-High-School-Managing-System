@extends('layouts.app')

@section('content')
<style>
    /* High-Level UI for List Views */
    .view-header-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 25px;
        border: none;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        margin-bottom: 25px;
        border-left: 5px solid #3b82f6;
    }

    .breadcrumb-premium {
        background: transparent;
        padding: 0;
        margin-bottom: 10px;
    }

    .breadcrumb-item a {
        color: #64748b;
        text-decoration: none;
        font-weight: 500;
    }

    /* Modern Table Design */
    .table-container {
        background: #ffffff;
        border-radius: 20px;
        border: none;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    .table-premium thead th {
        background-color: #f8fafc;
        padding: 18px 25px;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 700;
        color: #475569;
        border-bottom: 1px solid #e2e8f0;
    }

    .table-premium tbody tr {
        transition: all 0.2s;
    }

    .table-premium tbody tr:hover {
        background-color: #f1f5f9;
    }

    .table-premium td {
        padding: 18px 25px;
        vertical-align: middle;
        color: #1e293b;
        font-weight: 500;
        border-bottom: 1px solid #f1f5f9;
    }

    /* High-Level Status Badges */
    .status-badge {
        padding: 6px 14px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 0.75rem;
        display: inline-flex;
        align-items: center;
    }

    .badge-present {
        background: #ecfdf5;
        color: #059669;
        border: 1px solid #10b981;
    }

    .badge-absent {
        background: #fef2f2;
        color: #dc2626;
        border: 1px solid #ef4444;
    }

    /* Counter Styling */
    .count-circle {
        width: 35px;
        height: 35px;
        background: #f1f5f9;
        color: #334155;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        font-weight: 700;
        font-size: 0.85rem;
        border: 1px solid #e2e8f0;
    }

    .time-bar {
        font-size: 0.85rem;
        color: #64748b;
        background: #f8fafc;
        padding: 8px 15px;
        border-radius: 8px;
        display: inline-block;
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
                    <div class="d-md-flex align-items-center justify-content-between mb-4">
                        <div>
                            <nav aria-label="breadcrumb" class="breadcrumb-premium">
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                                    <li class="breadcrumb-item"><a href="{{url()->previous()}}">Courses</a></li>
                                    <li class="breadcrumb-item active fw-bold text-primary">View Attendance</li>
                                </ol>
                            </nav>
                            <h1 class="fw-800 text-dark mb-0">
                                <i class="bi bi-calendar2-range-fill text-primary me-2"></i> Attendance Records
                            </h1>
                        </div>
                    </div>

                    <!-- Context Info Card -->
                    <div class="view-header-card">
                        <div class="row align-items-center">
                            <div class="col-md-7">
                                @if(request()->query('course_name'))
                                    <span class="text-muted small text-uppercase fw-bold d-block mb-1">Subject / Curriculum</span>
                                    <h3 class="fw-bold mb-0"><i class="bi bi-book me-2 text-primary"></i>{{request()->query('course_name')}}</h3>
                                @elseif(request()->query('section_name'))
                                    <span class="text-muted small text-uppercase fw-bold d-block mb-1">Class Section</span>
                                    <h3 class="fw-bold mb-0"><i class="bi bi-diagram-2 me-2 text-primary"></i>{{request()->query('section_name')}}</h3>
                                @endif
                            </div>
                            <div class="col-md-5 text-md-end mt-3 mt-md-0">
                                <div class="time-bar">
                                    <i class="bi bi-clock-history me-2"></i>Report Date: <strong>{{ date('M d, Y') }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Main Data Table -->
                    <div class="table-container shadow-sm border mb-5">
                        <table class="table table-premium mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">Student Full Name</th>
                                    <th scope="col" class="text-center">Current Status</th>
                                    <th scope="col" class="text-center">Session Total Attended</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($attendances as $attendance)
                                    @php
                                        // Keeping your original exact logic
                                        $total_attended = \App\Models\Attendance::where('student_id', $attendance->student_id)
                                            ->where('session_id', $attendance->session_id)
                                            ->count();
                                    @endphp
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-stub me-3" style="width: 35px; height: 35px; background: #e2e8f0; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #64748b;">
                                                    <i class="bi bi-person-fill"></i>
                                                </div>
                                                <span class="fw-bold">{{$attendance->student->first_name}} {{$attendance->student->last_name}}</span>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            @if ($attendance->status == "on")
                                                <span class="status-badge badge-present">
                                                    <i class="bi bi-check-circle-fill me-2"></i>PRESENT
                                                </span>
                                            @else
                                                <span class="status-badge badge-absent">
                                                    <i class="bi bi-x-circle-fill me-2"></i>ABSENT
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center">
                                                <div class="count-circle shadow-sm">
                                                    {{$total_attended}}
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
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