@php
    $adminTopUser = auth()->user();
    $adminNotifications = \App\Models\PortalNotification::latest()->take(5)->get();
    $adminUnreadCount = $adminNotifications->where('is_read', false)->count();
@endphp

<!-- APP TOPBAR HEADER -->
<header class="app-topbar">
    <div class="d-flex align-items-center flex-grow-1 me-3">
        <button class="btn btn-light me-3 rounded-circle p-2 shadow-sm border d-none d-lg-flex align-items-center justify-content-center" id="topbarCollapseBtn" onclick="toggleSidebar()" title="Collapse Sidebar" style="width: 42px; height: 42px;">
            <i class="fa fa-chevron-left text-muted fs-6" id="collapseArrowIcon"></i>
        </button>

        <button class="btn btn-light me-3 d-lg-none rounded-circle p-2 shadow-sm border" onclick="toggleSidebar()" title="Toggle Menu" style="width: 42px; height: 42px;">
            <i class="fa fa-bars text-dark fs-5"></i>
        </button>

        <div class="topbar-search d-none d-md-block flex-grow-1">
            <span class="material-symbols-outlined search-icon">search</span>
            <input type="text" class="form-control" placeholder="Search student records, matric numbers, election candidates, portal settings...">
        </div>
    </div>

    <div class="d-flex align-items-center gap-3">
        <!-- Notification Bell Dropdown -->
        <div class="dropdown">
            <button class="btn btn-light rounded-circle p-2 shadow-sm border position-relative" data-bs-toggle="dropdown" title="Notifications" style="width: 42px; height: 42px;">
                <span class="material-symbols-outlined text-dark">notifications</span>
                @if($adminUnreadCount > 0)
                    <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle">
                        <span class="visually-hidden">New alerts</span>
                    </span>
                @endif
            </button>
            <div class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-4 p-3 mt-2" style="width: 320px;">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <h6 class="fw-bold text-dark mb-0">Executive Alerts</h6>
                    <span class="badge bg-success-subtle text-success rounded-pill">{{ $adminUnreadCount }} New</span>
                </div>
                @forelse($adminNotifications as $notif)
                    <div class="mb-2 p-2 bg-light rounded-3">
                        <div class="fw-bold text-dark extra-small">{{ $notif->title }}</div>
                        <div class="text-muted extra-small">{{ Str::limit($notif->message, 60) }}</div>
                    </div>
                @empty
                    <div class="p-2 bg-light rounded-3 text-center text-muted extra-small">No new executive alerts</div>
                @endforelse
            </div>
        </div>

        <!-- Admin Profile Dropdown -->
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle p-1 rounded-pill bg-light border shadow-sm" data-bs-toggle="dropdown">
                <img src="{{ asset('img/logos/NUESA logo.jpeg') }}" alt="Admin Executive" class="rounded-circle me-2" style="width: 36px; height: 36px; object-fit: cover; border: 2px solid #008751;">
                <div class="text-start d-none d-md-block me-2">
                    <div class="fw-bold text-dark leading-none small">{{ $adminTopUser->name ?? 'Engr. Admin Yusuf' }}</div>
                    <div class="text-muted extra-small" style="font-size: 10px;">Executive Admin</div>
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-4 p-2 mt-2" style="min-width: 220px;">
                <div class="p-3 bg-light rounded-3 mb-2">
                    <div class="fw-bold text-dark">{{ $adminTopUser->name ?? 'Engr. Admin Yusuf' }}</div>
                    <div class="extra-small text-muted">{{ $adminTopUser->email ?? 'admin@nuesaunimaid.org.ng' }}</div>
                    <span class="badge bg-success-subtle text-success rounded-pill px-2 py-1 mt-1 extra-small">Executive Credentials</span>
                </div>
                <a href="{{ route('admin.settings') }}" class="dropdown-item rounded-2 py-2"><i class="fa fa-user-cog text-primary me-2"></i>Admin Settings</a>
                <hr class="dropdown-divider">
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="dropdown-item rounded-2 py-2 text-danger border-0 bg-transparent w-100 text-start">
                        <i class="fa fa-sign-out-alt me-2"></i>Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>
