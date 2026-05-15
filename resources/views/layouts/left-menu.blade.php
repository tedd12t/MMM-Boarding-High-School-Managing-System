<style>
    /* --- SIDEBAR Pinned below Navbar --- */
    .sidebar-wrapper {
        position: fixed;
        top: 70px; /* Starts exactly where Navbar ends */
        left: 0;
        width: 260px; /* Comfortable width */
        height: calc(100vh - 70px);
        background: #0f172a !important; /* Solid Pro Navy */
        border-right: 1px solid rgba(255, 255, 255, 0.05);
        z-index: 1000;
        padding: 0;
        overflow-y: auto;
    }

    /* Remove brand from sidebar since it's already in the top Navbar */
    .sidebar-brand { display: none; }

    /* Nav Links Styling */
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
        background: #2563eb !important; /* Solid Pro Blue */
        color: #ffffff !important;
    }

    /* Submenu Box - High Visibility */
    .submenu-box {
        background: #020617 !important; /* Distinct dark background */
    }

    .submenu-box .nav-link {
        padding: 10px 25px 10px 55px !important;
        font-size: 0.85rem !important;
        color: #cbd5e1 !important; /* Bright gray */
        font-weight: 600;
    }

    .submenu-box .nav-link:hover {
        color: #3b82f6 !important;
    }

    /* --- FULL SCREEN CONTENT ADJUSTMENT --- */
    main, .main-content-area {
        padding-left: 260px; /* Matches Sidebar width */
        padding-top: 70px;  /* Matches Navbar height */
        width: 100%;
        min-height: 100vh;
    }

    /* Expand containers to be full width */
    .container, .container-fluid {
        max-width: 100% !important;
        padding-left: 30px !important;
        padding-right: 30px !important;
    }

    .nav-divider {
        height: 1px;
        background: rgba(255, 255, 255, 0.05);
        margin: 15px 25px;
    }
</style>

<!-- Updated Sidebar Structure -->
<div class="sidebar-wrapper">
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
            <!-- Students -->
            <li class="nav-item">
                <a type="button" href="#student-submenu" data-bs-toggle="collapse" class="nav-link {{ request()->is('students*')? 'active' : '' }}">
                    <i class="bi bi-people-fill me-3"></i> <span>Students</span>
                    <i class="bi bi-chevron-down ms-auto small"></i>
                </a>
                <ul class="nav collapse {{ request()->is('students*')? 'show' : '' }} submenu-box" id="student-submenu">
                    <li><a class="nav-link" href="{{route('student.list.show')}}">View List</a></li>
                    @if (Auth::user()->role == "admin")
                        <li><a class="nav-link" href="{{route('student.create.show')}}">Add New</a></li>
                    @endif
                </ul>
            </li>

            <!-- Teachers -->
            <li class="nav-item">
                <a type="button" href="#teacher-submenu" data-bs-toggle="collapse" class="nav-link {{ request()->is('teachers*')? 'active' : '' }}">
                    <i class="bi bi-person-badge-fill me-3"></i> <span>Teachers</span>
                    <i class="bi bi-chevron-down ms-auto small"></i>
                </a>
                <ul class="nav collapse {{ request()->is('teachers*')? 'show' : '' }} submenu-box" id="teacher-submenu">
                    <li><a class="nav-link" href="{{route('teacher.list.show')}}">Faculty List</a></li>
                    @if (Auth::user()->role == "admin")
                        <li><a class="nav-link" href="{{route('teacher.create.show')}}">Add Faculty</a></li>
                    @endif
                </ul>
            </li>
            @endif

            <div class="nav-divider"></div>

            @if (Auth::user()->role == "admin")
            <li class="nav-item">
                <a class="nav-link {{ request()->is('notice*')? 'active' : '' }}" href="{{route('notice.create')}}">
                    <i class="bi bi-megaphone-fill me-3 text-warning"></i> Notices
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('academics*')? 'active' : '' }}" href="{{url('academics/settings')}}">
                    <i class="bi bi-gear-wide-connected me-3 text-info"></i> Academic
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