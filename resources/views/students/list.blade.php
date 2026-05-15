@extends('layouts.app')

@section('content')
<style>
    /* High-Level UI for Registry Management */
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

    /* Modern Control Station (Filter) */
    .filter-station {
        background: #ffffff;
        border-radius: 20px;
        padding: 25px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        margin-bottom: 30px;
    }

    .filter-label {
        font-weight: 700;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #64748b;
        margin-bottom: 8px;
        display: block;
    }

    .form-select-premium {
        background-color: #f1f5f9 !important;
        border: 2px solid transparent !important;
        border-radius: 12px !important;
        padding: 10px 15px !important;
        font-size: 0.9rem !important;
        transition: all 0.3s ease;
    }

    .form-select-premium:focus {
        background-color: #ffffff !important;
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1) !important;
    }

    /* Premium Data Grid */
    .data-card {
        background: #ffffff;
        border-radius: 24px;
        border: none;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    .premium-table thead th {
        background-color: #0f172a; /* Slate Header */
        color: #ffffff;
        padding: 18px 25px;
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        font-weight: 700;
        border: none;
    }

    .premium-table tbody tr {
        transition: all 0.2s ease;
    }

    .premium-table tbody tr:hover {
        background-color: #f8fafc;
    }

    .premium-table td {
        padding: 15px 25px;
        vertical-align: middle;
        color: #1e293b;
        font-weight: 500;
        border-bottom: 1px solid #f1f5f9;
    }

    /* Student Identity Styling */
    .student-id {
        font-family: 'JetBrains Mono', monospace;
        color: #64748b;
        font-weight: 700;
        font-size: 0.85rem;
    }

    .profile-avatar {
        width: 40px;
        height: 40px;
        object-fit: cover;
        border-radius: 10px;
        border: 2px solid #e2e8f0;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    .avatar-icon {
        width: 40px;
        height: 40px;
        background: #f1f5f9;
        color: #94a3b8;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        font-size: 1.2rem;
    }

    /* Action Pill Styling */
    .btn-action-pill {
        border-radius: 10px !important;
        padding: 6px 14px !important;
        font-size: 0.8rem !important;
        font-weight: 700 !important;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: 1px solid #e2e8f0 !important;
        background: white !important;
        color: #475569 !important;
        transition: all 0.2s;
    }

    .btn-action-pill:hover {
        background: #3b82f6 !important;
        color: white !important;
        border-color: #3b82f6 !important;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.25);
    }

    .section-summary-bar {
        background: #eff6ff;
        color: #1e40af;
        padding: 10px 20px;
        border-radius: 12px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        border: 1px solid #dbeafe;
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
                            <i class="bi bi-people-fill text-primary me-2"></i> Student Information Registry
                        </h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-premium mb-0">
                                <li class="breadcrumb-item"><a href="{{route('home')}}" class="text-decoration-none">Home</a></li>
                                <li class="breadcrumb-item active fw-bold text-primary">Student List</li>
                            </ol>
                        </nav>
                    </div>

                    @include('session-messages')

                    <!-- Control Station (Filters) -->
                    <div class="filter-station shadow-sm border">
                        <form action="{{route('student.list.show')}}" method="GET">
                            <div class="row g-3 align-items-end">
                                <div class="col-md-4">
                                    <label class="filter-label">Academic Grade / Class</label>
                                    <select onchange="getSections(this);" class="form-select form-select-premium" name="class_id" required>
                                        @isset($school_classes)
                                            <option selected disabled>Choose Class...</option>
                                            @foreach ($school_classes as $school_class)
                                                <option value="{{$school_class->id}}" {{($school_class->id == request()->query('class_id'))?'selected':''}}>{{$school_class->class_name}}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="filter-label">Assigned Section</label>
                                    <select class="form-select form-select-premium" id="section-select" name="section_id" required>
                                        <option value="{{request()->query('section_id')}}">{{request()->query('section_name') ?? 'Choose Section...'}}</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-primary w-100 shadow-sm" style="border-radius: 12px; padding: 11px; font-weight: 700;">
                                        <i class="bi bi-funnel-fill me-2"></i> Update Records
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Current Context Display -->
                    @foreach ($studentList as $student)
                        @if ($loop->first)
                            <div class="mb-4">
                                <div class="section-summary-bar shadow-sm">
                                    <i class="bi bi-diagram-3-fill me-2"></i> 
                                    Showing Results for: {{$student->section->section_name}}
                                </div>
                            </div>
                            @break
                        @endif
                    @endforeach

                    <!-- Main Data Table Card -->
                    <div class="data-card border shadow-sm mb-5">
                        <div class="table-responsive">
                            <table class="table premium-table mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col">ID Number</th>
                                        <th scope="col">Profile</th>
                                        <th scope="col">Full Name</th>
                                        <th scope="col">Contact Info</th>
                                        <th scope="col" class="text-end">Management</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($studentList) > 0)
                                        @foreach ($studentList as $student)
                                        <tr>
                                            <td class="student-id">#{{$student->id_card_number}}</td>
                                            <td>
                                                @if (isset($student->student->photo))
                                                    <img src="{{asset('/storage'.$student->student->photo)}}" class="profile-avatar shadow-sm" alt="Student Photo">
                                                @else
                                                    <div class="avatar-icon">
                                                        <i class="bi bi-person-fill"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="fw-bold text-dark">{{$student->student->first_name}} {{$student->student->last_name}}</span>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column">
                                                    <span class="small fw-bold"><i class="bi bi-envelope me-1 opacity-50"></i>{{$student->student->email}}</span>
                                                    <span class="small text-muted mt-1"><i class="bi bi-phone me-1 opacity-50"></i>{{$student->student->phone}}</span>
                                                </div>
                                            </td>
                                            <td class="text-end">
                                                <div class="btn-group gap-2">
                                                    <a href="{{route('student.attendance.show', ['id' => $student->student->id])}}" class="btn btn-action-pill">
                                                        <i class="bi bi-calendar-check"></i>
                                                    </a>
                                                    <a href="{{url('students/view/profile/'.$student->student->id)}}" class="btn btn-action-pill">
                                                        <i class="bi bi-person-badge"></i>
                                                    </a>
                                                    @can('edit users')
                                                    <a href="{{route('student.edit.show', ['id' => $student->student->id])}}" class="btn btn-action-pill">
                                                        <i class="bi bi-pencil-square text-primary"></i>
                                                    </a>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5" class="py-5 text-center text-muted">
                                                <i class="bi bi-people display-1 opacity-10 d-block mb-3"></i>
                                                No students enrolled in this section.
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
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

<script>
    function getSections(obj) {
        var class_id = obj.options[obj.selectedIndex].value;
        var url = "{{route('get.sections.courses.by.classId')}}?class_id=" + class_id 

        fetch(url)
        .then((resp) => resp.json())
        .then(function(data) {
            var sectionSelect = document.getElementById('section-select');
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