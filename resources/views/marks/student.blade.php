@extends('layouts.app')

@section('content')
<style>
    /* High-Level UI for Academic Achievement */
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

    /* Course Hero Banner */
    .course-banner {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        color: white;
        border-radius: 20px;
        padding: 25px 30px;
        margin-bottom: 30px;
        box-shadow: 0 10px 20px -5px rgba(0,0,0,0.1);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    /* Premium Data Grid */
    .marks-card {
        background: #ffffff;
        border-radius: 24px;
        border: none;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
        overflow: hidden;
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

    .premium-table td {
        padding: 20px 25px;
        vertical-align: middle;
        color: #1e293b;
        font-weight: 600;
        border-bottom: 1px solid #f1f5f9;
    }

    /* Final Result "Scoreboard" Styling */
    .final-result-card {
        background: #ffffff;
        border: 2px solid #3b82f6; /* Modern Blue Border */
        border-radius: 24px;
        padding: 30px;
        margin-top: 40px;
        box-shadow: 0 20px 25px -5px rgba(59, 130, 246, 0.1);
        position: relative;
    }

    .result-metric {
        text-align: center;
        padding: 10px;
    }

    .result-value {
        font-size: 2rem;
        font-weight: 800;
        color: #0f172a;
        display: block;
        line-height: 1;
    }

    .result-label {
        font-size: 0.7rem;
        text-transform: uppercase;
        font-weight: 700;
        color: #94a3b8;
        letter-spacing: 1px;
        margin-top: 8px;
        display: block;
    }

    /* Grade Badge Logic */
    .grade-badge-xl {
        background: #3b82f6;
        color: white;
        padding: 15px 25px;
        border-radius: 15px;
        font-size: 2rem;
        font-weight: 900;
        box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.3);
    }

    .exam-badge {
        background: #f1f5f9;
        color: #475569;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 0.85rem;
    }
</style>

<div class="container-fluid px-4">
    <div class="row">
        <!-- Professional Sidebar -->
        @include('layouts.left-menu')

        <div class="col-lg-10">
            <div class="row pt-4">
                <div class="col-12 ps-lg-5">
                    
                    <!-- Header & Navigation -->
                    <div class="mb-4">
                        <h1 class="page-header mb-1">
                            <i class="bi bi-award text-primary me-2"></i> Performance Transcript
                        </h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-premium mb-0">
                                <li class="breadcrumb-item"><a href="{{route('home')}}" class="text-decoration-none">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{url()->previous()}}" class="text-decoration-none">My Courses</a></li>
                                <li class="breadcrumb-item active fw-bold text-primary">View Marks</li>
                            </ol>
                        </nav>
                    </div>

                    <!-- Course Identification Banner -->
                    <div class="course-banner shadow-sm">
                        <div>
                            <span class="text-primary fw-bold text-uppercase small" style="letter-spacing: 2px;">Active Enrollment</span>
                            <h2 class="fw-bold mb-0 mt-1"><i class="bi bi-book-half me-2"></i>{{$course_name}}</h2>
                        </div>
                        <div class="d-none d-md-block opacity-25">
                            <i class="bi bi-journal-check" style="font-size: 3rem;"></i>
                        </div>
                    </div>

                    <!-- Individual Exam Scores Card -->
                    <div class="marks-card border shadow-sm mb-4">
                        <div class="p-4 border-bottom bg-light">
                            <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-list-check me-2 text-primary"></i>Assessment Breakdown</h6>
                        </div>
                        <div class="table-responsive">
                            <table class="table premium-table mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col" style="width: 70%;">Examination Title</th>
                                        <th scope="col" class="text-end">Obtained Score</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($marks as $mark)
                                        <tr>
                                            <td>
                                                <span class="exam-badge fw-bold">
                                                    <i class="bi bi-pencil-square me-2"></i>{{$mark->exam->exam_name}}
                                                </span>
                                            </td>
                                            <td class="text-end">
                                                <span class="fs-5 fw-800 text-primary">{{$mark->marks}}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- FINAL RESULT SCOREBOARD -->
                    @if(count($final_marks) > 0)
                        <div class="final-result-card border shadow-lg mb-5">
                            <div class="text-center mb-4">
                                <span class="badge bg-primary px-3 py-2 rounded-pill text-uppercase" style="letter-spacing: 1px;">Official Final Calculation</span>
                            </div>
                            
                            <div class="row align-items-center">
                                @isset($final_marks)
                                    @foreach ($final_marks as $mark)
                                    <div class="col-md-4">
                                        <div class="result-metric">
                                            <span class="result-value">{{$mark->final_marks}}</span>
                                            <span class="result-label">Aggregate Score</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="result-metric border-start border-end">
                                            <span class="result-value text-primary">{{$mark->getAttribute('point')}}</span>
                                            <span class="result-label">GPA Points</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="d-flex flex-column align-items-center">
                                            <div class="grade-badge-xl">
                                                {{$mark->getAttribute('grade')}}
                                            </div>
                                            <span class="result-label mt-3">Letter Grade</span>
                                        </div>
                                    </div>
                                    @endforeach
                                @endisset
                            </div>

                            <div class="mt-4 pt-3 border-top text-center">
                                <small class="text-muted italic">
                                    <i class="bi bi-info-circle me-1"></i> This result is generated based on the weighted average of all semester assessments.
                                </small>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="mt-auto">
                @include('layouts.footer')
            </div>
        </div>
    </div>
</div>
@endsection