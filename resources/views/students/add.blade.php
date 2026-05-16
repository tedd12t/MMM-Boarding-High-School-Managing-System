@extends('layouts.app')

@section('content')
<style>
    /* High-Level UI for Enrollment */
    .page-header h1 {
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -1px;
    }

    /* Sectional Cards */
    .enrollment-card {
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        padding: 30px;
        margin-bottom: 30px;
        transition: box-shadow 0.3s ease;
    }

    .enrollment-card:hover {
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }

    .card-indicator {
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 1.2px;
        color: #3b82f6;
        display: flex;
        align-items: center;
        margin-bottom: 20px;
    }

    /* Premium Input Styling */
    .form-label-premium {
        font-weight: 700;
        font-size: 0.8rem;
        color: #475569;
        margin-bottom: 8px;
    }

    .form-control-premium, .form-select-premium {
        background-color: #f1f5f9 !important;
        border: 2px solid transparent !important;
        border-radius: 12px !important;
        padding: 10px 15px !important;
        font-size: 0.95rem !important;
        transition: all 0.3s ease;
    }

    .form-control-premium:focus, .form-select-premium:focus {
        background-color: #ffffff !important;
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1) !important;
    }

    /* Photo Upload Area */
    .photo-upload-zone {
        border: 2px dashed #cbd5e1;
        border-radius: 16px;
        padding: 20px;
        text-align: center;
        background: #f8fafc;
        transition: all 0.2s;
    }

    #previewPhoto img {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        margin-top: 10px;
        border: 3px solid #3b82f6;
    }

    /* Action Buttons */
    .btn-enroll {
        background: linear-gradient(135deg, #0f172a 0%, #334155 100%) !important;
        color: white !important;
        border: none !important;
        border-radius: 12px !important;
        padding: 14px 40px !important;
        font-weight: 700 !important;
        font-size: 1rem;
        box-shadow: 0 10px 15px -3px rgba(15, 23, 42, 0.2);
    }

    .required-mark {
        color: #3b82f6;
        margin-left: 3px;
    }
</style>

<div class="container-fluid px-4">
    <div class="row">
        @include('layouts.left-menu')

        <div class="col-lg-10">
            <div class="row pt-4">
                <div class="col-12 ps-lg-5">
                    
                    <!-- Header Section -->
                    <div class="mb-4">
                        <h1 class="page-header mb-1">
                            <i class="bi bi-person-plus-fill text-primary me-2"></i> Student Admission
                        </h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="{{route('home')}}" class="text-decoration-none">Home</a></li>
                                <li class="breadcrumb-item active fw-bold text-primary">Admission Portal</li>
                            </ol>
                        </nav>
                    </div>

                    @include('session-messages')

                    <form action="{{route('school.student.create')}}" method="POST">
                        <input type="hidden" name="zip" value="0000">
                        @csrf
                        
                        <!-- CARD 1: PERSONAL PROFILE -->
                        <div class="enrollment-card">
                            <div class="card-indicator">
                                <i class="bi bi-person-badge-fill me-2"></i> 01. Personal Profile
                            </div>
                            
                            <div class="row g-4">
                                <div class="col-md-3">
                                    <label class="form-label-premium">First Name<span class="required-mark">*</span></label>
                                    <input type="text" class="form-control form-control-premium" name="first_name" placeholder="kebede" required value="{{old('first_name')}}">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label-premium">Last Name<span class="required-mark">*</span></label>
                                    <input type="text" class="form-control form-control-premium" name="last_name" placeholder="berhe" required value="{{old('last_name')}}">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label-premium">Gender<span class="required-mark">*</span></label>
                                    <select class="form-select form-select-premium" name="gender" required>
                                        <option value="Male" {{old('gender') == 'male' ? 'selected' : ''}}>Male</option>
                                        <option value="Female" {{old('gender') == 'female' ? 'selected' : ''}}>Female</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label-premium">Date of Birth<span class="required-mark">*</span></label>
                                    <input type="date" class="form-control form-control-premium" name="birthday" required value="{{old('birthday')}}">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label-premium">Email Address<span class="required-mark">*</span></label>
                                    <input type="email" class="form-control form-control-premium" name="email" placeholder="student@ut.com" required value="{{old('email')}}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-premium">Portal Password<span class="required-mark">*</span></label>
                                    <input type="password" class="form-control form-control-premium" name="password" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label-premium">Religion</label>
                                    <select class="form-select form-select-premium" name="religion" required>
                                        <option {{old('religion') == 'Islam' ? 'selected' : ''}}>Islam</option>
                                        <option {{old('religion') == 'Protestant' ? 'selected' : ''}}>Protestant</option>
                                        <option {{old('religion') == 'Christian' ? 'selected' : ''}}>Christian</option>
                                        <option value="Others">Other</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label-premium">Nationality</label>
                                    <input type="text" class="form-control form-control-premium" name="nationality" placeholder="Ethiopian" required value="{{old('nationality')}}">
                                </div>
                                <div class="col-md-3">
                                    <div class="photo-upload-zone">
                                        <label class="form-label-premium mb-0">Profile Image</label>
                                        <input class="form-control form-control-sm mt-2" type="file" id="formFile" onchange="previewFile()">
                                        <div id="previewPhoto"></div>
                                        <input type="hidden" id="photoHiddenInput" name="photo" value="">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- CARD 2: GUARDIAN & CONTACT DETAILS -->
                        <div class="enrollment-card">
                            <div class="card-indicator">
                                <i class="bi bi-house-door-fill me-2"></i> 02. Guardian & Residence
                            </div>
                            <div class="row g-4">
                                <div class="col-md-3">
                                    <label class="form-label-premium">Father's Name</label>
                                    <input type="text" class="form-control form-control-premium" name="father_name" required value="{{old('father_name')}}">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label-premium">Father's Contact</label>
                                    <input type="text" class="form-control form-control-premium" name="father_phone" placeholder="+251xxxxxxxx" required value="{{old('father_phone')}}">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label-premium">Mother's Name</label>
                                    <input type="text" class="form-control form-control-premium" name="mother_name" required value="{{old('mother_name')}}">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label-premium">Mother's Contact</label>
                                    <input type="text" class="form-control form-control-premium" name="mother_phone" placeholder="+251xxxxxxxx" required value="{{old('mother_phone')}}">
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label-premium">Primary Residence Address</label>
                                    <input type="text" class="form-control form-control-premium" name="parent_address" placeholder="Guardian's Permanent Address" required value="{{old('parent_address')}}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label-premium">City</label>
                                    <input type="text" class="form-control form-control-premium" name="city" required value="{{old('city')}}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label-premium">Student Mobile</label>
                                    <input type="text" class="form-control form-control-premium" name="phone" placeholder="+251xxxxxxxx" required value="{{old('phone')}}">
                                </div>
                            </div>
                        </div>

                        <!-- CARD 3: ACADEMIC PLACEMENT -->
                        <div class="enrollment-card">
                            <div class="card-indicator">
                                <i class="bi bi-mortarboard-fill me-2"></i> 03. Placement
                            </div>
                            <div class="row g-4">
                                <div class="col-md-12">
                                    <label class="form-label-premium">Institutional ID Number (Formatted)<span class="required-mark">*</span></label>
                                    <input type="text" class="form-control form-control-premium" name="id_card_number" placeholder="2018-MMM-No." required value="{{old('id_card_number')}}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-premium">Academic Grade / Class</label>
                                    <select onchange="getSections(this);" class="form-select form-select-premium" name="class_id" required>
                                        @isset($school_classes)
                                            <option selected disabled>Choose Class...</option>
                                            @foreach ($school_classes as $school_class)
                                                <option value="{{$school_class->id}}">{{$school_class->class_name}}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-premium">Assigned Section</label>
                                    <select class="form-select form-select-premium" id="inputAssignToSection" name="section_id" required>
                                        <option value="">Select class first...</option>
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label-premium">Board Registration Number (Optional)</label>
                                    <input type="text" class="form-control form-control-premium" name="board_reg_no" value="{{old('board_reg_no')}}">
                                </div>
                                <input type="hidden" name="session_id" value="{{$current_school_session_id}}">
                            </div>
                        </div>

                        <!-- Final Action -->
                        <div class="text-center mb-5">
                            <button type="submit" class="btn btn-enroll">
                                <i class="bi bi-check2-all me-2"></i> Finalize Admission
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @include('layouts.footer')
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
            var sectionSelect = document.getElementById('inputAssignToSection');
            sectionSelect.options.length = 0;
            data.sections.unshift({'id': 0,'section_name': 'Choose Section...'})
            data.sections.forEach(function(section, key) {
                sectionSelect[key] = new Option(section.section_name, section.id);
            });
        })
        .catch(function(error) { console.log(error); });
    }
</script>
@include('components.photos.photo-input')
@endsection
