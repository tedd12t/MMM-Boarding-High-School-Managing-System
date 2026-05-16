<style>
    .sidebar-wrapper {
        position: fixed; top: 70px; left: 0;
        width: 260px; height: calc(100vh - 70px);
        background: #0f172a !important;
        border-right: 1px solid rgba(255, 255, 255, 0.05);
        z-index: 1000; overflow-y: auto;
    }
    .nav-item .nav-link { padding: 14px 25px !important; color: #94a3b8 !important; font-weight: 500; font-size: 0.9rem; display: flex; align-items: center; border: none !important; }
    .nav-item .nav-link:hover { background: rgba(255, 255, 255, 0.03); color: white !important; }
    .nav-item .nav-link.active { background: #2563eb !important; color: white !important; }
    .nav-item .nav-link i { font-size: 1.1rem; margin-right: 15px; }
    .submenu-box { background: #020617 !important; }
    .submenu-box .nav-link { padding: 10px 25px 10px 60px !important; color: #cbd5e1 !important; font-weight: 600; font-size: 0.85rem !important; }
    .nav-divider { height: 1px; background: rgba(255, 255, 255, 0.05); margin: 15px 25px; }
</style>

<div class="sidebar-wrapper">
    <ul class="nav flex-column pt-3 w-100">
        <li class="nav-item"><a class="nav-link {{ request()->is('home')? 'active' : '' }}" href="{{url('home')}}"><i class="bi bi-grid-fill"></i> Dashboard</a></li>
        
        @can('view classes')
            <li class="nav-item"><a class="nav-link {{ request()->is('classes')? 'active' : '' }}" href="{{url('classes')}}"><i class="bi bi-diagram-3-fill"></i> Classes</a></li>
        @endcan

        @if(Auth::user()->role != "student")
            <li class="nav-item">
                <a type="button" href="#student-submenu" data-bs-toggle="collapse" class="nav-link"><i class="bi bi-people-fill"></i> Students <i class="bi bi-chevron-down ms-auto small"></i></a>
                <ul class="nav collapse submenu-box" id="student-submenu">
                    <li><a class="nav-link" href="{{route('student.list.show')}}">View List</a></li>
                    @if (Auth::user()->role == "admin")<li><a class="nav-link" href="{{route('student.create.show')}}">Add New</a></li>@endif
                </ul>
            </li>
            <li class="nav-item">
                <a type="button" href="#teacher-submenu" data-bs-toggle="collapse" class="nav-link"><i class="bi bi-person-badge-fill"></i> Teachers <i class="bi bi-chevron-down ms-auto small"></i></a>
                <ul class="nav collapse submenu-box" id="teacher-submenu">
                    <li><a class="nav-link" href="{{route('teacher.list.show')}}">Faculty List</a></li>
                </ul>
            </li>
            <li class="nav-item">
                <a type="button" href="#exam-grade-submenu" data-bs-toggle="collapse" class="nav-link"><i class="bi bi-file-earmark-text-fill"></i> Exams & Grades <i class="bi bi-chevron-down ms-auto small"></i></a>
                <ul class="nav collapse submenu-box" id="exam-grade-submenu">
                    <li><a class="nav-link" href="{{route('exam.list.show')}}">View Exams</a></li>
                    @if (Auth::user()->role != "student")<li><a class="nav-link" href="{{route('exam.create.show')}}">Create Exam</a></li>@endif
                    <li><a class="nav-link" href="{{route('exam.grade.system.index')}}">Grade Systems</a></li>
                </ul>
            </li>
        @endif

        <div class="nav-divider"></div>
        @if (Auth::user()->role == "admin")
            <li class="nav-item"><a class="nav-link" href="{{route('notice.create')}}"><i class="bi bi-megaphone-fill text-warning"></i> Announcements</a></li>
            <li class="nav-item"><a class="nav-link" href="{{url('academics/settings')}}"><i class="bi bi-gear-wide-connected text-info"></i> Academic</a></li>
            <li class="nav-item"><a class="nav-link" href="{{url('promotions/index')}}"><i class="bi bi-arrow-up-circle-fill text-success"></i> Promotion</a></li>
        @endif
    </ul>
</div>
