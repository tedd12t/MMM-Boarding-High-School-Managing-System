@extends('layouts.app')

@section('content')
<style>
    /* High-Level UI for Academic Data */
    .page-header h1 {
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -1px;
    }

    /* Premium Table Card */
    .data-card {
        background: #ffffff;
        border-radius: 20px;
        border: none;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        margin-top: 20px;
    }

    .table-premium {
        margin-bottom: 0;
    }

    .table-premium thead th {
        background-color: #f8fafc;
        padding: 18px 25px;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1px;
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
        padding: 18px 25px;
        vertical-align: middle;
        color: #1e293b;
        font-weight: 500;
        border-bottom: 1px solid #f1f5f9;
    }

    /* Grade Letter Badge */
    .grade-badge {
        background: #0f172a;
        color: #ffffff;
        padding: 6px 12px;
        border-radius: 8px;
        font-weight: 800;
        font-size: 0.9rem;
        display: inline-block;
        min-width: 45px;
        text-align: center;
        box-shadow: 0 4px 6px rgba(15, 23, 42, 0.2);
    }

    /* Range Indicators */
    .range-pill {
        background: #eff6ff;
        color: #2563eb;
        padding: 4px 12px;
        border-radius: 50px;
        font-size: 0.8rem;
        font-weight: 700;
        border: 1px solid #dbeafe;
    }

    /* Professional Delete Button */
    .btn-delete-soft {
        background-color: #fff1f2;
        color: #e11d48;
        border: 1px solid #fecdd3;
        border-radius: 10px;
        padding: 8px 15px;
        font-weight: 600;
        font-size: 0.85rem;
        transition: all 0.2s;
    }

    .btn-delete-soft:hover {
        background-color: #e11d48;
        color: #ffffff;
        box-shadow: 0 4px 10px rgba(225, 29, 72, 0.2);
    }

    /* System Name Styling */
    .system-title {
        color: #3b82f6;
        font-weight: 700;
        font-size: 0.95rem;
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
                    <div class="d-md-flex align-items-center justify-content-between mb-4">
                        <div>
                            <h1 class="page-header mb-1">
                                <i class="bi bi-file-earmark-ruled text-primary me-2"></i> Grade Matrix
                            </h1>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item"><a href="{{route('home')}}" class="text-decoration-none text-muted">Home</a></li>
                                    <li class="breadcrumb-item active fw-bold text-primary">Grading Rules</li>
                                </ol>
                            </nav>
                        </div>
                    </div>

                    @include('session-messages')

                    <!-- Main Data Surface -->
                    <div class="data-card border shadow-sm mb-5">
                        <div class="table-responsive">
                            <table class="table table-premium">
                                <thead>
                                    <tr>
                                        <th scope="col">Assigned System</th>
                                        <th scope="col" class="text-center">Point Value</th>
                                        <th scope="col" class="text-center">Grade Letter</th>
                                        <th scope="col">Score Range (%)</th>
                                        <th scope="col" class="text-end">Administrative</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @isset($gradeRules)
                                        @if(count($gradeRules) > 0)
                                            @foreach ($gradeRules as $gradeRule)
                                            <tr>
                                                <td>
                                                    <span class="system-title">
                                                        <i class="bi bi-gear-wide me-2 opacity-50"></i>{{$gradeRule->gradingSystem->system_name}}
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="fw-bold fs-5 text-dark">{{$gradeRule->point}}</span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="grade-badge">{{$gradeRule->grade}}</span>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <span class="range-pill">{{$gradeRule->start_at}}</span>
                                                        <i class="bi bi-arrow-right mx-2 opacity-25"></i>
                                                        <span class="range-pill">{{$gradeRule->end_at}}</span>
                                                    </div>
                                                </td>
                                                <td class="text-end">
                                                    {{-- Original Logic: Form Trigger --}}
                                                    <a href="#" class="btn-delete-soft" 
                                                       onclick="if(confirm('Are you sure you want to remove this rule?')) { event.preventDefault(); document.getElementById('delete-form-{{$gradeRule->id}}').submit(); }">
                                                        <i class="bi bi-trash3-fill me-1"></i> Delete
                                                    </a>
                                                    
                                                    <form id="delete-form-{{$gradeRule->id}}" action="{{ route('exam.grade.system.rule.delete') }}" method="POST" class="d-none">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{$gradeRule->id}}">
                                                    </form>
                                                </td>
                                            </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="5" class="py-5 text-center text-muted">
                                                    <i class="bi bi-inbox display-4 d-block mb-3 opacity-25"></i>
                                                    No grading rules have been defined yet.
                                                </td>
                                            </tr>
                                        @endif
                                    @endisset
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