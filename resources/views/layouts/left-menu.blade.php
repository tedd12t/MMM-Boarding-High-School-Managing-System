<style>
    .sidebar-wrapper {
        position: fixed;
        top: 70px; 
        left: 0;
        width: 260px; 
        height: calc(100vh - 70px);
        background: #0f172a !important; 
        border-right: 1px solid rgba(255, 255, 255, 0.05);
        z-index: 1000;
        padding: 0;
        overflow-y: auto;
    } 
    .sidebar-brand { display: none; }
    .nav-item .nav-link {
        padding: 14px 25px !important;
        color: #94a3b8 !important; 
        font-weight: 500;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        transition: 0.2s;
        border: none !important;
    }
    .nav-item .nav-link:hover {
        background: rgba(255, 255, 255, 0.03);
        color: #ffffff !important;
    }

    .nav-item .nav-link.active {
        background: #2563eb !important; 
        color: #ffffff !important;
    }
    .submenu-box {
        background: #020617 !important; 
    }
    .submenu-box .nav-link {
        padding: 10px 25px 10px 55px !important;
        font-size: 0.85rem !important;
        color: #cbd5e1 !important; 
        font-weight: 600;
    }
    .submenu-box .nav-link:hover {
        color: #3b82f6 !important;
    }
    main, .main-content-area {
        padding-left: 260px; 
        padding-top: 70px;  
        width: 100%;
        min-height: 100vh;
        display: block; /
    }
    .container, .container-fluid {
        max-width: 100% !important;
        padding-left: 10px !important; 
        padding-right: 20px !important;
    }
    main .row {
        margin-left: 0 !important;
        margin-right: 0 !important;
    }

    .nav-divider {
        height: 1px;
        background: rgba(255, 255, 255, 0.05);
        margin: 15px 25px;
    }
</style>


<div class="col-xs-1 col-sm-1 col-md-1 col-lg-2 col-xl-2 col-xxl-2 px-0 sidebar-wrapper">
    <div class="d-flex flex-column pt-3">
        <ul class="nav flex-column w-100">
            
            <li class="nav-item">
                <a class="nav-link {{ request()->is('home')? 'active' : '' }}" href="{{url('home')}}">
                    <i class="bi bi-grid-fill me-3"></i> <span>Dashboard</span>
                </a>
            </li>

            @can('view classes')
            <li class="nav-item">
                <a class="nav-link {{ request()->is('classes')? 'active' : '' }}" href="{{url('classes')}}">
                    <i class="bi bi-diagram-3-fill me-3"></i> <span>Classes</span> 
                </a>
            </li>
            @endcan

            @if(Auth::user()->role != "student")
            <li class="nav-item">
                <a type="button" href="#student-submenu" data-bs-toggle="collapse" class="nav-link {{ request()->is('students*')? 'active' : '' }}">
                    <i class="bi bi-people-fill me-3"></i> <span>Students</span>
                    <i class="bi bi-chevron-down ms-auto small"></i>
                </a>
                <ul class="nav collapse {{ request()->is('students*')? 'show' : '' }} submenu-box" id="student-submenu">
                    <li><a class="nav-link" href="{{route('student.list.show')}}">Students List</a></li>
                    @if (Auth::user()->role == "admin")
                        <li><a class="nav-link" href="{{route('student.create.show')}}">Add New</a></li>
                    @endif
                </ul>
            </li>

            <li class="nav-item">
                <a type="button" href="#teacher-submenu" data-bs-toggle="collapse" class="nav-link {{ request()->is('teachers*')? 'active' : '' }}">
                    <i class="bi bi-person-badge-fill me-3"></i> <span>Teachers</span>
                    <i class="bi bi-chevron-down ms-auto small"></i>
                </a>
                <ul class="nav collapse {{ request()->is('teachers*')? 'show' : '' }} submenu-box" id="teacher-submenu">
                    <li><a class="nav-link" href="{{route('teacher.list.show')}}">Teachers List</a></li>
                    @if (Auth::user()->role == "admin")
                        <li><a class="nav-link" href="{{route('teacher.create.show')}}">Add Teacher</a></li>
                    @endif
                </ul>
            </li>
            @endif

            <div class="nav-divider"></div>

            @if (Auth::user()->role == "admin")
            <li class="nav-item">
                <a class="nav-link {{ request()->is('notice*')? 'active' : '' }}" href="{{route('notice.create')}}">
                    <i class="bi bi-megaphone-fill me-3 text-warning"></i> Announcement
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('academics*')? 'active' : '' }}" href="{{url('academics/settings')}}">
                    <i class="bi bi-gear-wide-connected me-3 text-info"></i> Academic Management
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('promotions*')? 'active' : '' }}" href="{{url('promotions/index')}}">
                    <i class="bi bi-arrow-up-circle-fill me-3 text-success"></i> Promotion
                </a>
            </li>
            @endif

            <div class="nav-divider"></div>
            <li class="nav-item">
                <a class="nav-link disabled opacity-50" href="#"><i class="bi bi-credit-card-2-back-fill me-3"></i> Payment</a>
            </li>
        </ul>
    </div>
</div>
