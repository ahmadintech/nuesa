@extends('layouts.admin')

@section('title', 'NUESA Admin Portal - Executive Command Dashboard')

@section('content')
<!-- Welcome Header -->
<div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 gap-3">
    <div>
        <h3 class="fw-bold text-dark mb-1">NUESA Executive Command Center</h3>
        <p class="text-muted small mb-0">Faculty of Engineering Management & Portal Control Console.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.posts') }}" class="btn btn-outline-success rounded-pill px-3 fw-bold small">
            <i class="fa fa-newspaper me-1"></i>Manage Announcements
        </a>
        <a href="{{ route('admin.settings') }}" class="btn btn-success rounded-pill px-3 fw-bold small" style="background: linear-gradient(135deg, #008751 0%, #006038 100%); border: none;">
            <i class="fa fa-cog me-1"></i>Settings
        </a>
    </div>
</div>

<!-- System Key Metrics -->
<div class="row g-3 mb-4">
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="dash-card p-3 d-flex align-items-center">
            <div class="stat-card-icon bg-success-subtle text-success me-3">
                <i class="fa fa-users"></i>
            </div>
            <div>
                <div class="text-muted extra-small text-uppercase fw-bold">Total Students</div>
                <div class="fs-4 fw-bold text-dark" id="statTotalStudents">{{ number_format($totalStudents ?? 1248) }}</div>
                <div class="extra-small text-success fw-semibold"><i class="fa fa-arrow-up me-1"></i>Registered Engineering Students</div>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="dash-card p-3 d-flex align-items-center">
            <div class="stat-card-icon bg-primary-subtle text-primary me-3">
                <i class="fa fa-user-check"></i>
            </div>
            <div>
                <div class="text-muted extra-small text-uppercase fw-bold">Verified Members</div>
                <div class="fs-4 fw-bold text-dark" id="statVerifiedStudents">{{ number_format($verifiedStudentsCount ?? 1120) }}</div>
                <div class="extra-small text-primary fw-semibold">Paid Dues & Verified</div>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="dash-card p-3 d-flex align-items-center">
            <div class="stat-card-icon bg-warning-subtle text-warning me-3">
                <i class="fa fa-poll"></i>
            </div>
            <div>
                <div class="text-muted extra-small text-uppercase fw-bold">Live Elections</div>
                <div class="fs-4 fw-bold text-dark">Active</div>
                <div class="extra-small text-warning fw-semibold">Timer: <span id="adminTimer">04:28:12</span></div>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="dash-card p-3 d-flex align-items-center">
            <div class="stat-card-icon bg-info-subtle text-info me-3">
                <i class="fa fa-layer-group"></i>
            </div>
            <div>
                <div class="text-muted extra-small text-uppercase fw-bold">Active Depts</div>
                <div class="fs-4 fw-bold text-dark" id="statDepartmentsCount">{{ $departmentsCount ?? 8 }} Depts</div>
                <div class="extra-small text-info fw-semibold">Engineering Faculty</div>
            </div>
        </div>
    </div>
</div>

<!-- Main Admin Control Grid -->
<div class="row g-4 mb-4">
    <!-- Left: Quick Management Tables -->
    <div class="col-lg-8">

        <!-- Recent Registered Students & Verification Quick Table -->
        <div class="dash-card p-4 mb-4">
            <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-3">
                <div>
                    <h5 class="fw-bold text-dark mb-0">Student Verification Requests</h5>
                    <p class="text-muted extra-small mb-0">Recent student profiles awaiting executive validation.</p>
                </div>
                <a href="{{ route('admin.users') }}" class="btn btn-outline-success btn-sm rounded-pill px-3 fw-bold">View All Students</a>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light extra-small text-uppercase">
                        <tr>
                            <th>Student</th>
                            <th>Matric Number</th>
                            <th>Department</th>
                            <th>Level</th>
                            <th>Status</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody id="adminQuickStudentTable">
                        @forelse($recentUsers as $student)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $student->profile_photo_path ? asset('storage/' . $student->profile_photo_path) : asset('img/team-1.jpg') }}" alt="Student" class="rounded-circle me-2" style="width: 34px; height: 34px; object-fit: cover;">
                                        <div>
                                            <div class="fw-bold text-dark small">{{ $student->name }}</div>
                                            <div class="text-muted extra-small">{{ $student->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="fw-bold small text-primary">{{ $student->matric_number ?? '18/04/07/042' }}</td>
                                <td class="small">{{ $student->department->code ?? ($student->department->name ?? 'Computer Eng.') }}</td>
                                <td class="small">{{ $student->level ?? '500L' }}</td>
                                <td>
                                    @if($student->clearance_status === 'verified')
                                        <span class="badge bg-success-subtle text-success rounded-pill">VERIFIED</span>
                                    @else
                                        <span class="badge bg-warning-subtle text-warning rounded-pill">PENDING</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <form action="{{ route('admin.users.toggleVerification', $student->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-{{ $student->clearance_status === 'verified' ? 'outline-secondary' : 'success' }} btn-sm rounded-pill extra-small px-2 me-1">
                                            {{ $student->clearance_status === 'verified' ? 'Revoke' : 'Verify' }}
                                        </button>
                                    </form>

                                    <a href="{{ route('admin.users') }}" class="btn btn-light btn-sm rounded-circle text-primary" title="Edit Student"><i class="fa fa-edit"></i></a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">No student records found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Live Elections Control Widget -->
        <div class="dash-card p-4">
            <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-3">
                <div>
                    <h5 class="fw-bold text-dark mb-0"><i class="fa fa-vote-yea text-success me-2"></i>Elections Status & Controls</h5>
                    <p class="text-muted extra-small mb-0">NUESA UNIMAID General Elections 2025/2026.</p>
                </div>
                <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2 fw-bold">Live Voting Open</span>
            </div>

            <div class="row align-items-center g-3">
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3 border">
                        <div class="text-muted extra-small text-uppercase fw-bold mb-1">Total Votes Cast</div>
                        <div class="fs-3 fw-bold text-success">842 Votes</div>
                        <div class="progress mt-2" style="height: 6px;">
                            <div class="progress-bar bg-success" style="width: 68%;"></div>
                        </div>
                        <div class="extra-small text-muted mt-1">68% Turnout of accredited voters</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.posts') }}" class="btn btn-success fw-bold rounded-pill" style="background: linear-gradient(135deg, #008751 0%, #006038 100%); border: none;"><i class="fa fa-cog me-2"></i>Manage Candidates & Ballots</a>
                        <button class="btn btn-outline-warning fw-bold rounded-pill" onclick="Toast.fire({ icon: 'info', title: 'Election countdown timer refreshed!' });"><i class="fa fa-sync me-2"></i>Reset Timer</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Right: Quick Admin Tools & Config Summary -->
    <div class="col-lg-4">

        <!-- System Dropdown Quick Settings Box -->
        <div class="dash-card p-4 mb-4">
            <h5 class="fw-bold text-dark mb-3 border-bottom pb-2 d-flex align-items-center">
                <span class="material-symbols-outlined text-success me-2">settings</span> Settings Overview
            </h5>
            <p class="text-muted small mb-3">Update registration & profile dropdown menu lists dynamically.</p>

            <div class="list-group list-group-flush mb-3">
                <a href="{{ route('admin.settings') }}" class="list-group-item list-group-item-action d-flex align-items-center justify-content-between py-2 border-0 rounded-3 mb-1 bg-light">
                    <span class="fw-semibold small"><i class="fa fa-graduation-cap me-2 text-success"></i>Departments</span>
                    <span class="badge bg-success rounded-pill" id="badgeDeptCount">{{ $departmentsCount ?? 8 }} Options</span>
                </a>
                <a href="{{ route('admin.settings') }}" class="list-group-item list-group-item-action d-flex align-items-center justify-content-between py-2 border-0 rounded-3 mb-1 bg-light">
                    <span class="fw-semibold small"><i class="fa fa-layer-group me-2 text-primary"></i>Academic Levels</span>
                    <span class="badge bg-primary rounded-pill">6 Options</span>
                </a>
                <a href="{{ route('admin.settings') }}" class="list-group-item list-group-item-action d-flex align-items-center justify-content-between py-2 border-0 rounded-3 mb-1 bg-light">
                    <span class="fw-semibold small"><i class="fa fa-map-marker-alt me-2 text-warning"></i>States of Origin</span>
                    <span class="badge bg-warning rounded-pill">36 States</span>
                </a>
            </div>

            <a href="{{ route('admin.settings') }}" class="btn btn-outline-success btn-sm rounded-pill w-100 fw-bold">
                <i class="fa fa-sliders-h me-1"></i>Open Settings Console
            </a>
        </div>

        <!-- System Quick Actions -->
        <div class="dash-card p-4">
            <h5 class="fw-bold text-dark mb-3 border-bottom pb-2">Admin Shortcuts</h5>
            <div class="d-grid gap-2">
                <a href="{{ route('admin.posts') }}" class="btn btn-light text-start rounded-3 p-2 fw-semibold small text-dark d-flex align-items-center border">
                    <i class="fa fa-pen-nib text-success me-2 fs-5"></i>Publish New Announcement
                </a>
                <a href="{{ route('admin.users') }}" class="btn btn-light text-start rounded-3 p-2 fw-semibold small text-dark d-flex align-items-center border">
                    <i class="fa fa-id-card text-primary me-2 fs-5"></i>Batch Issue Student IDs
                </a>
                <a href="{{ route('student.digital-id') }}" target="_blank" class="btn btn-light text-start rounded-3 p-2 fw-semibold small text-dark d-flex align-items-center border">
                    <i class="fa fa-print text-warning me-2 fs-5"></i>Print Digital ID Sample
                </a>
            </div>
        </div>

    </div>
</div>
@endsection
