@extends('layouts.app')

@section('content')
<style>
    /* High-Level UI for Grade Analytics */
    .page-header h1 {
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -1px;
    }

    /* Course Identity Banner */
    .identity-banner {
        background: #ffffff;
        border-radius: 16px;
        padding: 20px 25px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        margin-bottom: 25px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-left: 6px solid #3b82f6;
    }

    /* Premium Data Grid Container */
    .data-sheet-card {
        background: #ffffff;
        border-radius: 24px;
        border: none;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        margin-bottom: 50px;
    }

    /* Professional Spreadsheet Table */
    .grading-grid thead th {
        background-color: #0f172a; /* Industrial Slate */
        color: #ffffff;
        padding: 15px 20px;
        font-size: 0.65rem;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        font-weight: 700;
        border: none;
        white-space: nowrap;
        text-align: center;
    }

    /* Align ID and Name to the left */
    .grading-grid thead th:nth-child(1),
    .grading-grid thead th:nth-child(2) {
        text-align: left;
    }

    .grading-grid tbody tr {
        transition: background 0.2s;
    }

    .grading-grid tbody tr:hover {
        background-color: #f8fafc;
    }

    .grading-grid td, .grading-grid th {
        padding: 15px 20px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
        font-size: 0.9rem;
    }

    /* Data Identity Styling */
    .student-id {
        font-family: 'JetBrains Mono', monospace;
        color: #64748b;
        font-weight: 700;
        font-size: 0.8rem;
    }

    .student-name {
        color: #0f172a;
        font-weight: 700;
    }

    /* Score Cell Styling */
    .score-cell {
        font-family: 'Inter', sans-serif;
        font-weight: 600;
        color: #334155;
        text-align: center;
        background: rgba(241, 245, 249, 0.5);
    }

    /* Highlighting Major Assessments */
    .highlight-cell {
        background: #eff6ff;
        color: #1e40af;
        font-weight: 800;
    }

    /* Scrollbar Styling for 4GB RAM Efficiency */
    .table-responsive::-webkit-scrollbar {
        height: 8px;
    }
    .table-responsive::-webkit-scrollbar-track {
        background: #f1f5f9;
    }
    .table-responsive::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
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
                            <i class="bi bi-grid-3x3-gap-fill text-primary me-2"></i> Grade Ledger
                        </h1>
                        <p class="text-muted">Master record of all assessment categories and student scores.</p>
                    </div>

                    <!-- Identity Banner -->
                    <div class="identity-banner shadow-sm">
                        <div>
                            <span class="text-primary small text-uppercase fw-bold" style="letter-spacing: 2px;">Organizational Unit</span>
                            <h4 class="fw-bold mb-0 mt-1">Class 1 • Section #1</h4>
                        </div>
                        <div class="text-end">
                            <span class="text-muted small text-uppercase fw-bold" style="letter-spacing: 1px;">Curriculum Course</span>
                            <h4 class="fw-bold text-dark mb-0"><i class="bi bi-compass me-2 text-primary"></i>Mathematics</h4>
                        </div>
                    </div>

                    <!-- Main Data Sheet -->
                    <div class="data-sheet-card border shadow-sm">
                        <div class="table-responsive">
                            <table class="table grading-grid mb-0">
                                <thead>
                                    <tr>
                                        <th># ID</th>
                                        <th>Full Name</th>
                                        <th>Q1</th>
                                        <th>Q2</th>
                                        <th>Q1 (R)</th>
                                        <th>Q2 (R)</th>
                                        <th class="bg-primary">Midterm</th>
                                        <th>Q3</th>
                                        <th>Q4</th>
                                        <th>Asgn 1</th>
                                        <th>Asgn 2</th>
                                        <th>Prac</th>
                                        <th class="bg-success">Final</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- Row 1 --}}
                                    <tr>
                                        <td class="student-id">1012</td>
                                        <td class="student-name text-capitalize">hamsterclover</td>
                                        <td class="score-cell">4,230</td>
                                        <td class="score-cell">9</td>
                                        <td class="score-cell">3</td>
                                        <td class="score-cell">9</td>
                                        <td class="score-cell highlight-cell">3</td>
                                        <td class="score-cell small text-muted">Jan 24, 20:52</td>
                                        <td class="score-cell small text-muted">May 21, 22:10</td>
                                        <td class="score-cell">88</td>
                                        <td class="score-cell">4,230</td>
                                        <td class="score-cell">4,230</td>
                                        <td class="score-cell highlight-cell" style="background: #ecfdf5; color: #059669;">9</td>
                                    </tr>
                                    {{-- Row 2 --}}
                                    <tr>
                                        <td class="student-id">1013</td>
                                        <td class="student-name text-capitalize">cellofruit</td>
                                        <td class="score-cell">4,126</td>
                                        <td class="score-cell">9</td>
                                        <td class="score-cell">3</td>
                                        <td class="score-cell">7</td>
                                        <td class="score-cell highlight-cell">3</td>
                                        <td class="score-cell small text-muted">Jan 21, 11:05</td>
                                        <td class="score-cell small text-muted">Feb 05, 17:41</td>
                                        <td class="score-cell">92</td>
                                        <td class="score-cell">4,230</td>
                                        <td class="score-cell">4,230</td>
                                        <td class="score-cell highlight-cell" style="background: #ecfdf5; color: #059669;">9</td>
                                    </tr>
                                    {{-- Row 3 --}}
                                    <tr>
                                        <td class="student-id">1014</td>
                                        <td class="student-name text-capitalize">enchantingsun</td>
                                        <td class="score-cell">4,085</td>
                                        <td class="score-cell">5</td>
                                        <td class="score-cell">4</td>
                                        <td class="score-cell">9</td>
                                        <td class="score-cell highlight-cell">3</td>
                                        <td class="score-cell small text-muted">Jan 22, 18:44</td>
                                        <td class="score-cell small text-muted">Mar 28, 12:16</td>
                                        <td class="score-cell">75</td>
                                        <td class="score-cell">4,230</td>
                                        <td class="score-cell">4,230</td>
                                        <td class="score-cell highlight-cell" style="background: #ecfdf5; color: #059669;">9</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="p-3 bg-light border-top text-end">
                            <small class="text-muted"><i class="bi bi-info-circle me-1"></i> Tip: Horizontal scroll to see all assessment categories.</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                @include('layouts.footer')
            </div>
        </div>
    </div>
</div>
@endsection