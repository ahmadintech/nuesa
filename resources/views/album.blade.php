@extends('layouts.frontend')

@section('title', 'Student Album & Profiles - NUESA UNIMAID Chapter')

@push('styles')
    <style>
        .gallery-img-box {
            height: 220px;
        }
        @media (max-width: 575.98px) {
            #galleryContainer {
                display: flex !important;
                flex-wrap: wrap !important;
                margin-left: -6px !important;
                margin-right: -6px !important;
            }
            #galleryContainer > .gallery-item-col {
                width: 50% !important;
                max-width: 50% !important;
                flex: 0 0 50% !important;
                padding-left: 6px !important;
                padding-right: 6px !important;
            }
            .gallery-img-box {
                height: 185px !important;
            }
        }
    </style>
@endpush

@section('content')
    <!-- Page Header Start -->
    <div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <h1 class="display-3 text-white animated slideInRight">Student Album & Archives</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb animated slideInRight mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item text-white"><a href="{{ route('gallery') }}" class="text-white">Gallery</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page">Student Album</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- 1. DYNAMIC CATEGORY FILTERS SECTION -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center mx-auto mb-4 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 650px;">
                <p class="fw-medium text-uppercase text-primary mb-2">Student Photo Archive</p>
                <h1 class="display-5 mb-3">Departmental & Session Album</h1>
                <p class="text-muted">Filter photos by Department or Academic Set. Click any photo to view full student details.</p>
            </div>

            <!-- Dynamic Category Filter Buttons -->
            <div class="d-flex flex-wrap gap-2 justify-content-center mb-5 wow fadeInUp" data-wow-delay="0.2s">
                <button class="btn btn-primary gallery-filter-btn active rounded-pill px-3 py-2 shadow-sm" data-filter="all"><i class="fa fa-th-large me-1"></i>All Photos</button>
                <button class="btn btn-outline-primary gallery-filter-btn rounded-pill px-3 py-2 shadow-sm" data-filter="civil">Civil Eng.</button>
                <button class="btn btn-outline-primary gallery-filter-btn rounded-pill px-3 py-2 shadow-sm" data-filter="electrical">Electrical Eng.</button>
                <button class="btn btn-outline-primary gallery-filter-btn rounded-pill px-3 py-2 shadow-sm" data-filter="mechanical">Mechanical Eng.</button>
                <button class="btn btn-outline-primary gallery-filter-btn rounded-pill px-3 py-2 shadow-sm" data-filter="computer">Computer Eng.</button>
                <button class="btn btn-outline-secondary gallery-filter-btn rounded-pill px-3 py-2 shadow-sm" data-filter="class2025">Class of 2025 (500L)</button>
                <button class="btn btn-outline-secondary gallery-filter-btn rounded-pill px-3 py-2 shadow-sm" data-filter="class2024">Class of 2024 (Alumni)</button>
                <button class="btn btn-outline-secondary gallery-filter-btn rounded-pill px-3 py-2 shadow-sm" data-filter="archives">Archives</button>
            </div>

            <!-- 2. RESPONSIVE PHOTO GRID -->
            <div class="row g-3 gallery-grid-5" id="galleryContainer">
                @forelse($albums as $index => $item)
                    <div class="col-6 col-sm-6 col-md-4 col-lg-3 gallery-item-col {{ $item->filter_tag }} wow fadeInUp" data-wow-delay="{{ 0.1 * (($index % 4) + 1) }}s">
                        <div class="gallery-tile gallery-item-card border-0 rounded-4 shadow-sm cursor-pointer position-relative overflow-hidden bg-white" style="border-radius: 20px !important;"
                             data-bs-toggle="modal" data-bs-target="#studentDetailModal"
                             data-id="{{ $item->student_id_number ?? ('NUESA/UMD/2025/' . str_pad($item->id, 4, '0', STR_PAD_LEFT)) }}"
                             data-name="{{ $item->student_name }}"
                             data-dept="{{ $item->department->name ?? 'Faculty of Engineering' }}"
                             data-class="{{ $item->academic_class }}"
                             data-role="{{ $item->position_role }}"
                             data-phone="{{ $item->phone ?? '+234 800 000 0000' }}"
                             data-email="{{ $item->email ?? 'student@eng.unimaid.edu.ng' }}"
                             data-state="{{ $item->state_of_origin ?? 'Borno State' }}"
                             data-joined="{{ $item->joined_date ?? 'October 2020' }}"
                             data-verified="{{ $item->verification_status }}"
                             data-img="{{ asset($item->image_path) }}">
                            <div class="position-relative overflow-hidden gallery-img-box">
                                <img class="img-fluid w-100 h-100 gallery-tile-img" src="{{ asset($item->image_path) }}" alt="{{ $item->student_name }}" style="object-fit: cover;">
                                <span class="badge bg-primary position-absolute top-0 start-0 m-2 px-3 py-2 shadow-sm fw-bold rounded-pill" style="font-size: 0.75rem; letter-spacing: 0.5px;">{{ $item->department->code ?? 'NUESA' }}</span>
                                <span class="badge bg-dark bg-opacity-75 text-white position-absolute top-0 end-0 m-2 px-2 py-1 shadow-sm fw-bold rounded-pill" style="font-size: 0.65rem;" title="{{ $item->position_role }}"><i class="fa fa-user-tag me-1"></i>{{ Str::limit($item->position_role, 18) }}</span>
                            </div>
                            <div class="p-3 bg-white text-center">
                                <h6 class="mb-1 text-dark small fw-bold text-truncate" title="{{ $item->student_name }}">{{ $item->student_name }}</h6>
                                <span class="badge bg-primary-subtle text-primary border border-primary extra-small rounded-pill"><i class="fa fa-eye me-1"></i>View Details</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center text-muted py-5">
                        <i class="fa fa-user-graduate fa-3x text-muted mb-3 d-block"></i>
                        <h5>No student profiles in the album yet.</h5>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    <!-- Gallery Grid End -->

    <!-- 3. STUDENT DETAIL MODAL ON CLICK -->
    <div class="modal fade" id="studentDetailModal" tabindex="-1" aria-labelledby="studentDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 rounded-4 overflow-hidden shadow-lg">
                <div class="modal-header bg-dark text-white border-bottom border-secondary py-3 px-4">
                    <div class="d-flex align-items-center">
                        <i class="fa fa-id-card text-primary fs-4 me-2"></i>
                        <h5 class="modal-title text-white mb-0" id="studentDetailModalLabel">NUESA Student Profile</h5>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 bg-light">
                    <div class="row align-items-stretch g-4">
                        <div class="col-md-5 text-center d-flex flex-column">
                            <div class="w-100 h-100 position-relative overflow-hidden rounded-4 shadow border border-3 border-primary bg-secondary">
                                <img id="modalStudentImg" class="img-fluid w-100 h-100" src="{{ asset('img/project-1.jpg') }}" alt="Student Portrait" style="min-height: 300px; object-fit: cover;">
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                                <span class="badge bg-primary px-3 py-2 rounded-pill fw-bold" style="font-size: 0.85rem;"><i class="fa fa-id-badge me-1"></i><span id="modalStudentId">NUESA/UMD/2025/0101</span></span>
                                <span id="modalVerificationBadgeContainer">
                                    <span class="badge bg-success px-3 py-2 rounded-pill fw-semibold" style="font-size: 0.85rem;"><i class="fa fa-check-circle me-1"></i>Verified Member</span>
                                </span>
                            </div>
                            <h3 id="modalStudentName" class="text-dark fw-bold mb-3">Comr. Ismail Isah Yusuf</h3>
                            
                            <div class="bg-white p-3 rounded-4 border shadow-sm">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <small class="text-muted d-block text-uppercase fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.5px;">Department</small>
                                        <span class="fw-bold text-dark fs-6 text-break"><i class="fa fa-university text-primary me-2"></i><span id="modalStudentDept">Civil & Water Resources Engineering</span></span>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <small class="text-muted d-block text-uppercase fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.5px;">Academic Class</small>
                                        <span class="fw-semibold text-dark small d-block mt-1 text-break"><i class="fa fa-graduation-cap text-secondary me-2"></i><span id="modalStudentClass">Class of 2025 (500L)</span></span>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <small class="text-muted d-block text-uppercase fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.5px;">Position / Role</small>
                                        <span class="fw-semibold text-dark small d-block mt-1 text-break"><i class="fa fa-user-shield text-primary me-2"></i><span id="modalStudentRole">NUESA President</span></span>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <small class="text-muted d-block text-uppercase fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.5px;">Phone Contact</small>
                                        <span class="fw-semibold text-dark small d-block mt-1 text-break"><i class="fa fa-phone text-success me-2"></i><span id="modalStudentPhone">+234 803 456 7890</span></span>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <small class="text-muted d-block text-uppercase fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.5px;">State of Origin</small>
                                        <span class="fw-semibold text-dark small d-block mt-1 text-break"><i class="fa fa-map-marker-alt text-danger me-2"></i><span id="modalStudentState">Borno State</span></span>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <small class="text-muted d-block text-uppercase fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.5px;">Joined Since</small>
                                        <span class="fw-semibold text-dark small d-block mt-1 text-break"><i class="fa fa-calendar-check text-warning me-2"></i><span id="modalStudentJoined">October 2020</span></span>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <small class="text-muted d-block text-uppercase fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.5px;">Email Address</small>
                                        <span class="fw-semibold text-dark small d-block mt-1 text-break"><i class="fa fa-envelope text-info me-2"></i><span id="modalStudentEmail">ismail.yusuf@eng.unimaid.edu.ng</span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-white border-top py-2 px-4">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Close Profile</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal End -->
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Category Filter Logic
            $('.gallery-filter-btn').on('click', function() {
                $('.gallery-filter-btn').removeClass('btn-primary active').addClass('btn-outline-primary');
                $(this).removeClass('btn-outline-primary btn-outline-secondary').addClass('btn-primary active');
                
                var filter = $(this).attr('data-filter');
                if (filter === 'all') {
                    $('.gallery-item-col').fadeIn(300);
                } else {
                    $('.gallery-item-col').not('.' + filter).fadeOut(200);
                    $('.gallery-item-col.' + filter).fadeIn(300);
                }
            });

            // Dynamic Modal Data Injection
            $('.gallery-item-card').on('click', function() {
                var name = $(this).attr('data-name');
                var dept = $(this).attr('data-dept');
                var studentClass = $(this).attr('data-class');
                var role = $(this).attr('data-role');
                var phone = $(this).attr('data-phone') || '+234 800 000 0000';
                var email = $(this).attr('data-email') || 'student@eng.unimaid.edu.ng';
                var state = $(this).attr('data-state') || 'Borno State';
                var joined = $(this).attr('data-joined') || 'October 2020';
                var studentId = $(this).attr('data-id');
                var img = $(this).attr('data-img');
                var verifiedStatus = $(this).attr('data-verified') || 'verified';

                $('#modalStudentName').text(name);
                $('#modalStudentDept').text(dept);
                $('#modalStudentClass').text(studentClass);
                $('#modalStudentRole').text(role);
                $('#modalStudentPhone').text(phone);
                $('#modalStudentEmail').text(email);
                $('#modalStudentState').text(state);
                $('#modalStudentJoined').text(joined);
                $('#modalStudentId').text(studentId);
                $('#modalStudentImg').attr('src', img);

                if (verifiedStatus === 'verified') {
                    $('#modalVerificationBadgeContainer').html(`
                        <span class="badge bg-success px-3 py-2 rounded-pill fw-semibold" style="font-size: 0.85rem;">
                            <i class="fa fa-check-circle me-1"></i>Verified Member
                        </span>
                    `);
                } else {
                    $('#modalVerificationBadgeContainer').html(`
                        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-semibold" style="font-size: 0.85rem;">
                            <i class="fa fa-clock me-1"></i>To be verified
                        </span>
                    `);
                }
            });
        });
    </script>
@endpush
