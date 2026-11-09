@php
    $topUser = auth()->user() ?? \App\Models\User::with('department')->where('email', 'ismail.yusuf@eng.unimaid.edu.ng')->first() ?? \App\Models\User::with('department')->first();
    $avatarUrl = ($topUser && $topUser->profile_photo_path) ? \Illuminate\Support\Facades\Storage::url($topUser->profile_photo_path) : asset('img/team-1.jpg');
    $deptCode = ($topUser && $topUser->department) ? $topUser->department->code : 'CPE';

    $topNotifications = \App\Models\PortalNotification::where(function($q) use ($topUser) {
        $q->whereNull('user_id');
        if ($topUser) {
            $q->orWhere('user_id', $topUser->id);
        }
    })->latest()->take(6)->get();

    $unreadCount = $topNotifications->where('is_read', false)->count();
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
            <input type="text" class="form-control" placeholder="Search course vault, past questions, payment receipts, announcements...">
        </div>
    </div>

    <div class="d-flex align-items-center gap-3">
        <a href="{{ route('student.dues') }}" class="btn btn-secondary rounded-pill px-3 py-2 fw-bold shadow-sm d-none d-sm-inline-flex align-items-center btn-sm">
            <i class="fa fa-credit-card me-2"></i>Pay Dues
        </a>

        <!-- NOTIFICATION DROPDOWN -->
        <div class="dropdown">
            <button class="btn btn-light rounded-circle p-2 position-relative shadow-sm border" data-bs-toggle="dropdown" style="width: 42px; height: 42px;" id="notificationBellBtn">
                <i class="fa fa-bell text-muted"></i>
                @if($unreadCount > 0)
                    <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle" id="unreadDot"></span>
                @endif
            </button>
            <div class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-4 p-3 mt-2" style="width: 320px;">
                <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                    <h6 class="mb-0 fw-bold text-dark">Portal Notifications</h6>
                    <span class="badge bg-primary-subtle text-primary rounded-pill extra-small" id="unreadBadgeText">{{ $unreadCount }} Unread</span>
                </div>
                <div id="notificationsList">
                    @forelse($topNotifications as $notif)
                        <div class="mb-2 p-2 bg-light rounded-3 border-start border-3 {{ $notif->is_read ? 'border-secondary opacity-75' : 'border-primary' }}">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="fw-bold text-dark extra-small">{{ $notif->title }}</div>
                                <span class="text-muted" style="font-size: 9px;">{{ $notif->created_at ? $notif->created_at->diffForHumans(null, true) : 'Now' }}</span>
                            </div>
                            <div class="text-muted extra-small mt-1">{{ $notif->message }}</div>
                        </div>
                    @empty
                        <div class="text-center py-3 text-muted small">No notifications yet</div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- PROFILE DROPDOWN -->
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle p-1 rounded-pill bg-light border shadow-sm" data-bs-toggle="dropdown">
                <img src="{{ $avatarUrl }}" alt="Profile" class="rounded-circle me-2" style="width: 36px; height: 36px; object-fit: cover; border: 2px solid #008751;">
                <div class="text-start d-none d-md-block me-2">
                    <div class="fw-bold text-dark leading-none small">{{ $topUser->name ?? 'Ismail Yusuf' }}</div>
                    <div class="text-muted extra-small" style="font-size: 10px;">{{ $topUser->academic_class ?? '500L' }} {{ $deptCode }}</div>
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-4 p-2 mt-2" style="min-width: 220px;">
                <div class="p-3 bg-light rounded-3 mb-2">
                    <div class="fw-bold text-dark">{{ $topUser->name ?? 'Comr. Ismail Isah Yusuf' }}</div>
                    <div class="text-muted extra-small">Matric: {{ $topUser->matric_number ?? '18/04/01/0101' }}</div>
                </div>
                <a href="{{ route('student.profile') }}" class="dropdown-item rounded-2 py-2"><i class="fa fa-user me-2 text-primary"></i>Profile Settings</a>
                <a href="{{ route('student.digital-id') }}" class="dropdown-item rounded-2 py-2"><i class="fa fa-id-card me-2 text-primary"></i>Digital Student ID</a>
                <a href="{{ route('student.dues') }}" class="dropdown-item rounded-2 py-2"><i class="fa fa-file-invoice me-2 text-primary"></i>Dues & Receipts</a>
                <div class="dropdown-divider"></div>
                <form action="{{ route('student.logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="dropdown-item rounded-2 py-2 text-danger"><i class="fa fa-sign-out-alt me-2"></i>Sign Out</button>
                </form>
            </div>
        </div>
    </div>
</header>

<script>
    // Browser Notification & Sound Alert Manager
    document.addEventListener('DOMContentLoaded', function() {
        if ("Notification" in window && Notification.permission !== "granted" && Notification.permission !== "denied") {
            Notification.requestPermission();
        }
    });

    function playNotificationSound() {
        try {
            const ctx = new (window.AudioContext || window.webkitAudioContext)();
            const osc = ctx.createOscillator();
            const gain = ctx.createGain();
            osc.type = 'sine';
            osc.frequency.setValueAtTime(587.33, ctx.currentTime); // D5 note
            osc.frequency.exponentialRampToValueAtTime(880, ctx.currentTime + 0.15); // A5 note
            gain.gain.setValueAtTime(0.3, ctx.currentTime);
            gain.gain.exponentialRampToValueAtTime(0.01, ctx.currentTime + 0.3);
            osc.connect(gain);
            gain.connect(ctx.destination);
            osc.start();
            osc.stop(ctx.currentTime + 0.3);
        } catch(e) {
            console.log('Audio playback error', e);
        }
    }

    function triggerBrowserNotification(title, message) {
        playNotificationSound();
        if ("Notification" in window && Notification.permission === "granted") {
            new Notification(title, {
                body: message,
                icon: "{{ asset('img/logos/NUESA logo.jpeg') }}"
            });
        }
    }
</script>
