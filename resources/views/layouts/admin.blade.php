<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>@yield('title', 'NUESA Admin Portal - Executive Command Dashboard')</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="NUESA UNIMAID Admin Portal Executive Control" name="description">

    <!-- Favicon -->
    <link href="{{ asset('img/logos/NUESA logo.jpeg') }}" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600&family=Rubik:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Dashboard Stylesheet -->
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">

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

        .stat-card-icon {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
        }
    </style>
    @stack('styles')
</head>

<body>

    <!-- Mobile Drawer Backdrop -->
    <div class="sidebar-backdrop" id="sidebarBackdrop" onclick="toggleSidebar()"></div>

    <div class="app-wrapper">
        <!-- 1. LIGHT ADMIN SIDEBAR PARTIAL -->
        @include('layouts.partials.admin-sidebar')

        <!-- 2. MAIN WORKSPACE AREA -->
        <main class="app-main" id="appMain">
            <!-- APP TOPBAR HEADER PARTIAL -->
            @include('layouts.partials.admin-topbar')

            <!-- WORKSPACE CONTENT -->
            <div class="app-content">
                @yield('content')
            </div>

            <!-- DASHBOARD FOOTER PARTIAL -->
            @include('layouts.partials.admin-footer')
        </main>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3500,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        });

        @if(session('success'))
            Toast.fire({
                icon: 'success',
                title: @json(session('success'))
            });
        @endif

        @if(session('error'))
            Toast.fire({
                icon: 'error',
                title: @json(session('error'))
            });
        @endif

        @if($errors->any())
            Toast.fire({
                icon: 'warning',
                title: @json($errors->first())
            });
        @endif

        function toggleSidebar() {
            if ($(window).width() >= 992) {
                $('#appSidebar').toggleClass('collapsed');
                if ($('#appSidebar').hasClass('collapsed')) {
                    $('#collapseArrowIcon').removeClass('fa-chevron-left').addClass('fa-chevron-right');
                    $('#topbarCollapseBtn').attr('title', 'Expand Sidebar');
                } else {
                    $('#collapseArrowIcon').removeClass('fa-chevron-right').addClass('fa-chevron-left');
                    $('#topbarCollapseBtn').attr('title', 'Collapse Sidebar');
                }
            } else {
                $('#appSidebar').toggleClass('show');
                $('#sidebarBackdrop').toggleClass('show');
            }
        }
    </script>
    @stack('scripts')
</body>

</html>
