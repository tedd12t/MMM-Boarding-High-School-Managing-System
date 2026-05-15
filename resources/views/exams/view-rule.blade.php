@extends('layouts.app')

@section('content')
<style>
    /* High-Level UI for Academic Regulations */
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

    /* Premium Data Card */
    .rule-container-card {
        background: #ffffff;
        border-radius: 20px;
        border: none;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        margin-top: 20px;
    }

    .table-premium thead th {
        background-color: #f8fafc;
        padding: 18px 25px;
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        font-weight: 700;
        color: #64748b;
        border-bottom: 1px solid #e2e8f0;
    }

    .table-premium tbody tr {
        transition: all 0.2s ease;
    }

    .table-premium tbody tr:hover {
        background-color: #f1f5f9;
    }

    .table-premium td {
        padding: 20px 25px;
        vertical-align: middle;
        color: #1e293b;
        border-bottom: 1px solid #f1f5f9;
    }

    /* Metric Styling */
    .metric-value {
        font-weight: 800;
        font-size: 1.1rem;
        color: #0f172a;
    }

    .metric-label {
        font-size: 0.65rem;
        text-transform: uppercase;
        font-weight: 700;
        color: #94a3b8;
        display: block;
        margin-top: -4px;
    }

    /* Pass Mark Logic */
    .pass-indicator {
        background: #ecfdf5;
        color: #059669;
        padding: 4px 10px;
        border-radius: 6px;
        font-weight: 700;
        border: 1px solid #10b981;
    }

    /* Distribution Note Styling */
    .note-bubble {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        padding: 10px 15px;
        border-radius: 10px;
        font-size: 0.85rem;
        color: #475569;
        max-width: 350px;
        line-height: 1.5;
    }

    /* Professional Action Button */
    .btn-edit-pill {
        background-color: #ffffff !important;
        border: 1px solid #e2e8f0 !important;
        color: #475569 !important;
        border-radius: 10px !important;
        padding: 8px 16px !important;
        font-weight: 700 !important;
        font-size: 0.8rem !important;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.2s;
    }

    .btn-edit-pill:hover {
        background-color: #3b82f6 !important;
        color: #ffffff !important;
        border-color: #3b82f6 !important;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
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
                            <i class="bi bi-file-earmark-check text-primary me-2"></i> Assessment Regulations
                        </h1>
                        <nav aria-label="breadcrumb" class="mt-2">
                            <ol class="breadcrumb breadcrumb-premium mb-0">
                                <li class="breadcrumb-item"><a href="{{route('home')}}" class="text-decoration-none text-muted">Home</a></li>
                                <li class="breadcrumb-item"><a href="{{url()->previous()}}" class="text-decoration-none text-muted">Exams</a></li>
                                <li class="breadcrumb-item active fw-bold text-primary">Marking Rules</li>
                            </ol>
                        </nav>
                    </div>

                    <!-- Main List Card -->
                    <div class="rule-container-card border shadow-sm mb-5">
                        <div class="table-responsive">
                            <table class="table table-premium mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col" style="width: 150px;">Total Capacity</th>
                                        <th scope="col" style="width: 150px;">Pass Criteria</th>
                                        <th scope="col">Distribution Rubric</th>
                                        <th scope="col" class="text-end">Management</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($exam_rules) > 0)
                                        @foreach ($exam_rules as $exam_rule)
                                        <tr>
                                            <td>
                                                <span class="metric-value">{{$exam_rule->total_marks}}</span>
                                                <span class="metric-label">Max Score</span>
                                            </td>
                                            <td>
                                                <span class="pass-indicator">
                                                    {{$exam_rule->pass_marks}}
                                                </span>
                                                <span class="metric-label mt-1">Min. Required</span>
                                            </td>
                                            <td>
                                                <div class="note-bubble shadow-sm">
                                                    <i class="bi bi-info-circle-fill text-primary me-2"></i>
                                                    {{$exam_rule->marks_distribution_note}}
                                                </div>
                                            </td>
                                            <td class="text-end">
                                                {{-- Original Logic: Route & Parameters Preserved --}}
                                                <a href="{{route('exam.rule.edit', ['exam_rule_id' => $exam_rule->id])}}" 
                                                   class="btn btn-edit-pill">
                                                    <i class="bi bi-pencil-square me-1"></i> Edit Rule
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="4" class="py-5 text-center text-muted">
                                                <i class="bi bi-clipboard-x display-4 d-block mb-3 opacity-25"></i>
                                                No marking rules found for this examination.
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
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