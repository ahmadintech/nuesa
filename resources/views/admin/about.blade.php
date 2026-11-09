@extends('layouts.admin')

@section('title', 'NUESA Admin Portal - Home & About Us Manager')

@push('styles')
<style>
    .profile-input-group .input-group-text {
        background-color: #f8f9fa !important;
        border-color: #e2e8f0 !important;
        color: #64748b !important;
        border-top-left-radius: 14px !important;
        border-bottom-left-radius: 14px !important;
    }

    .profile-input-group .form-control,
    .profile-input-group .form-select {
        background-color: #f8f9fa !important;
        border-color: #e2e8f0 !important;
        border-top-right-radius: 14px !important;
        border-bottom-right-radius: 14px !important;
        padding: 12px 16px;
        font-size: 0.95rem;
        color: #1e293b;
    }

    .profile-input-group .form-control:focus,
    .profile-input-group .form-select:focus {
        background-color: #ffffff !important;
        border-color: #008751 !important;
        box-shadow: 0 0 0 4px rgba(0, 135, 81, 0.1) !important;
    }
</style>
@endpush

@section('content')
    <!-- Header Banner -->
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 gap-3">
        <div>
            <h3 class="fw-bold text-dark mb-1">About Us Page Manager</h3>
            <p class="text-muted small mb-0">Manage President address, NUESA Executive Council (Excos), Mission & Vision, and department lists.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('about') }}" target="_blank" class="btn btn-outline-success rounded-pill px-3 py-2 fw-bold small d-inline-flex align-items-center">
                <i class="fa fa-external-link-alt me-2"></i>View Public About
            </a>
            <button type="submit" form="aboutSettingsForm" class="btn btn-success rounded-pill px-4 py-2 fw-bold shadow-sm d-inline-flex align-items-center text-nowrap" style="background: linear-gradient(135deg, #008751 0%, #006038 100%); border: none;">
                <i class="fa fa-save me-2"></i>Save Page Content
            </button>
        </div>
    </div>

    <!-- Alert Feedback Box -->
    @if(session('success'))
        <div id="aboutAlert" class="alert alert-success alert-dismissible fade show rounded-4 mb-4" role="alert">
            <i class="fa fa-check-circle me-2"></i><span>{{ session('success') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form id="aboutSettingsForm" action="{{ route('admin.about.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- SECTION 1: PRESIDENT'S WELCOME ADDRESS -->
        <div class="dash-card p-4 p-md-5 mb-4">
            <h5 class="fw-bold text-dark mb-3 border-bottom pb-2"><i class="fa fa-quote-left text-success me-2"></i>President's Welcome Address</h5>

            <div class="row g-4 align-items-center">
                <div class="col-md-4 text-center">
                    <div class="position-relative d-inline-block mb-3">
                        <img id="presPhotoPreview" src="{{ asset($president->photo_path ?? $settings['about_president_photo'] ?? 'img/team-1.jpg') }}" alt="NUESA President" class="rounded-circle shadow" style="width: 140px; height: 140px; object-fit: cover; border: 4px solid #008751;">
                        <button type="button" class="btn btn-sm btn-light rounded-circle shadow position-absolute bottom-0 end-0 p-2 border" title="Change Photo" onclick="document.getElementById('presPhotoInput').click();">
                            <i class="fa fa-camera text-success"></i>
                        </button>
                        <input type="file" name="about_president_photo" id="presPhotoInput" class="d-none" accept="image/*" onchange="previewPresidentPhoto(this)">
                    </div>
                    <div class="mb-2">
                        <input type="text" name="about_president_name" class="form-control form-control-sm rounded-pill text-center fw-bold" value="{{ $president->name ?? $settings['about_president_name'] ?? 'Comr. Ismail Isah Yusuf' }}" placeholder="President Name">
                    </div>
                    <div class="mb-2">
                        <input type="text" name="about_president_title" class="form-control form-control-sm rounded-pill text-center extra-small text-success fw-bold" value="{{ $settings['about_president_title'] ?? ($president ? 'NUESA ' . $president->office_position . ' (' . ($president->academic_session ?? '2025/2026') . ' Session)' : 'NUESA President (2025/2026 Session)') }}" placeholder="President Title">
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-success rounded-pill px-3 extra-small fw-bold" onclick="document.getElementById('presPhotoInput').click();">
                        <i class="fa fa-image me-1"></i>Change President Photo
                    </button>
                </div>
                <div class="col-md-8">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-bold text-dark small">Key Quote / Tagline</label>
                            <div class="input-group profile-input-group">
                                <span class="input-group-text"><span class="material-symbols-outlined">format_quote</span></span>
                                <input type="text" name="about_president_quote" class="form-control" value="{{ $settings['about_president_quote'] ?? 'Building world-class engineers through innovation, academic integrity, and dedicated student advocacy.' }}">
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold text-dark small">Full Address Speech Content</label>
                            <div class="input-group profile-input-group">
                                <span class="input-group-text"><span class="material-symbols-outlined">notes</span></span>
                                <textarea name="about_president_speech" class="form-control" rows="5">{{ $settings['about_president_speech'] ?? 'On behalf of the Executive Council and the entire engineering student body of the University of Maiduguri, I warmly welcome you to our official web portal. Founded over 25 years ago, NUESA UNIMAID has grown into a vibrant umbrella body uniting over 2,500 students across 8 accredited engineering departments.' }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION 2: NUESA EXECUTIVE COUNCIL (EXCOS) MANAGER -->
        <div class="dash-card p-4 p-md-5 mb-4">
            <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-2">
                <div>
                    <h5 class="fw-bold text-dark mb-0"><i class="fa fa-users text-primary me-2"></i>NUESA Executive Council (Excos)</h5>
                    <div class="text-muted extra-small">Manage student leadership officers for the 2025/2026 Academic Session</div>
                </div>
                <button type="button" class="btn btn-sm btn-outline-success rounded-pill px-3 fw-bold" data-bs-toggle="modal" data-bs-target="#addExcoModal">
                    <i class="fa fa-plus-circle me-1"></i>Add Exco Member
                </button>
            </div>

            <div class="row g-4" id="excoGrid">
                @forelse($excos as $exco)
                    <div class="col-md-6 col-lg-4">
                        <div class="p-3 border rounded-4 bg-light h-100 position-relative">
                            <button type="button" class="btn btn-sm btn-light text-danger rounded-circle position-absolute top-0 end-0 m-2 border shadow-sm" style="z-index: 5;" onclick="promptDeleteExco({{ $exco->id }}, '{{ addslashes($exco->name) }}', '{{ addslashes($exco->office_position) }}')" title="Remove Exco Member">
                                <i class="fa fa-trash"></i>
                            </button>
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="position-relative">
                                    <img id="excoImgPreview_{{ $exco->id }}" src="{{ asset($exco->photo_path ?? 'img/team-1.jpg') }}" alt="{{ $exco->office_position }}" class="rounded-circle" style="width: 65px; height: 65px; object-fit: cover; border: 2px solid #008751;">
                                    <button type="button" class="btn btn-sm btn-light rounded-circle shadow position-absolute bottom-0 end-0 p-1 border" title="Change Photo" onclick="document.getElementById('excoPhotoInput_{{ $exco->id }}').click();" style="width: 24px; height: 24px; line-height: 1;">
                                        <i class="fa fa-camera text-success extra-small" style="font-size: 10px;"></i>
                                    </button>
                                    <input type="file" name="exco_photo_{{ $exco->id }}" id="excoPhotoInput_{{ $exco->id }}" class="d-none" accept="image/*" onchange="previewExcoPhoto(this, {{ $exco->id }})">
                                </div>
                                <div>
                                    <span class="badge bg-success-subtle text-success rounded-pill px-2 py-1 extra-small fw-bold mb-1">Exco {{ $loop->iteration }}</span>
                                    <div class="fw-bold text-dark small">{{ $exco->name }}</div>
                                    <div class="text-muted extra-small">{{ $exco->department->name ?? 'Faculty of Engineering' }}</div>
                                </div>
                            </div>
                            <div class="mb-2">
                                <label class="form-label extra-small fw-bold mb-1">Full Name</label>
                                <input type="text" name="excos[{{ $exco->id }}][name]" class="form-control form-control-sm rounded-pill" value="{{ $exco->name }}">
                            </div>
                            <div class="mb-2">
                                <label class="form-label extra-small fw-bold mb-1">Office / Position</label>
                                <input type="text" name="excos[{{ $exco->id }}][office_position]" class="form-control form-control-sm rounded-pill" value="{{ $exco->office_position }}">
                            </div>
                            <div class="mb-2">
                                <label class="form-label extra-small fw-bold mb-1">Department</label>
                                <select name="excos[{{ $exco->id }}][department_id]" class="form-select form-select-sm rounded-pill">
                                    @foreach($departments as $dept)
                                        <option value="{{ $dept->id }}" {{ $exco->department_id == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="row g-1">
                                <div class="col-6">
                                    <input type="text" name="excos[{{ $exco->id }}][twitter_handle]" class="form-control form-control-sm rounded-pill extra-small" placeholder="Twitter URL" value="{{ $exco->twitter_handle }}">
                                </div>
                                <div class="col-6">
                                    <input type="text" name="excos[{{ $exco->id }}][linkedin_url]" class="form-control form-control-sm rounded-pill extra-small" placeholder="LinkedIn URL" value="{{ $exco->linkedin_url }}">
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center text-muted py-4">No executive council members added yet.</div>
                @endforelse
            </div>
        </div>

        <!-- SECTION 3: ABOUT NUESA & MISSION STATEMENT -->
        <div class="dash-card p-4 p-md-5 mb-4">
            <h5 class="fw-bold text-dark mb-3 border-bottom pb-2"><i class="fa fa-info-circle text-warning me-2"></i>About NUESA UNIMAID & Core Objectives</h5>

            <div class="row g-4">
                <div class="col-12">
                    <label class="form-label fw-bold text-dark small">About NUESA Overview</label>
                    <div class="input-group profile-input-group">
                        <span class="input-group-text"><span class="material-symbols-outlined">menu_book</span></span>
                        <textarea name="about_overview" class="form-control" rows="4">{{ $settings['about_overview'] ?? 'The National Association of Engineering Students (NUESA), University of Maiduguri Chapter, represents over 3,000 undergraduate and postgraduate engineering scholars across 8 accredited departments. NUESA serves as the unified voice for student advocacy, professional development, and technological empowerment.' }}</textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold text-dark small">Mission Statement</label>
                    <div class="input-group profile-input-group">
                        <span class="input-group-text"><span class="material-symbols-outlined">flag</span></span>
                        <textarea name="about_mission" class="form-control" rows="4">{{ $settings['about_mission'] ?? 'Empower students through technical mentorship, academic past questions, and career placement support.' }}</textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold text-dark small">Vision Statement</label>
                    <div class="input-group profile-input-group">
                        <span class="input-group-text"><span class="material-symbols-outlined">visibility</span></span>
                        <textarea name="about_vision" class="form-control" rows="4">{{ $settings['about_vision'] ?? 'To produce industry-ready engineering graduates capable of solving complex national challenges.' }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- BOTTOM SAVE BUTTON ACTION BAR -->
        <div class="dash-card p-4 mb-4 text-end">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div class="text-start">
                    <div class="fw-bold text-dark"><i class="fa fa-info-circle text-success me-2"></i>Save Configuration</div>
                    <div class="text-muted extra-small">Clicking Save will update the public about page live immediately.</div>
                </div>
                <button type="submit" class="btn btn-success rounded-pill px-5 py-3 fw-bold shadow d-inline-flex align-items-center" style="background: linear-gradient(135deg, #008751 0%, #006038 100%); border: none;">
                    <i class="fa fa-save me-2 fs-5"></i>Save Page Content
                </button>
            </div>
        </div>
    </form>

    <!-- Hidden Exco Delete Forms -->
    @foreach($excos as $exco)
        <form id="deleteExcoForm_{{ $exco->id }}" action="{{ route('admin.about.exco.destroy', $exco->id) }}" method="POST" class="d-none">
            @csrf
            @method('DELETE')
        </form>
    @endforeach

    <!-- ADD EXCO MEMBER MODAL -->
    <div class="modal fade" id="addExcoModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow-lg">
                <div class="modal-header border-bottom">
                    <h5 class="modal-title fw-bold text-dark"><i class="fa fa-user-plus text-success me-2"></i>Add Exco Member</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <form action="{{ route('admin.about.exco.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Full Name & Rank</label>
                            <div class="input-group profile-input-group">
                                <span class="input-group-text"><span class="material-symbols-outlined">person</span></span>
                                <input type="text" name="name" class="form-control" placeholder="e.g. Comr. Ahmad Ibrahim" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Executive Office / Position</label>
                            <div class="input-group profile-input-group">
                                <span class="input-group-text"><span class="material-symbols-outlined">badge</span></span>
                                <input type="text" name="office_position" class="form-control" placeholder="e.g. Assistant Secretary General" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Department</label>
                            <div class="input-group profile-input-group">
                                <span class="input-group-text"><span class="material-symbols-outlined">school</span></span>
                                <select name="department_id" class="form-select" required>
                                    @foreach($departments as $dept)
                                        <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-6">
                                <label class="form-label small fw-bold">Twitter Handle</label>
                                <div class="input-group profile-input-group">
                                    <span class="input-group-text"><span class="material-symbols-outlined">link</span></span>
                                    <input type="text" name="twitter_handle" class="form-control" placeholder="@handle">
                                </div>
                            </div>
                            <div class="col-6">
                                <label class="form-label small fw-bold">LinkedIn URL</label>
                                <div class="input-group profile-input-group">
                                    <span class="input-group-text"><span class="material-symbols-outlined">link</span></span>
                                    <input type="text" name="linkedin_url" class="form-control" placeholder="linkedin.com/in/user">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Executive Officer Photo</label>
                            <div class="input-group profile-input-group">
                                <span class="input-group-text"><span class="material-symbols-outlined">account_box</span></span>
                                <input type="file" name="photo" class="form-control" accept="image/*">
                            </div>
                        </div>
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-success rounded-pill fw-bold py-3" style="background: linear-gradient(135deg, #008751 0%, #006038 100%); border: none;">
                                Add Executive Officer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- DELETE EXCO CONFIRMATION MODAL -->
    <div class="modal fade" id="deleteExcoConfirmModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow-lg overflow-hidden">
                <div class="modal-header border-0 bg-danger text-white py-3 px-4">
                    <h5 class="modal-title fw-bold fs-6 d-flex align-items-center mb-0">
                        <span class="material-symbols-outlined me-2">warning</span> Confirm Delete Executive Officer
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 text-center">
                    <div class="rounded-circle bg-danger-subtle text-danger mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
                        <span class="material-symbols-outlined" style="font-size: 36px;">delete_forever</span>
                    </div>
                    <h6 class="fw-bold text-dark mb-1" id="deleteExcoModalName">Executive Officer Name</h6>
                    <div class="badge bg-secondary-subtle text-dark rounded-pill px-3 py-1 mb-3" id="deleteExcoModalPos">Position</div>
                    <p class="text-muted small mb-0">Are you sure you want to remove this officer from the NUESA Executive Council list? This action will immediately update the portal.</p>
                </div>
                <div class="modal-footer border-0 bg-light px-4 py-3 justify-content-between">
                    <button type="button" class="btn btn-light rounded-pill px-4 fw-bold border" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger rounded-pill px-4 fw-bold shadow-sm" onclick="executeDeleteExco()">
                        <i class="fa fa-trash me-1"></i> Yes, Remove Officer
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    let targetExcoDeleteId = null;

    function promptDeleteExco(id, name, position) {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Remove Executive Officer?',
                html: `Are you sure you want to remove <strong>${name}</strong> (${position}) from the Executive Council list?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fa fa-trash me-1"></i> Yes, Remove Officer',
                cancelButtonText: 'Cancel',
                customClass: {
                    popup: 'rounded-4 shadow-lg',
                    confirmButton: 'rounded-pill px-4 fw-bold',
                    cancelButton: 'rounded-pill px-4 fw-bold'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deleteExcoForm_' + id).submit();
                }
            });
        } else {
            targetExcoDeleteId = id;
            document.getElementById('deleteExcoModalName').innerText = name;
            document.getElementById('deleteExcoModalPos').innerText = position;
            const modalElement = document.getElementById('deleteExcoConfirmModal');
            if (modalElement) {
                const modal = new bootstrap.Modal(modalElement);
                modal.show();
            }
        }
    }

    function executeDeleteExco() {
        if (targetExcoDeleteId) {
            document.getElementById('deleteExcoForm_' + targetExcoDeleteId).submit();
        }
    }

    function previewPresidentPhoto(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('presPhotoPreview').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function previewExcoPhoto(input, id) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.getElementById('excoImgPreview_' + id);
                if (img) img.src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
