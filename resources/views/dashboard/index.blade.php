@extends('layouts.student')

@section('title', 'Dashboard Overview - NUESA Student Portal')

@section('content')
<!-- HERO GREETING BANNER -->
<div class="dashboard-hero-bg p-4 p-lg-5 text-white shadow-sm mb-4 position-relative overflow-hidden">
    <div class="row align-items-center g-4">
        <div class="col-lg-8">
            <h2 class="display-6 text-white fw-bold mb-2">Welcome back, Engr. {{ $user->name ?? 'Ismail Yusuf' }} 👋</h2>
            <p class="text-white-50 mb-3 fs-6">
                NUESA ID: <span class="text-white fw-bold me-3">NUESA/2026/{{ strtoupper(substr($user->department->name ?? 'CPE', 0, 3)) }}/0042</span> | 
                Matric No: <span class="text-white fw-bold me-3">{{ $user->matric_number ?? '18/04/07/042' }}</span>
            </p>
            <div class="d-flex flex-wrap gap-2 align-items-center">
                <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold">
                    <i class="fa fa-graduation-cap me-1"></i> {{ $user->department->name ?? 'Computer Engineering' }}
                </span>
                <span class="badge bg-light text-dark px-3 py-2 rounded-pill fw-bold">
                    <i class="fa fa-layer-group me-1"></i> Class of 2026 ({{ $user->level ?? '500L' }})
                </span>
                <span class="badge bg-success px-3 py-2 rounded-pill fw-bold">
                    <i class="fa fa-check-circle me-1"></i> {{ ucfirst($user->dues_status ?? 'Paid') }}
                </span>
            </div>
        </div>
        <div class="col-lg-4 text-lg-end">
            <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                <a href="{{ route('student.dues') }}" class="btn btn-secondary rounded-pill px-4 py-2 fw-bold shadow-sm">
                    <i class="fa fa-credit-card me-2"></i>Pay Dues
                </a>
                <a href="{{ route('student.digital-id') }}" class="btn btn-outline-light rounded-pill px-4 py-2 fw-semibold">
                    <i class="fa fa-id-card me-2"></i>Digital ID
                </a>
            </div>
        </div>
    </div>
</div>

<!-- QUICK STATS ROW -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3 stat-card-col">
        <div class="dash-card p-3 p-lg-4 h-100">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="text-muted small fw-semibold">Annual Dues</span>
                <div class="stat-icon-box bg-success-subtle text-success">
                    <span class="material-symbols-outlined">credit_score</span>
                </div>
            </div>
            <h4 class="text-dark fw-bold mb-1">VERIFIED</h4>
            <div class="small text-success fw-semibold mb-2"><i class="fa fa-check-circle me-1"></i>2025/2026 Paid</div>
            <a href="{{ route('student.dues') }}" class="small text-primary text-decoration-none fw-bold d-inline-flex align-items-center">
                View Receipts <i class="fa fa-chevron-right ms-1 extra-small"></i>
            </a>
        </div>
    </div>

    <div class="col-6 col-md-3 stat-card-col">
        <div class="dash-card p-3 p-lg-4 h-100">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="text-muted small fw-semibold">NUESA ID Card</span>
                <div class="stat-icon-box bg-warning-subtle text-warning">
                    <span class="material-symbols-outlined">badge</span>
                </div>
            </div>
            <h4 class="text-dark fw-bold mb-1">ACTIVE</h4>
            <div class="small text-muted mb-2">QR Hologram Valid</div>
            <a href="{{ route('student.digital-id') }}" class="small text-primary text-decoration-none fw-bold d-inline-flex align-items-center">
                Digital ID Badge <i class="fa fa-chevron-right ms-1 extra-small"></i>
            </a>
        </div>
    </div>

    <div class="col-6 col-md-3 stat-card-col">
        <div class="dash-card p-3 p-lg-4 h-100">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="text-muted small fw-semibold">Vault Saved</span>
                <div class="stat-icon-box bg-primary-subtle text-primary">
                    <span class="material-symbols-outlined">library_books</span>
                </div>
            </div>
            <h4 class="text-dark fw-bold mb-1">{{ $resourcesCount ?? 18 }} Files</h4>
            <div class="small text-muted mb-2">500L Past Qs & Slides</div>
            <a href="{{ route('student.vault') }}" class="small text-primary text-decoration-none fw-bold d-inline-flex align-items-center">
                Open Vault <i class="fa fa-chevron-right ms-1 extra-small"></i>
            </a>
        </div>
    </div>

    <div class="col-6 col-md-3 stat-card-col">
        <div class="dash-card p-3 p-lg-4 h-100">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="text-muted small fw-semibold">NUESA Elections</span>
                <div class="stat-icon-box bg-info-subtle text-info">
                    <span class="material-symbols-outlined">how_to_vote</span>
                </div>
            </div>
            <h4 class="text-dark fw-bold mb-1">ACCREDITED</h4>
            <div class="small text-info fw-semibold mb-2"><i class="fa fa-check-circle me-1"></i>Voting Poll Open</div>
            <a href="{{ route('student.elections') }}" class="small text-primary text-decoration-none fw-bold d-inline-flex align-items-center">
                Cast Vote <i class="fa fa-chevron-right ms-1 extra-small"></i>
            </a>
        </div>
    </div>
</div>

<!-- MAIN OVERVIEW SECTION -->
<div class="row g-4">
    <div class="col-lg-7">
        <div class="dash-card p-4 mb-4">
            <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-3">
                <h5 class="text-dark fw-bold mb-0 d-flex align-items-center">
                    <span class="material-symbols-outlined text-primary me-2">campaign</span> Faculty Announcements
                </h5>
                <span class="badge bg-primary-subtle text-primary px-3 py-1 rounded-pill">Election Special</span>
            </div>

            @forelse($recentNews as $news)
                <div class="mb-3 p-3 bg-light rounded-3 border-start border-4 border-success">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <a href="{{ route('news.show', $news->slug) }}" class="fw-bold text-dark text-decoration-none">{{ $news->title }}</a>
                        <span class="small text-muted">{{ $news->published_at ? $news->published_at->diffForHumans() : 'Active Now' }}</span>
                    </div>
                    <p class="small text-muted mb-0">{{ $news->summary }}</p>
                </div>
            @empty
                <div class="mb-3 p-3 bg-light rounded-3 border-start border-4 border-success">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="fw-bold text-dark">NUESA General Elections 2025/2026 Now Live</span>
                        <span class="small text-muted">Active Now</span>
                    </div>
                    <p class="small text-muted mb-0">Voting for Executive Council offices is now open. Accredited students can cast their votes online in the Elections tab.</p>
                </div>
            @endforelse
        </div>

        <div class="dash-card p-4">
            <h5 class="text-dark fw-bold mb-3 d-flex align-items-center border-bottom pb-3">
                <span class="material-symbols-outlined text-primary me-2">history</span> Recent Activity Log
            </h5>

            <div class="step-progress-item">
                <div class="step-icon bg-success-subtle text-success">
                    <i class="fa fa-check"></i>
                </div>
                <div class="fw-bold text-dark small">Annual Dues Payment Verified</div>
                <div class="small text-muted">2025/2026 Session Dues (₦3,500) successfully validated.</div>
                <div class="extra-small text-muted mt-1" style="font-size: 11px;">Recent • 02:45 PM</div>
            </div>

            <div class="step-progress-item">
                <div class="step-icon bg-primary-subtle text-primary">
                    <i class="fa fa-download"></i>
                </div>
                <div class="fw-bold text-dark small">Downloaded CPE 501 Lecture Slide</div>
                <div class="small text-muted">Saved 'Advanced Computer Architecture - Parallel Processing' PDF.</div>
                <div class="extra-small text-muted mt-1" style="font-size: 11px;">Recent • 11:15 AM</div>
            </div>

            <div class="step-progress-item">
                <div class="step-icon bg-info-subtle text-info">
                    <i class="fa fa-id-badge"></i>
                </div>
                <div class="fw-bold text-dark small">Digital NUESA ID Card Issued</div>
                <div class="small text-muted">System generated portrait badge for student portal account.</div>
                <div class="extra-small text-muted mt-1" style="font-size: 11px;">Recent • 09:30 AM</div>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="dash-card p-4 mb-4">
            <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-3">
                <h5 class="text-dark fw-bold mb-0 d-flex align-items-center">
                    <span class="material-symbols-outlined text-primary me-2">fact_check</span> Clearance Checklist
                </h5>
                <span class="badge bg-success-subtle text-success px-3 py-1 rounded-pill">100% Complete</span>
            </div>

            <div class="mb-3">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="small fw-semibold text-dark">Faculty Registration Dues</span>
                    <span class="badge bg-success text-white">Paid</span>
                </div>
                <div class="progress" style="height: 6px;">
                    <div class="progress-bar bg-success" style="width: 100%;"></div>
                </div>
            </div>

            <div class="mb-3">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="small fw-semibold text-dark">Departmental Association Dues</span>
                    <span class="badge bg-success text-white">Cleared</span>
                </div>
                <div class="progress" style="height: 6px;">
                    <div class="progress-bar bg-success" style="width: 100%;"></div>
                </div>
            </div>

            <div class="mb-3">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="small fw-semibold text-dark">Library & Digital ID Registration</span>
                    <span class="badge bg-success text-white">Verified</span>
                </div>
                <div class="progress" style="height: 6px;">
                    <div class="progress-bar bg-success" style="width: 100%;"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
