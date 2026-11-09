@extends('layouts.student')

@section('title', 'Profile Settings & Verification - NUESA Student Portal')

@section('content')
<div class="row g-4">
    <!-- LEFT COLUMN: AVATAR & VERIFICATION BADGE CARD -->
    <div class="col-lg-4">
        <div class="dash-card p-4 text-center">
            <div class="position-relative d-inline-block mb-3">
                <img src="{{ $user->profile_photo_path ? asset('storage/' . $user->profile_photo_path) : asset('img/team-1.jpg') }}" id="profileAvatarPreview" class="rounded-circle shadow border border-3 border-success" style="width: 120px; height: 120px; object-fit: cover;">
                <label for="avatarUploadInput" class="position-absolute bottom-0 end-0 bg-primary text-white rounded-circle p-2 shadow cursor-pointer" style="width: 38px; height: 38px; cursor: pointer;" title="Change Profile Picture">
                    <i class="fa fa-camera extra-small"></i>
                </label>
                <input type="file" form="profileForm" name="avatar" id="avatarUploadInput" accept="image/*" class="d-none" onchange="handleAvatarUpload(this)">
            </div>

            <h5 class="fw-bold text-dark mb-1" id="cardStudentName">{{ $user->name ?? 'Ismail Yusuf' }}</h5>
            <p class="text-muted small mb-3" id="cardDepartment">{{ $user->department->name ?? 'Computer Engineering' }}</p>

            <!-- VERIFICATION BADGE SECTION -->
            <div class="p-3 bg-light rounded-4 border text-center mb-3">
                <div id="verificationBadgeContainer" class="mb-3">
                    <span class="badge bg-success-subtle text-success fs-6 px-3 py-2 rounded-pill border border-success">
                        <i class="fa fa-check-circle me-1"></i> VERIFIED STUDENT
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- RIGHT COLUMN: EDITABLE BIODATA FORM -->
    <div class="col-lg-8">
        <div class="dash-card p-4 p-lg-5">
            <div class="d-flex align-items-center justify-content-between mb-4 border-bottom pb-3">
                <div>
                    <h4 class="text-dark fw-bold mb-1">Student Biodata & Account Settings</h4>
                    <p class="text-muted small mb-0">Update your student information, contact details, and academic profile.</p>
                </div>
            </div>



            <form action="{{ route('student.profile.update') }}" method="POST" enctype="multipart/form-data" id="profileForm">
                @csrf
                @method('PUT')

                <div class="row g-4">
                    <!-- Full Name -->
                    <div class="col-md-6">
                        <label for="inputFullName" class="form-label fw-semibold text-dark small d-flex align-items-center mb-2">
                            <span class="material-symbols-outlined text-primary me-2" style="font-size: 20px;">person</span>
                            Full Name
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted px-3 py-3" style="border-top-left-radius: 16px; border-bottom-left-radius: 16px;">
                                <span class="material-symbols-outlined" style="font-size: 20px;">badge</span>
                            </span>
                            <input type="text" name="name" id="inputFullName" class="form-control bg-light border-start-0 py-3 fs-6" style="border-top-right-radius: 16px; border-bottom-right-radius: 16px;" value="{{ old('name', $user->name ?? 'Ismail Yusuf') }}" required>
                        </div>
                    </div>

                    <!-- Matric / ID Number -->
                    <div class="col-md-6">
                        <label for="inputMatric" class="form-label fw-semibold text-dark small d-flex align-items-center mb-2">
                            <span class="material-symbols-outlined text-primary me-2" style="font-size: 20px;">id_card</span>
                            Matriculation Number
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted px-3 py-3" style="border-top-left-radius: 16px; border-bottom-left-radius: 16px;">
                                <span class="material-symbols-outlined" style="font-size: 20px;">tag</span>
                            </span>
                            <input type="text" name="matric_number" id="inputMatric" class="form-control bg-light border-start-0 py-3 fs-6" style="border-top-right-radius: 16px; border-bottom-right-radius: 16px;" value="{{ old('matric_number', $user->matric_number ?? '18/04/07/042') }}" required>
                        </div>
                    </div>

                    <!-- Department Dropdown -->
                    <div class="col-md-6">
                        <label for="inputDepartment" class="form-label fw-semibold text-dark small d-flex align-items-center mb-2">
                            <span class="material-symbols-outlined text-primary me-2" style="font-size: 20px;">account_balance</span>
                            Department
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted px-3 py-3" style="border-top-left-radius: 16px; border-bottom-left-radius: 16px;">
                                <span class="material-symbols-outlined" style="font-size: 20px;">school</span>
                            </span>
                            <select name="department_id" id="inputDepartment" class="form-select bg-light border-start-0 py-3 fs-6" style="border-top-right-radius: 16px; border-bottom-right-radius: 16px;" required>
                                <option value="">Select Department</option>
                                @foreach($departments as $dept)
                                    <option value="{{ $dept->id }}" {{ (old('department_id', $user->department_id ?? '') == $dept->id) ? 'selected' : '' }}>
                                        {{ $dept->name }}
                                    </option>
                                @endforeach
                                @if($departments->isEmpty())
                                    <option value="1" selected>Computer Engineering</option>
                                    <option value="2">Agricultural and Environmental Resources Engineering</option>
                                    <option value="3">Chemical Engineering</option>
                                    <option value="4">Civil and Water Resources Engineering</option>
                                    <option value="5">Electrical and Electronics Engineering</option>
                                    <option value="6">Mechanical Engineering</option>
                                    <option value="7">Food Science and Technology</option>
                                    <option value="8">Petroleum and Gas Engineering</option>
                                @endif
                            </select>
                        </div>
                    </div>

                    <!-- Academic Level Dropdown -->
                    <div class="col-md-6">
                        <label for="inputLevel" class="form-label fw-semibold text-dark small d-flex align-items-center mb-2">
                            <span class="material-symbols-outlined text-primary me-2" style="font-size: 20px;">grade</span>
                            Academic Level
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted px-3 py-3" style="border-top-left-radius: 16px; border-bottom-left-radius: 16px;">
                                <span class="material-symbols-outlined" style="font-size: 20px;">layers</span>
                            </span>
                            <select name="level" id="inputLevel" class="form-select bg-light border-start-0 py-3 fs-6" style="border-top-right-radius: 16px; border-bottom-right-radius: 16px;">
                                <option value="100L" {{ old('level', $user->level) == '100L' ? 'selected' : '' }}>100 Level</option>
                                <option value="200L" {{ old('level', $user->level) == '200L' ? 'selected' : '' }}>200 Level</option>
                                <option value="300L" {{ old('level', $user->level) == '300L' ? 'selected' : '' }}>300 Level</option>
                                <option value="400L" {{ old('level', $user->level) == '400L' ? 'selected' : '' }}>400 Level</option>
                                <option value="500L" {{ old('level', $user->level) == '500L' || !$user->level ? 'selected' : '' }}>500 Level (Class of 2025)</option>
                                <option value="Graduate" {{ old('level', $user->level) == 'Graduate' ? 'selected' : '' }}>Graduate</option>
                            </select>
                        </div>
                    </div>

                    <!-- Phone Contact -->
                    <div class="col-md-6">
                        <label for="inputPhone" class="form-label fw-semibold text-dark small d-flex align-items-center mb-2">
                            <span class="material-symbols-outlined text-primary me-2" style="font-size: 20px;">call</span>
                            Phone Contact
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted px-3 py-3" style="border-top-left-radius: 16px; border-bottom-left-radius: 16px;">
                                <span class="material-symbols-outlined" style="font-size: 20px;">phone_android</span>
                            </span>
                            <input type="text" name="phone" id="inputPhone" class="form-control bg-light border-start-0 py-3 fs-6" style="border-top-right-radius: 16px; border-bottom-right-radius: 16px;" value="{{ old('phone', $user->phone ?? '+234 803 456 7890') }}" required>
                        </div>
                    </div>

                    <!-- Student Email (Readonly) -->
                    <div class="col-md-6">
                        <label for="inputEmail" class="form-label fw-semibold text-dark small d-flex align-items-center mb-2">
                            <span class="material-symbols-outlined text-primary me-2" style="font-size: 20px;">mail</span>
                            Student Email <span class="badge bg-secondary-subtle text-secondary ms-2 extra-small" style="font-size: 10px;">Non-editable</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text border-end-0 text-muted px-3 py-3" style="border-top-left-radius: 16px; border-bottom-left-radius: 16px; background-color: #e9ecef;">
                                <span class="material-symbols-outlined" style="font-size: 20px;">lock</span>
                            </span>
                            <input type="email" id="inputEmail" class="form-control border-start-0 py-3 fs-6" style="border-top-right-radius: 16px; border-bottom-right-radius: 16px; background-color: #e9ecef !important; cursor: not-allowed;" value="{{ $user->email ?? 'ismail.yusuf@eng.unimaid.edu.ng' }}" readonly required title="Student email cannot be edited">
                        </div>
                    </div>

                    <div class="col-12 mt-4 text-end">
                        <button type="submit" class="btn btn-primary px-5 py-3 fw-bold shadow-sm d-inline-flex align-items-center fs-6" style="border-radius: 50px; background: linear-gradient(135deg, #008751 0%, #006038 100%); border: none;">
                            <span class="material-symbols-outlined me-2" style="font-size: 22px;">save</span>
                            Save Profile Changes
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function handleAvatarUpload(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#profileAvatarPreview').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
