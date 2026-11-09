@extends('layouts.admin')

@section('title', 'Student Album Management - Admin Executive')
@section('page_header', 'Student Album & Profiles Management')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold m-0 text-dark">Student Album Profiles</h4>
            <p class="text-muted small m-0">Upload, view, and manage student photo cards & verification status for the student album.</p>
        </div>
        <button class="btn btn-primary rounded-pill px-4 shadow-sm fw-semibold" data-bs-toggle="modal" data-bs-target="#addStudentAlbumModal">
            <i class="fa fa-plus-circle me-2"></i>Add Student Profile
        </button>
    </div>

    <!-- Student Album Grid -->
    <div class="row g-4">
        @forelse($albums as $item)
            <div class="col-xl-3 col-lg-4 col-md-6">
                <div class="card border-0 rounded-4 shadow-sm h-100 overflow-hidden bg-white">
                    <div class="position-relative" style="height: 200px;">
                        <img src="{{ asset($item->image_path) }}" alt="{{ $item->student_name }}" class="w-100 h-100" style="object-fit: cover;">
                        <span class="badge bg-primary position-absolute top-0 start-0 m-3 px-3 py-2 rounded-pill shadow-sm">
                            {{ $item->department->code ?? 'NUESA' }}
                        </span>
                        @if($item->verification_status === 'verified')
                            <span class="badge bg-success position-absolute top-0 end-0 m-3 px-2 py-1 shadow-sm rounded-pill"><i class="fa fa-check-circle me-1"></i>Verified</span>
                        @else
                            <span class="badge bg-warning text-dark position-absolute top-0 end-0 m-3 px-2 py-1 shadow-sm rounded-pill"><i class="fa fa-clock me-1"></i>Pending</span>
                        @endif
                    </div>
                    <div class="card-body p-3">
                        <h6 class="fw-bold text-dark mb-1">{{ $item->student_name }}</h6>
                        <p class="text-primary extra-small fw-semibold mb-2"><i class="fa fa-user-shield me-1"></i>{{ $item->position_role }}</p>
                        <p class="text-muted small mb-1"><i class="fa fa-university me-1"></i>{{ $item->department->name ?? 'Faculty of Engineering' }}</p>
                        <p class="text-muted small mb-2"><i class="fa fa-graduation-cap me-1"></i>{{ $item->academic_class }}</p>
                        <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                            <span class="badge bg-light text-dark border small">{{ $item->student_id_number }}</span>
                            <form action="{{ route('admin.album.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this student profile?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle p-2" title="Delete Profile">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center text-muted py-5">
                <i class="fa fa-id-card fa-3x text-muted mb-3 d-block"></i>
                <h5>No student profiles added to the album yet.</h5>
            </div>
        @endforelse
    </div>

    <!-- Modal for Adding Student Album Profile -->
    <div class="modal fade" id="addStudentAlbumModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 rounded-4 shadow-lg overflow-hidden">
                <div class="modal-header text-white p-4" style="background: linear-gradient(135deg, #008751 0%, #004d2e 100%);">
                    <h5 class="modal-title fw-bold text-white mb-0 d-flex align-items-center">
                        <span class="material-symbols-outlined me-2" style="font-size: 26px;">person_add</span>
                        Add New Student Album Profile
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.album.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body p-4 bg-white">
                        <div class="row g-4">
                            <!-- Student Full Name -->
                            <div class="col-md-6">
                                <label for="albumStudentName" class="form-label fw-semibold text-dark small d-flex align-items-center mb-2">
                                    <span class="material-symbols-outlined text-primary me-2" style="font-size: 20px;">person</span>
                                    Student Full Name *
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted px-3 py-3" style="border-top-left-radius: 16px; border-bottom-left-radius: 16px;">
                                        <span class="material-symbols-outlined" style="font-size: 20px;">badge</span>
                                    </span>
                                    <input type="text" name="student_name" id="albumStudentName" class="form-control bg-light border-start-0 py-3 fs-6" style="border-top-right-radius: 16px; border-bottom-right-radius: 16px;" placeholder="e.g. Comr. Ismail Isah Yusuf" required>
                                </div>
                            </div>

                            <!-- Matric / Student ID -->
                            <div class="col-md-6">
                                <label for="albumMatricNumber" class="form-label fw-semibold text-dark small d-flex align-items-center mb-2">
                                    <span class="material-symbols-outlined text-primary me-2" style="font-size: 20px;">id_card</span>
                                    Matric / Student ID
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted px-3 py-3" style="border-top-left-radius: 16px; border-bottom-left-radius: 16px;">
                                        <span class="material-symbols-outlined" style="font-size: 20px;">fingerprint</span>
                                    </span>
                                    <input type="text" name="student_id_number" id="albumMatricNumber" class="form-control bg-light border-start-0 py-3 fs-6" style="border-top-right-radius: 16px; border-bottom-right-radius: 16px;" placeholder="e.g. NUESA/UMD/2025/0101">
                                </div>
                            </div>

                            <!-- Department -->
                            <div class="col-md-6">
                                <label for="albumDepartment" class="form-label fw-semibold text-dark small d-flex align-items-center mb-2">
                                    <span class="material-symbols-outlined text-primary me-2" style="font-size: 20px;">domain</span>
                                    Department
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted px-3 py-3" style="border-top-left-radius: 16px; border-bottom-left-radius: 16px;">
                                        <span class="material-symbols-outlined" style="font-size: 20px;">apartment</span>
                                    </span>
                                    <select name="department_id" id="albumDepartment" class="form-select bg-light border-start-0 py-3 fs-6" style="border-top-right-radius: 16px; border-bottom-right-radius: 16px;">
                                        <option value="">Select Department</option>
                                        @foreach($departments as $dept)
                                            <option value="{{ $dept->id }}">{{ $dept->name }} ({{ $dept->code }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Academic Class -->
                            <div class="col-md-6">
                                <label for="albumClass" class="form-label fw-semibold text-dark small d-flex align-items-center mb-2">
                                    <span class="material-symbols-outlined text-primary me-2" style="font-size: 20px;">school</span>
                                    Academic Class *
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted px-3 py-3" style="border-top-left-radius: 16px; border-bottom-left-radius: 16px;">
                                        <span class="material-symbols-outlined" style="font-size: 20px;">history_edu</span>
                                    </span>
                                    <input type="text" name="academic_class" id="albumClass" class="form-control bg-light border-start-0 py-3 fs-6" style="border-top-right-radius: 16px; border-bottom-right-radius: 16px;" placeholder="e.g. Class of 2025 (500L) or Alumni" required>
                                </div>
                            </div>

                            <!-- Position / Role -->
                            <div class="col-md-6">
                                <label for="albumRole" class="form-label fw-semibold text-dark small d-flex align-items-center mb-2">
                                    <span class="material-symbols-outlined text-primary me-2" style="font-size: 20px;">work</span>
                                    Position / Role *
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted px-3 py-3" style="border-top-left-radius: 16px; border-bottom-left-radius: 16px;">
                                        <span class="material-symbols-outlined" style="font-size: 20px;">admin_panel_settings</span>
                                    </span>
                                    <input type="text" name="position_role" id="albumRole" class="form-control bg-light border-start-0 py-3 fs-6" style="border-top-right-radius: 16px; border-bottom-right-radius: 16px;" placeholder="e.g. NUESA President or Student" required>
                                </div>
                            </div>

                            <!-- Filter Tag -->
                            <div class="col-md-6">
                                <label for="albumFilter" class="form-label fw-semibold text-dark small d-flex align-items-center mb-2">
                                    <span class="material-symbols-outlined text-primary me-2" style="font-size: 20px;">filter_alt</span>
                                    Filter Tag *
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted px-3 py-3" style="border-top-left-radius: 16px; border-bottom-left-radius: 16px;">
                                        <span class="material-symbols-outlined" style="font-size: 20px;">label</span>
                                    </span>
                                    <select name="filter_tag" id="albumFilter" class="form-select bg-light border-start-0 py-3 fs-6" style="border-top-right-radius: 16px; border-bottom-right-radius: 16px;" required>
                                        <option value="civil class2025">Civil Eng. - Class 2025</option>
                                        <option value="electrical class2025">Electrical Eng. - Class 2025</option>
                                        <option value="mechanical class2025">Mechanical Eng. - Class 2025</option>
                                        <option value="computer class2025">Computer Eng. - Class 2025</option>
                                        <option value="agricultural class2025">Agricultural Eng. - Class 2025</option>
                                        <option value="chemical class2025">Chemical Eng. - Class 2025</option>
                                        <option value="food class2025">Food Science - Class 2025</option>
                                        <option value="petroleum class2025">Petroleum Eng. - Class 2025</option>
                                        <option value="civil class2024 archives">Class of 2024 Alumni / Archives</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Phone Contact -->
                            <div class="col-md-6">
                                <label for="albumPhone" class="form-label fw-semibold text-dark small d-flex align-items-center mb-2">
                                    <span class="material-symbols-outlined text-primary me-2" style="font-size: 20px;">call</span>
                                    Phone Contact
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted px-3 py-3" style="border-top-left-radius: 16px; border-bottom-left-radius: 16px;">
                                        <span class="material-symbols-outlined" style="font-size: 20px;">smartphone</span>
                                    </span>
                                    <input type="text" name="phone" id="albumPhone" class="form-control bg-light border-start-0 py-3 fs-6" style="border-top-right-radius: 16px; border-bottom-right-radius: 16px;" placeholder="+234 803 000 0000">
                                </div>
                            </div>

                            <!-- Email Address -->
                            <div class="col-md-6">
                                <label for="albumEmail" class="form-label fw-semibold text-dark small d-flex align-items-center mb-2">
                                    <span class="material-symbols-outlined text-primary me-2" style="font-size: 20px;">mail</span>
                                    Email Address
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted px-3 py-3" style="border-top-left-radius: 16px; border-bottom-left-radius: 16px;">
                                        <span class="material-symbols-outlined" style="font-size: 20px;">mark_email_read</span>
                                    </span>
                                    <input type="email" name="email" id="albumEmail" class="form-control bg-light border-start-0 py-3 fs-6" style="border-top-right-radius: 16px; border-bottom-right-radius: 16px;" placeholder="student@eng.unimaid.edu.ng">
                                </div>
                            </div>

                            <!-- State of Origin -->
                            <div class="col-md-6">
                                <label for="albumState" class="form-label fw-semibold text-dark small d-flex align-items-center mb-2">
                                    <span class="material-symbols-outlined text-primary me-2" style="font-size: 20px;">location_on</span>
                                    State of Origin
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted px-3 py-3" style="border-top-left-radius: 16px; border-bottom-left-radius: 16px;">
                                        <span class="material-symbols-outlined" style="font-size: 20px;">map</span>
                                    </span>
                                    <input type="text" name="state_of_origin" id="albumState" class="form-control bg-light border-start-0 py-3 fs-6" style="border-top-right-radius: 16px; border-bottom-right-radius: 16px;" placeholder="e.g. Borno State">
                                </div>
                            </div>

                            <!-- Joined Date -->
                            <div class="col-md-6">
                                <label for="albumJoinedDate" class="form-label fw-semibold text-dark small d-flex align-items-center mb-2">
                                    <span class="material-symbols-outlined text-primary me-2" style="font-size: 20px;">calendar_month</span>
                                    Joined Date
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted px-3 py-3" style="border-top-left-radius: 16px; border-bottom-left-radius: 16px;">
                                        <span class="material-symbols-outlined" style="font-size: 20px;">event</span>
                                    </span>
                                    <input type="text" name="joined_date" id="albumJoinedDate" class="form-control bg-light border-start-0 py-3 fs-6" style="border-top-right-radius: 16px; border-bottom-right-radius: 16px;" placeholder="e.g. October 2020">
                                </div>
                            </div>

                            <!-- Verification Status -->
                            <div class="col-md-6">
                                <label for="albumStatus" class="form-label fw-semibold text-dark small d-flex align-items-center mb-2">
                                    <span class="material-symbols-outlined text-primary me-2" style="font-size: 20px;">verified</span>
                                    Verification Status *
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted px-3 py-3" style="border-top-left-radius: 16px; border-bottom-left-radius: 16px;">
                                        <span class="material-symbols-outlined" style="font-size: 20px;">check_circle</span>
                                    </span>
                                    <select name="verification_status" id="albumStatus" class="form-select bg-light border-start-0 py-3 fs-6" style="border-top-right-radius: 16px; border-bottom-right-radius: 16px;" required>
                                        <option value="verified">Verified Member</option>
                                        <option value="to_be_verified">Pending Verification</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Student Photo -->
                            <div class="col-md-6">
                                <label for="albumImage" class="form-label fw-semibold text-dark small d-flex align-items-center mb-2">
                                    <span class="material-symbols-outlined text-primary me-2" style="font-size: 20px;">photo_camera</span>
                                    Student Photo *
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted px-3 py-3" style="border-top-left-radius: 16px; border-bottom-left-radius: 16px;">
                                        <span class="material-symbols-outlined" style="font-size: 20px;">image</span>
                                    </span>
                                    <input type="file" name="image" id="albumImage" class="form-control bg-light border-start-0 py-3 fs-6" style="border-top-right-radius: 16px; border-bottom-right-radius: 16px;" accept="image/*" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light p-3">
                        <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary px-5 py-2.5 fw-bold shadow-sm d-inline-flex align-items-center" style="border-radius: 50px; background: linear-gradient(135deg, #008751 0%, #006038 100%); border: none;">
                            <span class="material-symbols-outlined me-2" style="font-size: 22px;">save</span>
                            Save Profile
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
