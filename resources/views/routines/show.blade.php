@extends('layouts.app')

@section('content')
<style>
    /* High-Level UI for Academic Timetables */
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

    /* Premium Routine Card */
    .routine-container-card {
        background: #ffffff;
        border-radius: 24px;
        border: none;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        margin-top: 20px;
    }

    /* The High-Level Timetable Grid */
    .routine-table {
        margin-bottom: 0;
        border-collapse: separate;
        border-spacing: 0 10px; /* Space between rows */
        background: #f8fafc;
        padding: 20px;
    }

    /* Day Column Styling */
    .day-column {
        background: #0f172a !important; /* Deep Slate */
        color: #ffffff !important;
        font-weight: 800;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        vertical-align: middle !important;
        border-radius: 12px 0 0 12px !important;
        width: 140px;
        box-shadow: 4px 0 10px rgba(0,0,0,0.1);
    }

    /* Course Block Styling */
    .course-block {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 12px 15px;
        margin: 5px;
        min-width: 160px;
        transition: all 0.3s ease;
        text-align: left;
        display: inline-block;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }

    .course-block:hover {
        transform: translateY(-3px);
        border-color: #3b82f6;
        box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.1);
    }

    .course-name {
        display: block;
        font-weight: 700;
        color: #1e293b;
        font-size: 0.9rem;
        margin-bottom: 4px;
    }

    .course-time {
        display: flex;
        align-items: center;
        font-family: 'JetBrains Mono', monospace; /* Professional Monospace */
        font-size: 0.75rem;
        color: #64748b;
        font-weight: 600;
    }

    .course-time i {
        font-size: 0.85rem;
        color: #3b82f6;
        margin-right: 6px;
    }

    /* Empty State Styling */
    .empty-routine {
        padding: 100px 20px;
        text-align: center;
        background: white;
        border-radius: 24px;
        color: #94a3b8;
    }

    /* Stripe Effect for rows */
    .routine-row:nth-child(even) .day-column {
        background: #1e293b !important; /* Slightly lighter slate */
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
                    <div class="mb-4">
                        <h1 class="page-header mb-1">
                            <i class="bi bi-calendar-range-fill text-primary me-2"></i> Weekly Academic Schedule
                        </h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-premium mb-0">
                                <li class="breadcrumb-item"><a href="{{route('home')}}" class="text-decoration-none text-muted">Home</a></li>
                                <li class="breadcrumb-item"><a href="{{url()->previous()}}" class="text-decoration-none text-muted">Classes</a></li>
                                <li class="breadcrumb-item active fw-bold text-primary">Routine</li>
                            </ol>
                        </nav>
                    </div>

                    @php
                        // Original Logic Helper
                        function getDayName($weekday) {
                            $days = [
                                1 => "Monday", 2 => "Tuesday", 3 => "Wednesday", 
                                4 => "Thursday", 5 => "Friday", 6 => "Saturday", 7 => "Sunday"
                            ];
                            return $days[$weekday] ?? "Noday";
                        }
                    @endphp

                    @if(count($routines) > 0)
                        <!-- Main Routine Surface -->
                        <div class="routine-container-card border shadow-sm">
                            <div class="table-responsive">
                                <table class="table routine-table">
                                    <tbody>
                                        @foreach($routines as $day => $courses)
                                            <tr class="routine-row">
                                                <th class="day-column text-center">
                                                    {{ getDayName($day) }}
                                                </th>
                                                <td class="bg-white" style="border-radius: 0 12px 12px 0;">
                                                    <div class="d-flex flex-wrap">
                                                        @php
                                                            // Original Logic: Sorting
                                                            $sortedCourses = $courses->sortBy('start');
                                                        @endphp
                                                        @foreach($sortedCourses as $course)
                                                            <div class="course-block">
                                                                <span class="course-name">
                                                                    <i class="bi bi-bookmark-fill text-primary me-1 small"></i>
                                                                    {{$course->course->course_name}}
                                                                </span>
                                                                <div class="course-time">
                                                                    <i class="bi bi-clock"></i>
                                                                    {{$course->start}} - {{$course->end}}
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- Legend / Info Footer -->
                            <div class="p-3 bg-light border-top d-flex justify-content-between align-items-center">
                                <small class="text-muted"><i class="bi bi-info-circle me-1"></i> Routine generated for the 2024-2025 Academic Session.</small>
                                <span class="badge bg-soft-primary text-primary border border-primary px-3 rounded-pill">Official Schedule</span>
                            </div>
                        </div>
                    @else
                        <!-- High-Level Empty State -->
                        <div class="empty-routine border shadow-sm">
                            <i class="bi bi-calendar-x display-1 opacity-25"></i>
                            <h4 class="mt-4 fw-bold text-dark">No Routine Defined</h4>
                            <p class="text-muted">The academic schedule for this section has not been initialized yet.</p>
                            <a href="{{ route('section.routine.create') }}" class="btn btn-primary rounded-pill px-4 mt-2 shadow-sm">
                                <i class="bi bi-plus-lg me-1"></i> Create Routine
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <div class="mt-5">
                @include('layouts.footer')
            </div>
        </div>
    </div>
</div>
@endsection