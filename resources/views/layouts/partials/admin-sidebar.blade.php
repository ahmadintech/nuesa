<!-- LIGHT ADMIN SIDEBAR -->
<aside class="app-sidebar" id="appSidebar">
    <div>
        <div class="sidebar-header">
            <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center text-decoration-none">
                <img src="{{ asset('img/logos/NUESA logo.jpeg') }}" alt="NUESA UNIMAID Admin" class="rounded-circle me-2" style="width: 40px; height: 40px; object-fit: cover; border: 2px solid #008751;">
                <div class="brand-text">
                    <div class="fw-bold text-dark leading-none" style="letter-spacing: -0.3px;">NUESA ADMIN</div>
                </div>
            </a>
        </div>

        <div class="sidebar-menu">
            <div class="menu-category">Command Center</div>
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" title="Admin Overview">
                <span class="material-symbols-outlined">dashboard</span>
                <span class="sidebar-text">Overview</span>
            </a>
@can('manage-students')
            <a href="{{ route('admin.users') }}" class="sidebar-link {{ request()->routeIs('admin.users') ? 'active' : '' }}" title="Students Directory & Control">
                <span class="material-symbols-outlined">manage_accounts</span>
                <span class="sidebar-text">Students</span>
            </a>
@endcan

            <div class="menu-category">Governance & Financials</div>
@can('manage-payments')
            <a href="{{ route('admin.payments') }}" class="sidebar-link {{ request()->routeIs('admin.payments') ? 'active' : '' }}" title="Payments & Dues Control">
                <span class="material-symbols-outlined">payments</span>
                <span class="sidebar-text">Payments</span>
            </a>
@endcan
@can('manage-elections')
            <a href="{{ route('admin.elections') }}" class="sidebar-link {{ request()->routeIs('admin.elections*') ? 'active' : '' }}" title="Elections Control Panel">
                <span class="material-symbols-outlined">how_to_vote</span>
                <span class="sidebar-text">Elections</span>
            </a>
@endcan
@can('manage-posts')
            <a href="{{ route('admin.posts') }}" class="sidebar-link {{ request()->routeIs('admin.posts*') ? 'active' : '' }}" title="News & Announcements">
                <span class="material-symbols-outlined">newspaper</span>
                <span class="sidebar-text">News</span>
            </a>
@endcan
@can('send-notifications')
            <a href="{{ route('admin.notifications.index') }}" class="sidebar-link {{ request()->routeIs('admin.notifications.*') ? 'active' : '' }}" title="Broadcast Notifications">
                <span class="material-symbols-outlined">campaign</span>
                <span class="sidebar-text">Notifications</span>
            </a>
@endcan

            <div class="menu-category">Content & Media</div>
@can('manage-settings')
            <a href="{{ route('admin.about') }}" class="sidebar-link {{ request()->routeIs('admin.about') ? 'active' : '' }}" title="Exco Council Members">
                <span class="material-symbols-outlined">info</span>
                <span class="sidebar-text">About & Excos</span>
            </a>
@endcan
@can('manage-gallery')
            <a href="{{ route('admin.gallery') }}" class="sidebar-link {{ request()->routeIs('admin.gallery') ? 'active' : '' }}" title="Faculty Gallery & Events">
                <span class="material-symbols-outlined">photo_library</span>
                <span class="sidebar-text">Gallery</span>
            </a>
@endcan
@can('manage-gallery')
            <a href="{{ route('admin.album') }}" class="sidebar-link {{ request()->routeIs('admin.album') ? 'active' : '' }}" title="Graduating Student Album">
                <span class="material-symbols-outlined">id_card</span>
                <span class="sidebar-text">Student Album</span>
            </a>
@endcan
@can('manage-vault')
            <a href="{{ route('admin.resources') }}" class="sidebar-link {{ request()->routeIs('admin.resources') ? 'active' : '' }}" title="Academic Resources & Downloads">
                <span class="material-symbols-outlined">folder_zip</span>
                <span class="sidebar-text">Resources</span>
            </a>
@endcan
@can('manage-settings')
            <a href="{{ route('admin.staff') }}" class="sidebar-link {{ request()->routeIs('admin.staff') ? 'active' : '' }}" title="Staff Directory">
                <span class="material-symbols-outlined">badge</span>
                <span class="sidebar-text">Staff Directory</span>
            </a>
@endcan

            <div class="menu-category">System Configuration</div>
@can('manage-settings')
            <a href="{{ route('admin.settings') }}" class="sidebar-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}" title="Settings">
                <span class="material-symbols-outlined">settings</span>
                <span class="sidebar-text">Settings</span>
            </a>
@endcan
        </div>
    </div>

    <div class="sidebar-footer">
        <form action="{{ route('admin.logout') }}" method="POST" id="adminLogoutForm" class="d-inline">
            @csrf
            <a href="#" onclick="event.preventDefault(); document.getElementById('adminLogoutForm').submit();" class="sidebar-link text-danger mb-0" title="Logout Admin">
                <span class="material-symbols-outlined">logout</span>
                <span class="sidebar-text">Logout Executive</span>
            </a>
        </form>
    </div>
</aside>
