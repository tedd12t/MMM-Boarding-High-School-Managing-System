@extends('layouts.app')

@section('content')
<style>
    /* High-Level UI for Communication Tools */
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

    /* Elevated Composition Card */
    .notice-card {
        background: #ffffff;
        border-radius: 24px;
        border: none;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
        padding: 40px;
    }

    .notice-card-header {
        border-bottom: 1px solid #f1f5f9;
        margin-bottom: 30px;
        padding-bottom: 20px;
    }

    /* High-Level Action Button */
    .btn-publish-premium {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%) !important;
        color: white !important;
        border: none !important;
        border-radius: 12px !important;
        padding: 14px 40px !important;
        font-weight: 700 !important;
        font-size: 1rem;
        letter-spacing: 0.5px;
        box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.3);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        width: 100%;
    }

    .btn-publish-premium:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 20px -5px rgba(59, 130, 246, 0.4);
    }

    /* Side Context Panel */
    .broadcast-panel {
        background: #0f172a;
        color: #f1f5f9;
        border-radius: 20px;
        padding: 35px;
        height: 100%;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.2);
    }

    .broadcast-panel h6 {
        color: #3b82f6;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-weight: 800;
        font-size: 0.75rem;
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
                            <i class="bi bi-megaphone-fill text-primary me-2"></i> Notice Broadcast Studio
                        </h1>
                        <nav aria-label="breadcrumb" class="mt-2">
                            <ol class="breadcrumb breadcrumb-premium mb-0">
                                <li class="breadcrumb-item"><a href="{{route('home')}}" class="text-decoration-none text-muted">Home</a></li>
                                <li class="breadcrumb-item active fw-bold text-primary">Create Notice</li>
                            </ol>
                        </nav>
                    </div>

                    @include('session-messages')

                    <div class="row g-4 mt-2 mb-5">
                        <!-- Primary Composition Column -->
                        <div class="col-xl-8 col-lg-7">
                            <div class="notice-card border">
                                <div class="notice-card-header">
                                    <h5 class="fw-bold text-dark mb-1">New Announcement</h5>
                                    <p class="text-muted small mb-0">Compose your message below. Use the rich-text editor for professional formatting.</p>
                                </div>

                                <form action="{{route('notice.store')}}" method="POST">
                                    @csrf
                                    {{-- Original Logic: Hidden Session ID --}}
                                    <input type="hidden" name="session_id" value="{{$current_school_session_id}}">

                                    <div class="mb-4">
                                        {{-- Original Component: CKEditor --}}
                                        @include('components.ckeditor.editor', ['name' => 'notice'])
                                    </div>

                                    <div class="d-flex align-items-center justify-content-between mt-5 pt-3 border-top">
                                        <a href="{{url()->previous()}}" class="text-muted text-decoration-none small fw-bold">
                                            <i class="bi bi-arrow-left-circle me-1"></i> Discard Draft
                                        </a>
                                        <div style="width: 300px;">
                                            <button type="submit" class="btn btn-publish-premium">
                                                <i class="bi bi-send-fill me-2"></i> Publish to Notice Board
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Side Visibility Panel -->
                        <div class="col-xl-4 col-lg-5 d-none d-lg-block">
                            <div class="broadcast-panel">
                                <h6><i class="bi bi-broadcast me-2"></i> Broadcast Info</h6>
                                <p class="small opacity-75 mt-3">
                                    Once published, this notice will be instantly visible to:
                                </p>
                                <ul class="list-unstyled small mt-4">
                                    <li class="mb-3 d-flex align-items-center">
                                        <div class="me-3 p-2 bg-primary bg-opacity-10 rounded-circle"><i class="bi bi-people text-primary"></i></div>
                                        <span>All Registered Students</span>
                                    </li>
                                    <li class="mb-3 d-flex align-items-center">
                                        <div class="me-3 p-2 bg-primary bg-opacity-10 rounded-circle"><i class="bi bi-person-badge text-primary"></i></div>
                                        <span>All Academic Faculty</span>
                                    </li>
                                    <li class="d-flex align-items-center">
                                        <div class="me-3 p-2 bg-primary bg-opacity-10 rounded-circle"><i class="bi bi-house-door text-primary"></i></div>
                                        <span>Parent / Guardian Portal</span>
                                    </li>
                                </ul>

                                <hr class="opacity-10 my-4">

                                <div class="p-3 rounded-3 bg-white bg-opacity-5 border border-white border-opacity-10">
                                    <p class="small mb-0 opacity-75">
                                        <i class="bi bi-lightbulb-fill text-warning me-1"></i> 
                                        <strong>Pro Tip:</strong> Use tables and bullet points for complex schedules or holiday lists to ensure readability on mobile devices.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-auto">
                @include('layouts.footer')
            </div>
        </div>
    </div>
</div>
@endsection