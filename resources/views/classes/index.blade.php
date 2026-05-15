@extends('layouts.app')

@section('content')
<style>
    .page-header h1 {
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -1px;
    }
    .class-management-card {
        background: #ffffff;
        border-radius: 20px;
        border: none;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
        margin-bottom: 30px;
        overflow: hidden;
    }
    .card-header-custom {
        background: #f8fafc !important;
        border-bottom: 1px solid #e2e8f0 !important;
        padding: 0 20px !important;
    }

    .nav-pills-premium .nav-link {
        color: #64748b;
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 15px 20px;
        border-radius: 0;
        border-bottom: 3px solid transparent;
        transition: all 0.3s;
    }

    .nav-pills-premium .nav-link.active {
        background: transparent !important;
        color: #3b82f6 !important;
        border-bottom-color: #3b82f6 !important;
    }
    .accordion-premium .accordion-item {
        border: 1px solid #f1f5f9 !important;
        border-radius: 12px !important;
        margin-bottom: 10px;
        overflow: hidden;
    }

    .accordion-premium .accordion-button {
        background: #ffffff !important;
        font-weight: 700;
        color: #334155 !important;
        padding: 18px 25px;
        box-shadow: none !important;
    }

    .accordion-premium .accordion-button:not(.collapsed) {
        background: #eff6ff !important;
        color: #2563eb !important;
    }
    .room-tag {
        background: #f1f5f9;
        color: #475569;
        padding: 4px 12px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 0.8rem;
        border: 1px solid #e2e8f0;
    }
    .action-list-group .list-group-item {
        border: none;
        padding: 12px 0;
        font-weight: 500;
        color: #64748b;
        transition: all 0.2s;
    }

    .action-list-group .list-group-item:hover {
        color: #3b82f6;
        padding-left: 10px;
        background: transparent;
    }
    .table-clean thead th {
        background: #f8fafc;
        text-transform: uppercase;
        font-size: 0.7rem;
        letter-spacing: 1px;
        color: #94a3b8;
        border: none;
    }

    .table-clean td {
        padding: 15px 10px;
        vertical-align: middle;
        font-weight: 500;
        color: #1e293b;
    }

    .card-footer-custom {
        background: #f8fafc !important;
        border-top: 1px solid #e2e8f0 !important;
        padding: 15px 25px !important;
    }
</style>

<div class="container-fluid px-4">
    <div class="row">
        @include('layouts.left-menu')

        <div class="col-lg-10">
            <div class="row pt-4">
                <div class="col-12 ps-lg-5">

                    <div class="d-md-flex align-items-center justify-content-between mb-4">
                        <div>
                            <h1 class="page-header mb-1">
                                <i class="bi bi-diagram-3-fill text-primary me-2"></i> Academic Managment
                            </h1>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item"><a href="{{route('home')}}" class="text-decoration-none text-muted">Home</a></li>
                                    <li class="breadcrumb-item active fw-bold text-primary">Classes & Curriculum</li>
                                </ol>
                            </nav>
                        </div>
                    </div>

                    <div class="row">
                        @isset($school_classes)
                            @foreach ($school_classes as $school_class)
                            @php $total_sections = 0; @endphp
                                <div class="col-12">
                                    <div class="class-management-card border shadow-sm">
                                        <!-- Premium Tab Header -->
                                        <div class="card-header-custom">
                                            <ul class="nav nav-pills nav-pills-premium card-header-tabs" role="tablist">
                                                <li class="nav-item">
                                                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#class{{$school_class->id}}" type="button">
                                                        <i class="bi bi-layers-half me-2"></i>{{$school_class->class_name}}
                                                    </button>
                                                </li>
                                                <li class="nav-item">
                                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#class{{$school_class->id}}-syllabus" type="button">
                                                        <i class="bi bi-journal-bookmark me-2"></i>Syllabus/Topics
                                                    </button>
                                                </li>
                                                <li class="nav-item">
                                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#class{{$school_class->id}}-courses" type="button">
                                                        <i class="bi bi-book me-2"></i>Courses
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="card-body p-4">
                                            <div class="tab-content">
                                                
                                                <!-- Sections Tab -->
                                                <div class="tab-pane fade show active" id="class{{$school_class->id}}" role="tabpanel">
                                                    <div class="accordion accordion-premium" id="accordionClass{{$school_class->id}}">
                                                        @isset($school_sections)
                                                            @foreach ($school_sections as $school_section)
                                                                @if ($school_section->class_id == $school_class->id)
                                                                    @php $total_sections++; @endphp
                                                                    <div class="accordion-item">
                                                                        <h2 class="accordion-header">
                                                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accordionClass{{$school_class->id}}Section{{$school_section->id}}">
                                                                                <i class="bi bi-door-open me-3 opacity-50"></i>{{$school_section->section_name}}
                                                                            </button>
                                                                        </h2>
                                                                        <div id="accordionClass{{$school_class->id}}Section{{$school_section->id}}" class="accordion-collapse collapse" data-bs-parent="#accordionClass{{$school_class->id}}">
                                                                            <div class="accordion-body bg-white border-top">
                                                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                                                    <div>
                                                                                        <span class="text-muted small text-uppercase fw-bold d-block">Location</span>
                                                                                        <span class="room-tag">Room: {{$school_section->room_no}}</span>
                                                                                    </div>
                                                                                    @can('edit sections')
                                                                                    <a href="{{route('section.edit', ['id' => $school_section->id])}}" class="btn btn-sm btn-light border">
                                                                                        <i class="bi bi-pencil-square me-1"></i> Edit Section
                                                                                    </a>
                                                                                    @endcan
                                                                                </div>
                                                                                <div class="action-list-group list-group list-group-flush">
                                                                                    <a href="{{route('student.list.show', ['class_id' => $school_class->id, 'section_id' => $school_section->id, 'section_name' => $school_section->section_name])}}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                                                                        <span><i class="bi bi-people me-2"></i> Enrollments & Student List</span>
                                                                                        <i class="bi bi-chevron-right small"></i>
                                                                                    </a>
                                                                                    <a href="{{route('section.routine.show', ['class_id' => $school_class->id, 'section_id' => $school_section->id])}}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                                                                        <span><i class="bi bi-calendar-week me-2"></i> Weekly Academic Routine</span>
                                                                                        <i class="bi bi-chevron-right small"></i>
                                                                                    </a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        @endisset
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="class{{$school_class->id}}-syllabus" role="tabpanel">
                                                    <div class="table-responsive">
                                                        <table class="table table-clean">
                                                            <thead>
                                                                <tr>
                                                                    <th>Syllabus/Topic Document Title</th>
                                                                    <th class="text-end">Resources</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            @isset($school_class->syllabi)
                                                                @foreach ($school_class->syllabi as $syllabus)
                                                                    <tr>
                                                                        <td><i class="bi bi-file-earmark-pdf text-danger me-2"></i>{{$syllabus->syllabus_name}}</td>
                                                                        <td class="text-end">
                                                                            <a href="{{asset('storage/'.$syllabus->syllabus_file_path)}}" class="btn btn-sm btn-primary rounded-pill px-3">
                                                                                <i class="bi bi-download me-1"></i> Download
                                                                            </a>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            @endisset
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                                <!-- Courses Tab -->
                                                <div class="tab-pane fade" id="class{{$school_class->id}}-courses" role="tabpanel">
                                                    <div class="table-responsive">
                                                        <table class="table table-clean">
                                                            <thead>
                                                                <tr>
                                                                    <th>Course Name</th>
                                                                    <th>Category</th>
                                                                    <th class="text-end">Management</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            @isset($school_class->courses)
                                                                @foreach ($school_class->courses as $course)
                                                                    <tr>
                                                                        <td class="fw-bold">{{$course->course_name}}</td>
                                                                        <td><span class="badge bg-light text-dark border">{{$course->course_type}}</span></td>
                                                                        <td class="text-end">
                                                                            @can('edit courses')
                                                                            <a href="{{route('course.edit', ['id' => $course->id])}}" class="btn btn-sm btn-outline-secondary rounded-pill">
                                                                                <i class="bi bi-pencil"></i>
                                                                            </a>
                                                                            @endcan
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            @endisset
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer-custom d-flex justify-content-between align-items-center">
                                            <span class="text-muted fw-bold small">
                                                <i class="bi bi-collection me-2"></i>Total Active Sections: {{$total_sections}}
                                            </span>
                                            @can('edit classes')
                                            <a href="{{route('class.edit', ['id' => $school_class->id])}}" class="btn btn-sm btn-primary px-4 rounded-pill shadow-sm">
                                                <i class="bi bi-gear-fill me-1"></i> Modify Class
                                            </a>
                                            @endcan
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endisset
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
