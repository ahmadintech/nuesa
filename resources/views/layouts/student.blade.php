<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>@yield('title', 'NUESA Student Portal Dashboard') - University of Maiduguri</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="NUESA UNIMAID Student Dashboard, Faculty of Engineering, University of Maiduguri" name="description">

    <!-- Favicon -->
    <link href="{{ asset('img/favicon.ico') }}" rel="icon">

    <!-- Google Web Fonts & Material Symbols -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600&family=Rubik:wght@500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet & Central Dashboard CSS -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
    @stack('styles')
</head>

<body>

    <!-- Mobile Drawer Backdrop -->
    <div class="sidebar-backdrop" id="sidebarBackdrop" onclick="toggleSidebar()"></div>

    <div class="app-wrapper">
        <!-- Sidebar Partial -->
        @include('layouts.partials.student-sidebar')

        <!-- Main Content Area -->
        <main class="app-main">
            <!-- Topbar Partial -->
            @include('layouts.partials.student-topbar')

            <!-- Page Specific Content -->
            <div class="app-content">
                @yield('content')
            </div>

            <!-- Footer Partial -->
            @include('layouts.partials.student-footer')
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
