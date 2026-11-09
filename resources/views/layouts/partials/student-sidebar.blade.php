<!-- 1. LIGHT APP SIDEBAR -->
<aside class="app-sidebar" id="appSidebar">
    <div>
        <div class="sidebar-header">
            <a href="{{ route('home') }}" class="d-flex align-items-center text-decoration-none">
                <img src="{{ asset('img/logos/NUESA logo.jpeg') }}" alt="NUESA UNIMAID" class="rounded-circle me-2" style="width: 40px; height: 40px; object-fit: cover; border: 2px solid #008751;">
                <div class="brand-text">
                    <div class="fw-bold text-dark leading-none" style="letter-spacing: -0.3px;">NUESA UNIMAID</div>
                    <span class="badge bg-success-subtle text-success px-2 py-0 rounded-pill extra-small fw-bold" style="font-size: 10px;">STUDENT PORTAL</span>
                </div>
            </a>
        </div>

        <div class="sidebar-menu">
            <div class="menu-category">Main Menu</div>
            <a href="{{ route('student.dashboard') }}" class="sidebar-link {{ request()->routeIs('student.dashboard') ? 'active' : '' }}" title="Overview">
                <span class="material-symbols-outlined">grid_view</span>
                <span class="sidebar-text">Overview</span>
            </a>
            <a href="{{ route('student.digital-id') }}" class="sidebar-link {{ request()->routeIs('student.digital-id') ? 'active' : '' }}" title="Digital Student ID">
                <span class="material-symbols-outlined">badge</span>
                <span class="sidebar-text">Digital Student ID</span>
            </a>
            <a href="{{ route('student.dues') }}" class="sidebar-link {{ request()->routeIs('student.dues') ? 'active' : '' }}" title="Dues & Receipts">
                <span class="material-symbols-outlined">receipt_long</span>
                <span class="sidebar-text">Dues & Receipts</span>
            </a>

            <div class="menu-category">Academics & Governance</div>
            <a href="{{ route('student.vault') }}" class="sidebar-link {{ request()->routeIs('student.vault') ? 'active' : '' }}" title="Course Vault">
                <span class="material-symbols-outlined">folder_open</span>
                <span class="sidebar-text">Course Vault</span>
            </a>
            <a href="{{ route('student.elections') }}" class="sidebar-link {{ request()->routeIs('student.elections') ? 'active' : '' }}" title="NUESA Elections">
                <span class="material-symbols-outlined">how_to_vote</span>
                <span class="sidebar-text">Elections & Voting</span>
            </a>

            <div class="menu-category">Account</div>
            <a href="{{ route('student.profile') }}" class="sidebar-link {{ request()->routeIs('student.profile') ? 'active' : '' }}" title="Profile Settings">
                <span class="material-symbols-outlined">person</span>
                <span class="sidebar-text">Profile Settings</span>
            </a>
        </div>
    </div>

    <div class="sidebar-footer">
        <a href="{{ route('home') }}" class="sidebar-link mb-2 text-warning" title="Public Website">
            <span class="material-symbols-outlined">language</span>
            <span class="sidebar-text">Public Website</span>
        </a>
        <a href="#" onclick="event.preventDefault(); document.getElementById('studentLogoutForm').submit();" class="sidebar-link text-danger mb-0" title="Logout Portal">
            <span class="material-symbols-outlined">logout</span>
            <span class="sidebar-text">Logout Portal</span>
        </a>
        <form id="studentLogoutForm" action="{{ route('student.logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>
</aside>
