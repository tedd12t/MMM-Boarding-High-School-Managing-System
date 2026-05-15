@extends('layouts.app')

@section('content')
<style>
    /* High-Level UI for Batch Operations */
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

    /* Warning/Caution Box */
    .caution-panel {
        background: #fff1f2;
        border-left: 5px solid #e11d48;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 30px;
    }

    /* Premium Promotion Table Card */
    .migration-card {
        background: #ffffff;
        border-radius: 24px;
        border: none;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    .premium-table thead th {
        background-color: #0f172a; /* Institutional Slate */
        color: #ffffff;
        padding: 18px 20px;
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        font-weight: 700;
        border: none;
    }

    /* Column Grouping Colors */
    .col-previous { background-color: #f8fafc; }
    .col-target { background-color: #f0f9ff; border-left: 1px solid #e2e8f0; }

    .premium-table td {
        padding: 15px 20px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
        font-size: 0.9rem;
    }

    /* Input & Select Styling */
    .form-control-premium, .form-select-premium {
        background-color: #ffffff !important;
        border: 2px solid #e2e8f0 !important;
        border-radius: 10px !important;
        padding: 8px 12px !important;
        font-size: 0.85rem !important;
        font-weight: 600 !important;
        transition: all 0.2s ease;
    }

    .form-control-premium:focus, .form-select-premium:focus {
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1) !important;
    }

    /* Student Identity */
    .student-name-box {
        display: flex;
        flex-direction: column;
    }
    .student-name-box .main-name { font-weight: 700; color: #0f172a; }
    .student-name-box .sub-id { font-family: monospace; font-size: 0.75rem; color: #64748b; }

    /* Footer Action Bar */
    .migration-footer {
        background: #f8fafc;
        padding: 25px 40px;
        border-top: 1px solid #e2e8f0;
        text-align: right;
    }

    .btn-promote-premium {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%) !important;
        color: white !important;
        border: none !important;
        border-radius: 12px !important;
        padding: 14px 45px !important;
        font-weight: 700 !important;
        letter-spacing: 0.5px;
        box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.3);
        transition: all 0.3s ease;
    }

    .btn-promote-premium:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 20px -5px rgba(59, 130, 246, 0.4);
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
                            <i class="bi bi-arrow-up-circle-fill text-primary me-2"></i> Mass Student Promotion
                        </h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-premium mb-0">
                                <li class="breadcrumb-item"><a href="{{route('home')}}" class="text-decoration-none text-muted">Home</a></li>
                                <li class="breadcrumb-item active fw-bold text-primary">Student Promotion</li>
                            </ol>
                        </nav>
                    </div>

                    @include('session-messages')

                    <!-- Cautionary Panel -->
                    <div class="caution-panel shadow-sm">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-exclamation-triangle-fill fs-3 text-danger me-3"></i>
                            <div>
                                <h6 class="fw-bold mb-1 text-danger">End-of-Session Protocol</h6>
                                <p class="small mb-0 opacity-75">Students must be promoted only once per session. Ensure a New Academic Session is created before executing this migration.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Main Migration Surface -->
                    <div class="migration-card border shadow-sm mb-5">
                        <form action="{{route('promotions.store')}}" method="POST">
                            @csrf
                            <div class="table-responsive">
                                <table class="table premium-table mb-0">
                                    <thead>
                                        <tr>
                                            <th style="width: 250px;">Student Identity</th>
                                            <th class="col-previous">Prev. Class</th>
                                            <th class="col-previous">Prev. Section</th>
                                            <th class="col-target"><i class="bi bi-arrow-right-circle me-2"></i>Target Class</th>
                                            <th class="col-target">Target Section</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @isset($students)
                                            @foreach ($students as $index => $student)
                                            <tr>
                                                <td>
                                                    <div class="student-name-box">
                                                        <span class="main-name">{{$student->student->first_name}} {{$student->student->last_name}}</span>
                                                        <input type="text" class="form-control form-control-sm mt-1 border-0 bg-light small" 
                                                               name="id_card_number[{{$student->student->id}}]" 
                                                               value="{{$student->id_card_number}}" 
                                                               style="font-family: monospace; font-size: 0.7rem;">
                                                    </div>
                                                </td>
                                                <td class="col-previous">
                                                    <span class="badge bg-white text-dark border px-2 py-1">{{$schoolClass->class_name}}</span>
                                                </td>
                                                <td class="col-previous">
                                                    <span class="badge bg-white text-dark border px-2 py-1">{{$section->section_name}}</span>
                                                </td>
                                                <td class="col-target">
                                                    <select onchange="getSections(this, {{$index}});" 
                                                            class="form-select form-select-premium" 
                                                            id="inputAssignToClass{{$index}}" 
                                                            name="class_id[{{$index}}]" required>
                                                        @isset($school_classes)
                                                            <option selected disabled>Select Class...</option>
                                                            @foreach ($school_classes as $school_class)
                                                                <option value="{{$school_class->id}}">{{$school_class->class_name}}</option>
                                                            @endforeach
                                                        @endisset
                                                    </select>
                                                </td>
                                                <td class="col-target">
                                                    <select class="form-select form-select-premium" 
                                                            id="inputAssignToSection{{$index}}" 
                                                            name="section_id[{{$index}}]" required>
                                                        <option value="">Waiting...</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            @endforeach
                                        @endisset
                                    </tbody>
                                </table>
                            </div>

                            <!-- Industrial Action Footer -->
                            <div class="migration-footer">
                                <button type="submit" class="btn btn-promote-premium">
                                    <i class="bi bi-stars me-2"></i> Execute Mass Promotion
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="mt-2">
                @include('layouts.footer')
            </div>
        </div>
    </div>
</div>

<script>
    function getSections(obj, index) {
        var class_id = obj.options[obj.selectedIndex].value;
        var url = "{{route('get.sections.courses.by.classId')}}?class_id=" + class_id 

        fetch(url)
        .then((resp) => resp.json())
        .then(function(data) {
            var sectionSelect = document.getElementById('inputAssignToSection'+index);
            sectionSelect.options.length = 0;
            data.sections.unshift({'id': 0,'section_name': 'Choose Section...'})
            data.sections.forEach(function(section, key) {
                sectionSelect[key] = new Option(section.section_name, section.id);
            });
        })
        .catch(function(error) { console.log(error); });
    }
</script>
@endsection