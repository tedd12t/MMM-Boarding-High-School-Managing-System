<style>
    .sidebar-wrapper {
        position: fixed;
        top: 70px; /* Starts exactly below Top Nav */
        left: 0;
        width: 260px;
        height: calc(100vh - 70px);
        background: #0f172a !important; /* Solid Navy */
        border-right: 1px solid rgba(255, 255, 255, 0.05);
        z-index: 1000;
        overflow-y: auto;
    }

    .nav-item .nav-link {
        padding: 14px 25px !important;
        color: #94a3b8 !important;
        font-weight: 500;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        border: none !important;
        transition: 0.2s;
    }

    .nav-item .nav-link i {
        font-size: 1.15rem;
        margin-right: 15px;
        color: #64748b;
    }

    .nav-item .nav-link:hover {
        background: rgba(255, 255, 255, 0.03);
        color: #ffffff !important;
    }

    .nav-item .nav-link.active {
        background: #2563eb !important; /* Solid Blue */
        color: #ffffff !important;
    }

    .nav-item .nav-link.active i {
        color: #ffffff !important;
    }

    /* Submenu Styling (High Visibility) */
    .submenu-box {
        background: #020617 !important; /* Darker background for depth */
        list-style: none;
        padding: 5px 0;
    }

    .submenu-box .nav-link {
        padding: 10px 25px 10px 60px !important; /* Deep indent */
        color: #cbd5e1 !important; /* Bright Silver */
        font-weight: 600;
        font-size: 0.85rem !important;
    }

    .submenu-box .nav-link:hover {
        color: #3b82f6 !important;
        background: transparent !important;
    }

    .nav-divider {
        height: 1px;
        background: rgba(255, 255, 255, 0.05);
        margin: 15px 25px;
    }
</style>

<div class="sidebar-wrapper">
    <ul class="nav flex-column pt-3 w-100">
        
        <!-- 1. Dashboard -->
        <li class="nav-item">
            <a class="nav-link {{ request()->is('home')? 'active' : '' }}" href="{{url('home')}}">
                <i class="bi bi-grid-fill"></i> <span>Dashboard</span>
            </a>
        </li>

        <!-- 2. Classes -->
        @can('view classes')
        <li class="nav-item">
            <a class="nav-link {{ request()->is('classes')? 'active' : '' }}" href="{{url('classes')}}">
                <i class="bi bi-diagram-3-fill"></i> <span>Classes</span>
            </a>
        </li>
        @endcan

        @if(Auth::user()->role != "student")
        <!-- 3. Students Submenu -->
        <li class="nav-item">
            <a type="button" href="#student-submenu" data-bs-toggle="collapse" class="nav-link {{ request()->is('students*')? 'active' : '' }}">
                <i class="bi bi-people-fill"></i> <span>Students</span>
                <i class="bi bi-chevron-down ms-auto small"></i>
            </a>
            <ul class="nav collapse {{ request()->is('students*')? 'show' : '' }} submenu-box" id="student-submenu">
                <li><a class="nav-link" href="{{route('student.list.show')}}">View List</a></li>
                @if (!session()->has('browse_session_id') && Auth::user()->role == "admin")
                    <li><a class="nav-link" href="{{route('student.create.show')}}">Add Students</a></li>
                @endif
            </ul>
        </li>

        <!-- 4. Teachers Submenu (FIXED: Add Faculty included) -->
        <li class="nav-item">
            <a type="button" href="#teacher-submenu" data-bs-toggle="collapse" class="nav-link {{ request()->is('teachers*')? 'active' : '' }}">
                <i class="bi bi-person-badge-fill"></i> <span>Teachers</span>
                <i class="bi bi-chevron-down ms-auto small"></i>
            </a>
            <ul class="nav collapse {{ request()->is('teachers*')? 'show' : '' }} submenu-box" id="teacher-submenu">
                <li><a class="nav-link" href="{{route('teacher.list.show')}}">Teachers List</a></li>
                @if (!session()->has('browse_session_id') && Auth::user()->role == "admin")
                    <li><a class="nav-link" href="{{route('teacher.create.show')}}">Add Teachers</a></li>
                @endif
            </ul>
        </li>

        <!-- 5. Exams & Grades Submenu -->
        <li class="nav-item">
            <a type="button" href="#exam-grade-submenu" data-bs-toggle="collapse" class="nav-link {{ request()->is('exams*')? 'active' : '' }}">
                <i class="bi bi-file-earmark-text-fill"></i> <span>Exams & Grades</span>
                <i class="bi bi-chevron-down ms-auto small"></i>
            </a>
            <ul class="nav collapse {{ request()->is('exams*')? 'show' : '' }} submenu-box" id="exam-grade-submenu">
                <li><a class="nav-link" href="{{route('exam.list.show')}}">View Exams</a></li>
                @if (Auth::user()->role != "student")
                    <li><a class="nav-link" href="{{route('exam.create.show')}}">Create Exam</a></li>
                @endif
                <li><a class="nav-link" href="{{route('exam.grade.system.index')}}">Grade Systems</a></li>
            </ul>
        </li>
        @endif

        <div class="nav-divider"></div>

        <!-- 6. Management Tools -->
        <li class="nav-item">
            <a class="nav-link {{ request()->is('notice*')? 'active' : '' }}" href="{{route('notice.create')}}">
                <i class="bi bi-megaphone-fill text-warning"></i> <span>Announcements</span>
            </a>
        </li>

        @if (Auth::user()->role == "admin")
        <li class="nav-item">
            <a class="nav-link {{ request()->is('academics*')? 'active' : '' }}" href="{{url('academics/settings')}}">
                <i class="bi bi-gear-wide-connected text-info"></i> <span>Academic Setting</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('promotions*')? 'active' : '' }}" href="{{url('promotions/index')}}">
                <i class="bi bi-arrow-up-circle-fill text-success"></i> <span>Promotion</span>
            </a>
        </li>
        @endif

        <div class="nav-divider"></div>
        
        <!-- 7. Payments -->
        <li class="nav-item">
            <a class="nav-link disabled opacity-50" href="#">
                <i class="bi bi-credit-card-2-back-fill"></i> <span>Payment</span>
            </a>
        </li>
    </ul>
</div>
