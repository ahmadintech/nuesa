@extends('layouts.admin')

@section('title', 'Elections Governance & Candidate Controls - Admin')

@push('styles')
<style>
    .admin-badge {
        background: linear-gradient(135deg, #008751 0%, #004d2e 100%);
        color: #fff;
        padding: 4px 12px;
        border-radius: 50px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.5px;
    }

    /* Profile Style Input Group Formatting */
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

    /* Premium Candidate Card Design */
    .candidate-card-premium {
        border: none;
        border-radius: 24px;
        background: #ffffff;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
        position: relative;
        overflow: hidden;
    }

    .candidate-card-premium:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0, 135, 81, 0.12);
    }

    .candidate-card-header {
        background: linear-gradient(135deg, #008751 0%, #004d2e 100%);
        padding: 24px 20px 50px 20px;
        color: #ffffff;
        position: relative;
    }

    .candidate-avatar-wrapper {
        margin-top: -45px;
        position: relative;
        z-index: 2;
    }

    .candidate-avatar-img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 50%;
        border: 4px solid #ffffff;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    .vote-stats-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        padding: 16px;
    }
</style>
@endpush

@section('content')
    <!-- Header Banner -->
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 gap-3">
        <div>
            <h3 class="fw-bold text-dark mb-1">General Elections Governance</h3>
            <p class="text-muted small mb-0">Configure election parameters, manage candidate profiles, monitor real-time vote tallies, and control voting timers.</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-success rounded-pill px-3 py-2 fw-bold shadow-sm d-inline-flex align-items-center btn-sm text-nowrap" data-bs-toggle="modal" data-bs-target="#addCandidateModal" style="background: linear-gradient(135deg, #008751 0%, #006038 100%); border: none;">
                <i class="fa fa-plus-circle me-2"></i>Add Candidate
            </button>
            <form action="{{ route('admin.elections.reset-votes') }}" method="POST" onsubmit="return confirm('Are you sure you want to reset all cast votes?')">
                @csrf
                <button type="submit" class="btn btn-outline-danger rounded-pill px-3 fw-bold small text-nowrap py-2">
                    <i class="fa fa-redo me-1"></i>Reset All Votes
                </button>
            </form>
        </div>
    </div>

    <!-- 1. ELECTION DETAILS CARD -->
    <div class="dash-card p-4 p-md-5 mb-4 bg-white border">
        <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-3">
            <div class="d-flex align-items-center">
                <span class="material-symbols-outlined text-success fs-2 me-3">info</span>
                <div>
                    <h5 class="fw-bold text-dark mb-0" id="dispElectionTitle">{{ $electionParams['title'] }}</h5>
                    <p class="text-muted extra-small mb-0">Official Electoral Commission Master Parameters & Guidelines</p>
                </div>
            </div>
            <button class="btn btn-outline-success btn-sm rounded-pill px-3 fw-bold" data-bs-toggle="modal" data-bs-target="#editElectionDetailsModal">
                <i class="fa fa-edit me-1"></i>Edit Election Details
            </button>
        </div>

        <div class="row g-3">
            <!-- Academic Session -->
            <div class="col-6 col-md">
                <div class="p-3 bg-white rounded-4 border shadow-sm h-100 d-flex align-items-center gap-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px; background: linear-gradient(135deg, rgba(0,135,81,0.15) 0%, rgba(0,135,81,0.05) 100%);">
                        <span class="material-symbols-outlined text-success fs-4">calendar_month</span>
                    </div>
                    <div>
                        <div class="text-muted extra-small text-uppercase fw-bold">Academic Session</div>
                        <div class="fw-bold text-dark fs-6" id="dispElectionSession">{{ $electionParams['session'] }}</div>
                    </div>
                </div>
            </div>

            <!-- Election Date -->
            <div class="col-6 col-md">
                <div class="p-3 bg-white rounded-4 border shadow-sm h-100 d-flex align-items-center gap-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px; background: linear-gradient(135deg, rgba(13,110,253,0.15) 0%, rgba(13,110,253,0.05) 100%);">
                        <span class="material-symbols-outlined text-primary fs-4">event_available</span>
                    </div>
                    <div>
                        <div class="text-muted extra-small text-uppercase fw-bold">Election Date</div>
                        <div class="fw-bold text-success fs-6" id="dispElectionDate">{{ \Carbon\Carbon::parse($electionParams['date'])->format('M d, Y') }}</div>
                    </div>
                </div>
            </div>

            <!-- Chief Electoral Officer -->
            <div class="col-6 col-md">
                <div class="p-3 bg-white rounded-4 border shadow-sm h-100 d-flex align-items-center gap-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px; background: linear-gradient(135deg, rgba(111,66,193,0.15) 0%, rgba(111,66,193,0.05) 100%);">
                        <span class="material-symbols-outlined fs-4" style="color: #6f42c1;">verified_user</span>
                    </div>
                    <div>
                        <div class="text-muted extra-small text-uppercase fw-bold">Chief Electoral Officer</div>
                        <div class="fw-bold text-dark fs-6" id="dispReturningOfficer">{{ $electionParams['officer'] }}</div>
                    </div>
                </div>
            </div>

            <!-- Accredited Voters -->
            <div class="col-6 col-md">
                <div class="p-3 bg-white rounded-4 border shadow-sm h-100 d-flex align-items-center gap-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px; background: linear-gradient(135deg, rgba(13,202,240,0.15) 0%, rgba(13,202,240,0.05) 100%);">
                        <span class="material-symbols-outlined text-info fs-4">how_to_reg</span>
                    </div>
                    <div>
                        <div class="text-muted extra-small text-uppercase fw-bold">Accredited Voters</div>
                        <div class="fw-bold text-primary fs-6" id="dispAccreditedVoters">1,120 Students</div>
                    </div>
                </div>
            </div>

            <!-- Voting Window -->
            <div class="col-6 col-md">
                <div class="p-3 bg-white rounded-4 border shadow-sm h-100 d-flex align-items-center gap-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px; background: linear-gradient(135deg, rgba(255,193,7,0.2) 0%, rgba(255,193,7,0.05) 100%);">
                        <span class="material-symbols-outlined text-warning fs-4">schedule</span>
                    </div>
                    <div>
                        <div class="text-muted extra-small text-uppercase fw-bold">Voting Window</div>
                        <div class="fw-bold text-dark fs-6" id="dispVotingWindow">{{ $electionParams['start_time'] }} - {{ $electionParams['end_time'] }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. LIVE CONTROL BAR -->
    <div class="dash-card p-4 mb-4 bg-white border">
        <div class="row align-items-center g-3">
            <div class="col-md-4">
                <div class="fw-bold text-dark mb-1 d-flex align-items-center">
                    <i class="fa fa-clock text-success me-2"></i>Live Timer Control
                    <span id="timerPulseBadge" class="badge bg-success-subtle text-success ms-2 extra-small fw-bold">RUNNING</span>
                </div>
                <div class="display-6 fw-bold text-success font-monospace" id="electionCountdownDisplay">04 : 28 : 12</div>
            </div>
            <div class="col-md-4">
                <div class="text-muted extra-small text-uppercase fw-bold mb-1">Voting Status</div>
                <select class="form-select rounded-pill fw-bold border-success text-success" id="electionStatusSelect" onchange="changeVotingStatus(this.value)">
                    <option value="LIVE" {{ $electionParams['status'] === 'LIVE' ? 'selected' : '' }}>🟢 Voting Status: LIVE OPEN</option>
                    <option value="PAUSED" {{ $electionParams['status'] === 'PAUSED' ? 'selected' : '' }}>🟡 Voting Status: PAUSED</option>
                    <option value="CONCLUDED" {{ $electionParams['status'] === 'CONCLUDED' ? 'selected' : '' }}>🔴 Voting Status: CONCLUDED / CLOSED</option>
                </select>
            </div>
            <div class="col-md-4 text-md-end">
                <button class="btn btn-success rounded-pill px-3 fw-bold me-1" onclick="startVotingTimer()"><i class="fa fa-play me-1"></i>Start</button>
                <button class="btn btn-warning rounded-pill px-3 fw-bold me-1 text-dark" onclick="pauseVotingTimer()"><i class="fa fa-pause me-1"></i>Pause</button>
                <button class="btn btn-outline-success rounded-pill px-3 fw-bold" onclick="openPortalPreviewModal()"><i class="fa fa-eye me-1"></i>Preview Portal</button>
            </div>
        </div>
    </div>

    <!-- 3. REDESIGNED CANDIDATES GRID -->
    <h5 class="fw-bold text-dark mb-3">Registered Candidates & Live Ballots</h5>
    
    @php
        $totalVotes = $candidates->sum('votes') ?: 1;
    @endphp

    <div class="row g-4 mb-4" id="candidatesGridAdmin">
        @forelse($candidates as $candidate)
            @php
                $votePercentage = round(($candidate->votes / $totalVotes) * 100, 1);
                $headerGradient = match($candidate->office) {
                    'VICE PRESIDENT' => 'linear-gradient(135deg, #1e3a8a 0%, #1e293b 100%)',
                    'GENERAL SECRETARY' => 'linear-gradient(135deg, #0284c7 0%, #0f172a 100%)',
                    'TREASURER' => 'linear-gradient(135deg, #d97706 0%, #78350f 100%)',
                    default => 'linear-gradient(135deg, #008751 0%, #004d2e 100%)',
                };
            @endphp
            <div class="col-md-6 col-lg-4">
                <div class="candidate-card-premium text-center">
                    
                    <!-- Header Strip -->
                    <div class="candidate-card-header" style="{{ $headerGradient }}">
                        <span class="badge bg-white text-dark rounded-pill px-3 py-1 fw-bold extra-small shadow-sm">{{ strtoupper($candidate->office) }} CONTESTANT</span>
                        <div class="text-white-50 extra-small mt-1">Faculty of Engineering</div>
                    </div>

                    <!-- Avatar -->
                    <div class="candidate-avatar-wrapper">
                        <img src="{{ asset($candidate->photo ?? 'img/team-1.jpg') }}" alt="{{ $candidate->name }}" class="candidate-avatar-img">
                    </div>

                    <!-- Details Body -->
                    <div class="p-4 pt-3">
                        <h5 class="fw-bold text-dark mb-1">{{ $candidate->name }}</h5>
                        <div class="text-success fw-semibold small mb-2">{{ $candidate->department }} • {{ $candidate->level }}</div>
                        @if($candidate->matric_number)
                            <div class="badge bg-light text-muted border rounded-pill px-3 py-1 mb-3 extra-small font-monospace">Matric: {{ $candidate->matric_number }}</div>
                        @endif

                        <!-- Live Vote Breakdown Box -->
                        <div class="vote-stats-box mb-3 text-start">
                            <div class="d-flex align-items-center justify-content-between mb-1">
                                <span class="text-muted extra-small fw-bold text-uppercase">Live Votes Received</span>
                                <span class="badge bg-success-subtle text-success rounded-pill extra-small fw-bold">{{ $votePercentage }}% Share</span>
                            </div>
                            <div class="d-flex align-items-baseline justify-content-between">
                                <div class="fs-3 fw-bold text-success">{{ number_format($candidate->votes) }} <span class="fs-6 fw-normal text-muted">Votes</span></div>
                                <div class="extra-small text-muted fw-semibold">of {{ number_format($totalVotes) }} Cast</div>
                            </div>
                            <div class="progress mt-2" style="height: 8px; border-radius: 10px;">
                                <div class="progress-bar bg-success" style="width: {{ $votePercentage }}%;"></div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-success btn-sm rounded-pill flex-grow-1 fw-bold py-2" 
                                onclick="openEditCandidateModal({{ $candidate->id }}, '{{ addslashes($candidate->name) }}', '{{ $candidate->office }}', '{{ $candidate->matric_number }}', '{{ addslashes($candidate->department) }}', '{{ $candidate->level }}')">
                                <i class="fa fa-edit me-1"></i>Edit Candidate
                            </button>
                            <button class="btn btn-outline-danger btn-sm rounded-pill px-3 py-2" 
                                onclick="openDeleteCandidateModal({{ $candidate->id }}, '{{ addslashes($candidate->name) }}')">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5 text-muted">
                <i class="fa fa-info-circle fs-2 mb-2 text-success"></i>
                <p>No candidates registered for this election yet.</p>
            </div>
        @endforelse
    </div>

    <!-- 1. ADD CANDIDATE MODAL -->
    <div class="modal fade" id="addCandidateModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow-lg">
                <div class="modal-header border-bottom">
                    <h5 class="modal-title fw-bold text-dark"><i class="fa fa-user-tie text-success me-2"></i>Register New Candidate</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <form action="{{ route('admin.elections.candidate.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Candidate Full Name</label>
                            <div class="input-group profile-input-group">
                                <span class="input-group-text"><span class="material-symbols-outlined">person</span></span>
                                <input type="text" class="form-control" name="name" placeholder="Comr. Abubakar Ahmed" required>
                            </div>
                        </div>
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="form-label small fw-bold">Office Contested</label>
                                <div class="input-group profile-input-group">
                                    <span class="input-group-text"><span class="material-symbols-outlined">badge</span></span>
                                    <select class="form-select" name="office" required>
                                        <option value="PRESIDENT">PRESIDENT</option>
                                        <option value="VICE PRESIDENT">VICE PRESIDENT</option>
                                        <option value="GENERAL SECRETARY">GENERAL SECRETARY</option>
                                        <option value="TREASURER">TREASURER</option>
                                        <option value="PUBLIC RELATIONS">PUBLIC RELATIONS</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <label class="form-label small fw-bold">Matric Number</label>
                                <div class="input-group profile-input-group">
                                    <span class="input-group-text"><span class="material-symbols-outlined">pin</span></span>
                                    <input type="text" class="form-control" name="matric_number" placeholder="22/05/01/0100" required>
                                </div>
                            </div>
                        </div>
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="form-label small fw-bold">Department</label>
                                <div class="input-group profile-input-group">
                                    <span class="input-group-text"><span class="material-symbols-outlined">school</span></span>
                                    <select class="form-select" name="department" required>
                                        <option value="Computer Engineering">Computer Engineering</option>
                                        <option value="Civil Engineering">Civil Engineering</option>
                                        <option value="Electrical Engineering">Electrical Engineering</option>
                                        <option value="Mechanical Engineering">Mechanical Engineering</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <label class="form-label small fw-bold">Academic Level</label>
                                <div class="input-group profile-input-group">
                                    <span class="input-group-text"><span class="material-symbols-outlined">layers</span></span>
                                    <select class="form-select" name="level" required>
                                        <option value="400L">400 Level</option>
                                        <option value="500L">500 Level</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Candidate Photo</label>
                            <div class="input-group profile-input-group">
                                <span class="input-group-text"><span class="material-symbols-outlined">image</span></span>
                                <input type="file" class="form-control" name="photo" accept="image/*">
                            </div>
                        </div>
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-success rounded-pill fw-bold py-3" style="background: linear-gradient(135deg, #008751 0%, #006038 100%); border: none;">
                                <i class="fa fa-check me-2"></i>Save & Publish Candidate
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. EDIT CANDIDATE PROFILE MODAL -->
    <div class="modal fade" id="editCandidateModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow-lg">
                <div class="modal-header border-bottom">
                    <h5 class="modal-title fw-bold text-dark"><i class="fa fa-edit text-success me-2"></i>Edit Candidate Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="editCandidateForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Candidate Full Name</label>
                            <div class="input-group profile-input-group">
                                <span class="input-group-text"><span class="material-symbols-outlined">person</span></span>
                                <input type="text" class="form-control" name="name" id="editCandName" required>
                            </div>
                        </div>
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="form-label small fw-bold">Office Contested</label>
                                <div class="input-group profile-input-group">
                                    <span class="input-group-text"><span class="material-symbols-outlined">badge</span></span>
                                    <select class="form-select" name="office" id="editCandOffice" required>
                                        <option value="PRESIDENT">PRESIDENT</option>
                                        <option value="VICE PRESIDENT">VICE PRESIDENT</option>
                                        <option value="GENERAL SECRETARY">GENERAL SECRETARY</option>
                                        <option value="TREASURER">TREASURER</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <label class="form-label small fw-bold">Matric Number</label>
                                <div class="input-group profile-input-group">
                                    <span class="input-group-text"><span class="material-symbols-outlined">pin</span></span>
                                    <input type="text" class="form-control" name="matric_number" id="editCandMatric" required>
                                </div>
                            </div>
                        </div>
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="form-label small fw-bold">Department</label>
                                <div class="input-group profile-input-group">
                                    <span class="input-group-text"><span class="material-symbols-outlined">school</span></span>
                                    <input type="text" class="form-control" name="department" id="editCandDept" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <label class="form-label small fw-bold">Academic Level</label>
                                <div class="input-group profile-input-group">
                                    <span class="input-group-text"><span class="material-symbols-outlined">layers</span></span>
                                    <input type="text" class="form-control" name="level" id="editCandLevel" required>
                                </div>
                            </div>
                        </div>
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-success rounded-pill fw-bold py-3" style="background: linear-gradient(135deg, #008751 0%, #006038 100%); border: none;">
                                <i class="fa fa-save me-2"></i>Save Profile Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. DELETE CANDIDATE CONFIRMATION MODAL -->
    <div class="modal fade" id="deleteCandidateModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow-lg text-center p-4">
                <div class="text-danger mb-3">
                    <span class="material-symbols-outlined" style="font-size: 64px;">warning</span>
                </div>
                <h4 class="fw-bold text-dark mb-2">Confirm Candidate Deletion</h4>
                <p class="text-muted small mb-4">Are you sure you want to remove candidate <strong id="deleteCandNameText" class="text-dark">Candidate Name</strong> from the ballot? This action cannot be undone.</p>
                
                <form id="deleteCandidateForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="d-flex gap-2 justify-content-center">
                        <button type="button" class="btn btn-light rounded-pill px-4 fw-bold" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger rounded-pill px-4 fw-bold"><i class="fa fa-trash me-2"></i>Delete Candidate</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- 4. EDIT ELECTION DETAILS MODAL -->
    <div class="modal fade" id="editElectionDetailsModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow-lg">
                <div class="modal-header border-bottom">
                    <h5 class="modal-title fw-bold text-dark"><i class="fa fa-cog text-success me-2"></i>Edit Election Parameters</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <form action="{{ route('admin.elections.parameters.update') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Election Title</label>
                            <div class="input-group profile-input-group">
                                <span class="input-group-text"><span class="material-symbols-outlined">title</span></span>
                                <input type="text" class="form-control" name="title" value="{{ $electionParams['title'] }}" required>
                            </div>
                        </div>
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="form-label small fw-bold">Academic Session</label>
                                <div class="input-group profile-input-group">
                                    <span class="input-group-text"><span class="material-symbols-outlined">calendar_today</span></span>
                                    <select class="form-select" name="session" required>
                                        <option value="2024/2025 Session" {{ $electionParams['session'] === '2024/2025 Session' ? 'selected' : '' }}>2024/2025 Session</option>
                                        <option value="2025/2026 Session" {{ $electionParams['session'] === '2025/2026 Session' ? 'selected' : '' }}>2025/2026 Session</option>
                                        <option value="2026/2027 Session" {{ $electionParams['session'] === '2026/2027 Session' ? 'selected' : '' }}>2026/2027 Session</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <label class="form-label small fw-bold">Election Date</label>
                                <div class="input-group profile-input-group">
                                    <span class="input-group-text"><span class="material-symbols-outlined">event</span></span>
                                    <input type="date" class="form-control" name="date" value="{{ $electionParams['date'] }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Chief Electoral Officer</label>
                            <div class="input-group profile-input-group">
                                <span class="input-group-text"><span class="material-symbols-outlined">person_pin</span></span>
                                <input type="text" class="form-control" name="officer" value="{{ $electionParams['officer'] }}" required>
                            </div>
                        </div>
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="form-label small fw-bold">Start Time</label>
                                <div class="input-group profile-input-group">
                                    <span class="input-group-text"><span class="material-symbols-outlined">schedule</span></span>
                                    <input type="time" class="form-control" name="start_time" value="{{ $electionParams['start_time'] }}" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <label class="form-label small fw-bold">End Time</label>
                                <div class="input-group profile-input-group">
                                    <span class="input-group-text"><span class="material-symbols-outlined">alarm_off</span></span>
                                    <input type="time" class="form-control" name="end_time" value="{{ $electionParams['end_time'] }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-success rounded-pill fw-bold py-3" style="background: linear-gradient(135deg, #008751 0%, #006038 100%); border: none;">
                                <i class="fa fa-save me-2"></i>Update Election Parameters
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- 5. TIMER STATUS CONFIRMATION MODAL -->
    <div class="modal fade" id="timerStatusModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow-lg text-center p-4">
                <div class="mb-3">
                    <span id="timerModalIcon" class="material-symbols-outlined text-success display-1">play_circle</span>
                </div>
                <h4 class="fw-bold text-dark mb-1" id="timerModalTitle">Voting Process Started</h4>
                <div class="mb-3">
                    <span id="timerModalBadge" class="badge bg-success-subtle text-success rounded-pill px-3 py-2 fw-bold">STATUS: LIVE</span>
                </div>
                <p class="text-muted small mb-4" id="timerModalBody">The election voting window is now LIVE. Students can cast their votes on the student portal.</p>
                <button type="button" class="btn btn-success rounded-pill px-5 fw-bold py-2" data-bs-dismiss="modal" style="background: linear-gradient(135deg, #008751 0%, #006038 100%); border: none;">Acknowledge & Close</button>
            </div>
        </div>
    </div>

    <!-- 6. PREVIEW PORTAL MODAL -->
    <div class="modal fade" id="previewPortalModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow-lg overflow-hidden">
                <div class="modal-header border-bottom bg-light">
                    <h5 class="modal-title fw-bold text-dark"><i class="fa fa-eye text-success me-2"></i>Student Portal Live Voting Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-0" style="height: 600px;">
                    <iframe src="{{ route('student.elections') }}" class="w-100 h-100 border-0"></iframe>
                </div>
                <div class="modal-footer border-top bg-light">
                    <a href="{{ route('student.elections') }}" target="_blank" class="btn btn-outline-success rounded-pill px-4 fw-bold">
                        <i class="fa fa-external-link-alt me-2"></i>Open Full Portal in New Tab
                    </a>
                    <button type="button" class="btn btn-secondary rounded-pill px-4 fw-bold" data-bs-dismiss="modal">Close Preview</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    let totalSeconds = 16092; // 04 : 28 : 12
    let timerInterval = null;
    let currentElectionStatus = "{{ $electionParams['status'] }}";

    function updateCountdownDisplay() {
        let hrs = Math.floor(totalSeconds / 3600);
        let mins = Math.floor((totalSeconds % 3600) / 60);
        let secs = totalSeconds % 60;

        let formattedHrs = String(hrs).padStart(2, '0');
        let formattedMins = String(mins).padStart(2, '0');
        let formattedSecs = String(secs).padStart(2, '0');

        $('#electionCountdownDisplay').text(`${formattedHrs} : ${formattedMins} : ${formattedSecs}`);
    }

    function tickTimer() {
        if (totalSeconds > 0) {
            totalSeconds--;
            updateCountdownDisplay();
        } else {
            clearInterval(timerInterval);
            timerInterval = null;
            $('#timerPulseBadge').removeClass().addClass('badge bg-danger-subtle text-danger ms-2 extra-small fw-bold').text('EXPIRED');
        }
    }

    function sendStatusUpdate(status, titleMessage, detailMessage) {
        fetch("{{ route('admin.elections.status.update') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ status: status })
        })
        .then(res => res.json())
        .then(data => {
            $('#timerModalTitle').text(titleMessage);
            $('#timerModalBody').text(detailMessage);
            $('#timerModalBadge').text('STATUS: ' + status);

            if (status === 'LIVE') {
                $('#timerModalIcon').removeClass().addClass('material-symbols-outlined text-success display-1').text('play_circle');
                $('#timerModalBadge').removeClass().addClass('badge bg-success-subtle text-success rounded-pill px-3 py-2 fw-bold');
                $('#timerPulseBadge').removeClass().addClass('badge bg-success-subtle text-success ms-2 extra-small fw-bold').text('RUNNING');
            } else if (status === 'PAUSED') {
                $('#timerModalIcon').removeClass().addClass('material-symbols-outlined text-warning display-1').text('pause_circle');
                $('#timerModalBadge').removeClass().addClass('badge bg-warning-subtle text-warning rounded-pill px-3 py-2 fw-bold');
                $('#timerPulseBadge').removeClass().addClass('badge bg-warning-subtle text-warning ms-2 extra-small fw-bold').text('PAUSED');
            } else {
                $('#timerModalIcon').removeClass().addClass('material-symbols-outlined text-danger display-1').text('cancel');
                $('#timerModalBadge').removeClass().addClass('badge bg-danger-subtle text-danger rounded-pill px-3 py-2 fw-bold');
                $('#timerPulseBadge').removeClass().addClass('badge bg-danger-subtle text-danger ms-2 extra-small fw-bold').text('CONCLUDED');
            }

            const modal = new bootstrap.Modal(document.getElementById('timerStatusModal'));
            modal.show();
        })
        .catch(err => console.error(err));
    }

    function startVotingTimer() {
        if (!timerInterval) {
            timerInterval = setInterval(tickTimer, 1000);
        }
        currentElectionStatus = 'LIVE';
        $('#electionStatusSelect').val('LIVE');
        sendStatusUpdate('LIVE', 'Voting Started & Timer Active', 'The election voting window is now LIVE. Students can cast their votes on the student portal.');
    }

    function pauseVotingTimer() {
        if (timerInterval) {
            clearInterval(timerInterval);
            timerInterval = null;
        }
        currentElectionStatus = 'PAUSED';
        $('#electionStatusSelect').val('PAUSED');
        sendStatusUpdate('PAUSED', 'Voting Paused', 'The election voting window has been PAUSED. Voting is temporarily locked on the student portal.');
    }

    function changeVotingStatus(val) {
        if (val === 'LIVE') {
            startVotingTimer();
        } else if (val === 'PAUSED') {
            pauseVotingTimer();
        } else {
            if (timerInterval) {
                clearInterval(timerInterval);
                timerInterval = null;
            }
            currentElectionStatus = 'CONCLUDED';
            sendStatusUpdate('CONCLUDED', 'Elections Concluded', 'The election has officially CONCLUDED. No further votes can be cast.');
        }
    }

    function openPortalPreviewModal() {
        const modal = new bootstrap.Modal(document.getElementById('previewPortalModal'));
        modal.show();
    }

    function openEditCandidateModal(id, name, office, matric, dept, level) {
        const updateUrl = "{{ url('admin/elections/candidate') }}/" + id;
        $('#editCandidateForm').attr('action', updateUrl);
        $('#editCandName').val(name);
        $('#editCandOffice').val(office);
        $('#editCandMatric').val(matric);
        $('#editCandDept').val(dept);
        $('#editCandLevel').val(level);

        const modal = new bootstrap.Modal(document.getElementById('editCandidateModal'));
        modal.show();
    }

    function openDeleteCandidateModal(id, name) {
        const deleteUrl = "{{ url('admin/elections/candidate') }}/" + id;
        $('#deleteCandidateForm').attr('action', deleteUrl);
        $('#deleteCandNameText').text(name);

        const modal = new bootstrap.Modal(document.getElementById('deleteCandidateModal'));
        modal.show();
    }

    $(document).ready(function() {
        updateCountdownDisplay();
        if (currentElectionStatus === 'LIVE') {
            timerInterval = setInterval(tickTimer, 1000);
            $('#timerPulseBadge').text('RUNNING');
        } else if (currentElectionStatus === 'PAUSED') {
            $('#timerPulseBadge').removeClass().addClass('badge bg-warning-subtle text-warning ms-2 extra-small fw-bold').text('PAUSED');
        } else {
            $('#timerPulseBadge').removeClass().addClass('badge bg-danger-subtle text-danger ms-2 extra-small fw-bold').text('CONCLUDED');
        }
    });
</script>
@endpush
