<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>@yield('title', 'NUESA UNIMAID Chapter - Faculty of Engineering')</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="@yield('meta_keywords', 'NUESA UNIMAID, Engineering Student Portal, Faculty of Engineering, University of Maiduguri')" name="keywords">
    <meta content="@yield('meta_description', 'Official portal of the Nigerian Universities Engineering Students Association (NUESA), University of Maiduguri Chapter.')" name="description">

    <!-- Favicon -->
    <link href="{{ asset('img/logos/NUESA logo.jpeg') }}" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600&family=Rubik:wght@500;600;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    @stack('styles')
</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;"></div>
    </div>
    <!-- Spinner End -->

    <!-- Topbar Start -->
    <div class="container-fluid bg-dark px-0">
        <div class="row g-0 d-none d-lg-flex">
            <div class="col-lg-7 ps-5 text-start">
                <div class="h-100 d-inline-flex align-items-center text-white small">
                    <span class="me-4"><i class="fa fa-university me-2 text-secondary"></i>Faculty of Engineering, University of Maiduguri</span>
                    <span class="me-4"><i class="fa fa-envelope me-2 text-secondary"></i>info@nuesaunimaid.org.ng</span>
                </div>
            </div>
            <div class="col-lg-5 text-end">
                <div class="h-100 topbar-right d-inline-flex align-items-center text-white py-2 px-5">
                    <span class="fs-6 fw-bold me-2"><i class="fa fa-phone-alt me-2"></i>NUESA Secretariat:</span>
                    <span class="fs-6 fw-bold">+234 800 NUESA UNIMAID</span>
                </div>
            </div>
        </div>
    </div>
    <!-- Topbar End -->

    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light sticky-top py-0 pe-3 pe-lg-5 shadow-sm">
        <a href="{{ route('home') }}" class="navbar-brand ps-4 me-0">
            <h2 class="text-white m-0 d-flex align-items-center">
                <img src="{{ asset('img/logos/NUESA logo.jpeg') }}" alt="NUESA UNIMAID Logo" class="me-2" style="height: 46px; width: 46px; border-radius: 50%; object-fit: cover; border: 2px solid #ffffff;">NUESA UNIMAID
            </h2>
        </a>
        <button type="button" class="navbar-toggler me-0" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="{{ route('home') }}" class="nav-item nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
                <a href="{{ route('about') }}" class="nav-item nav-link {{ request()->routeIs('about') ? 'active' : '' }}">About Us</a>
                <div class="nav-item dropdown">
                    <a href="{{ route('resources') }}" class="nav-link dropdown-toggle {{ request()->routeIs('resources') ? 'active' : '' }}" data-bs-toggle="dropdown">Resources</a>
                    <div class="dropdown-menu bg-light m-0 shadow">
                        <a href="{{ route('resources') }}" class="dropdown-item"><i class="fa fa-book text-primary me-2"></i>Course Vault & Past Questions</a>
                        <a href="{{ route('resources') }}#alumni" class="dropdown-item"><i class="fa fa-user-graduate text-primary me-2"></i>Alumni Network</a>
                        <a href="{{ route('resources') }}#archives" class="dropdown-item"><i class="fa fa-archive text-primary me-2"></i>Archives & Governance</a>
                    </div>
                </div>
                <div class="nav-item dropdown">
                    <a href="{{ route('gallery') }}" class="nav-link dropdown-toggle {{ request()->routeIs('gallery') || request()->routeIs('album') ? 'active' : '' }}" data-bs-toggle="dropdown">Gallery</a>
                    <div class="dropdown-menu bg-light m-0 shadow">
                        <a href="{{ route('gallery') }}" class="dropdown-item"><i class="fa fa-camera text-primary me-2"></i>Photo Gallery & Events</a>
                        <a href="{{ route('album') }}" class="dropdown-item"><i class="fa fa-id-card text-primary me-2"></i>Student Album & Profiles</a>
                    </div>
                </div>
                <a href="{{ route('news') }}" class="nav-item nav-link {{ request()->routeIs('news') ? 'active' : '' }}">News & Events</a>
                <a href="{{ route('team') }}" class="nav-item nav-link {{ request()->routeIs('team') ? 'active' : '' }}">Staffs</a>
                <a href="{{ route('contact') }}" class="nav-item nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">Contact</a>
            </div>
            @auth
                <a href="{{ route('student.dashboard') }}" class="btn btn-primary rounded-pill px-4 ms-3 d-none d-lg-inline-flex align-items-center shadow-sm fw-semibold"><i class="fa fa-tachometer-alt me-2"></i>Portal Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="btn btn-secondary rounded-pill px-4 ms-3 d-none d-lg-inline-flex align-items-center shadow-sm fw-semibold"><i class="fa fa-lock me-2"></i>Login</a>
            @endauth
        </div>
    </nav>
    <!-- Navbar End -->

    <!-- Main Dynamic Content -->
    @yield('content')

    <!-- Footer Start -->
    <div class="container-fluid bg-dark footer mt-5 py-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-white mb-4 d-flex align-items-center"><img src="{{ asset('img/logos/NUESA logo.jpeg') }}" alt="NUESA UNIMAID Logo" class="me-2" style="height: 32px; width: 32px; border-radius: 50%; object-fit: cover; border: 1.5px solid #008751;">NUESA UNIMAID</h5>
                    <p class="mb-2"><i class="fa fa-map-marker-alt me-3 text-secondary"></i>Faculty of Engineering Complex, University of Maiduguri, Borno State, Nigeria</p>
                    <p class="mb-2"><i class="fa fa-phone-alt me-3 text-secondary"></i>+234 800 NUESA UNIMAID</p>
                    <p class="mb-2"><i class="fa fa-envelope me-3 text-secondary"></i>info@nuesaunimaid.org.ng</p>
                    <div class="d-flex pt-3">
                        <a class="btn btn-square btn-primary rounded-circle me-2" href="#"><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-square btn-primary rounded-circle me-2" href="#"><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-square btn-primary rounded-circle me-2" href="#"><i class="fab fa-instagram"></i></a>
                        <a class="btn btn-square btn-primary rounded-circle me-2" href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-white mb-4">Quick Links</h5>
                    <a class="btn btn-link" href="{{ route('home') }}">Home Portal</a>
                    <a class="btn btn-link" href="{{ route('about') }}">About NUESA</a>
                    <a class="btn btn-link" href="{{ route('resources') }}">e-Resource Hub</a>
                    <a class="btn btn-link" href="{{ route('gallery') }}">Photo Gallery</a>
                    <a class="btn btn-link" href="{{ route('album') }}">Student Album</a>
                    <a class="btn btn-link" href="{{ route('team') }}">Leadership Officers</a>
                    <a class="btn btn-link" href="{{ route('contact') }}">FAQ & Contact</a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-white mb-4">Engineering Departments</h5>
                    <a class="btn btn-link" href="{{ route('about') }}#civil">Civil & Water Resources</a>
                    <a class="btn btn-link" href="{{ route('about') }}#electrical">Electrical & Electronics</a>
                    <a class="btn btn-link" href="{{ route('about') }}#mechanical">Mechanical Engineering</a>
                    <a class="btn btn-link" href="{{ route('about') }}#agricultural">Agricultural & Env.</a>
                    <a class="btn btn-link" href="{{ route('about') }}#computer">Computer Engineering</a>
                    <a class="btn btn-link" href="{{ route('about') }}#chemical">Chemical & Food Science</a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-white mb-4">NUESA Newsletter</h5>
                    <p class="small text-muted">Subscribe to receive exam timetables, workshop alerts, and NUESA announcements.</p>
                    <div class="position-relative w-100">
                        <input class="form-control bg-transparent w-100 py-3 ps-4 pe-5 text-white border-secondary" type="text" placeholder="Your student email">
                        <button type="button" class="btn btn-primary py-2 position-absolute top-0 end-0 mt-2 me-2">Subscribe</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->

    <!-- Copyright Start -->
    <div class="container-fluid copyright bg-dark py-4 border-top border-secondary">
        <div class="container text-center">
            <p class="mb-0">Copyright &copy; NUESA UNIMAID Chapter - University of Maiduguri. All Rights Reserved.</p>
        </div>
    </div>
    <!-- Copyright End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square rounded-circle back-to-top"><i class="bi bi-arrow-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('lib/wow/wow.min.js') }}"></script>
    <script src="{{ asset('lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('lib/counterup/counterup.min.js') }}"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('js/main.js') }}"></script>
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
    </script>

    @stack('scripts')
</body>


</html>
