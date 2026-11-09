@extends('layouts.frontend')

@section('title', 'About NUESA UNIMAID - Executive Council & Departments')

@section('content')
    <!-- Page Header Start -->
    <div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <h1 class="display-3 text-white animated slideInRight">About NUESA UNIMAID</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb animated slideInRight mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page">About Us</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- 1. PRESIDENT'S WELCOME ADDRESS FEATURE SECTION -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5 align-items-center">
                <!-- Left Column: Large High-Res Avatar Layout -->
                <div class="col-lg-5 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="position-relative p-2">
                        <img class="img-fluid president-avatar-frame shadow-lg w-100" src="{{ asset($president->photo_path ?? $settings['about_president_photo'] ?? 'img/team-1.jpg') }}" alt="{{ $president->name ?? $settings['about_president_name'] ?? 'NUESA President' }}">
                        <div class="bg-primary text-white p-3 rounded shadow position-absolute bottom-0 start-50 translate-middle-x mb-n3 text-center w-75">
                            <h6 class="text-white mb-0 fw-bold">{{ $president->name ?? $settings['about_president_name'] ?? 'Comr. Ismail Isah Yusuf' }}</h6>
                            <small class="text-white-50">{{ $settings['about_president_title'] ?? ($president ? 'NUESA ' . $president->office_position . ' (' . ($president->academic_session ?? '2025/2026') . ' Session)' : 'NUESA President (2025/2026 Session)') }}</small>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Welcome Address Content -->
                <div class="col-lg-7 wow fadeIn" data-wow-delay="0.4s">
                    <p class="fw-medium text-uppercase text-primary mb-2"><i class="fa fa-quote-left me-2"></i>President's Address</p>
                    <h1 class="display-5 mb-4">Welcome to NUESA UNIMAID Chapter</h1>
                    <p class="fs-5 text-dark fw-medium mb-3">"{{ $settings['about_president_quote'] ?? 'Building world-class engineers through innovation, academic integrity, and dedicated student advocacy.' }}"</p>
                    <p class="text-muted mb-4">
                        {{ $settings['about_president_speech'] ?? 'On behalf of the Executive Council and the entire engineering student body of the University of Maiduguri, I warmly welcome you to our official web portal. Founded over 25 years ago, NUESA UNIMAID has grown into a vibrant umbrella body uniting over 3,400 students across accredited engineering departments.' }}
                    </p>

                    <div class="row g-3">
                        <div class="col-sm-6">
                            <div class="p-3 border-start border-4 border-primary bg-light rounded">
                                <h6 class="mb-1 text-primary"><i class="fa fa-bullseye me-2"></i>Our Mission</h6>
                                <p class="small mb-0 text-muted">{{ $settings['about_mission'] ?? 'Empower students through technical mentorship, academic past questions, and career placement support.' }}</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="p-3 border-start border-4 border-secondary bg-light rounded">
                                <h6 class="mb-1 text-secondary"><i class="fa fa-eye me-2"></i>Our Vision</h6>
                                <p class="small mb-0 text-muted">{{ $settings['about_vision'] ?? 'To produce industry-ready engineering graduates capable of solving complex national challenges.' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. EXECUTIVE COUNCIL (EXCO GRID) SECTION -->
    <div class="container-fluid py-5 bg-light">
        <div class="container">
            <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <p class="fw-medium text-uppercase text-primary mb-2">Student Leadership</p>
                <h1 class="display-5 mb-4">NUESA Executive Council (Excos)</h1>
                <p class="text-muted">Dedicated student leaders serving the 8 departments in the 2025/2026 Academic Session.</p>
            </div>

            <div class="row g-4">
                @forelse($excos as $exco)
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="team-item rounded overflow-hidden bg-white shadow-sm h-100">
                            <img class="img-fluid w-100" src="{{ asset($exco->photo_path ?? 'img/project-1.jpg') }}" alt="{{ $exco->name }}" style="height: 360px; object-fit: cover;">
                            <div class="d-flex">
                                <div class="flex-shrink-0 btn-square bg-primary" style="width: 90px; height: 90px;">
                                    <i class="fa fa-2x fa-user-tie text-white"></i>
                                </div>
                                <div class="position-relative overflow-hidden bg-light d-flex flex-column justify-content-center w-100 ps-4 py-3">
                                    <h5 class="mb-0">{{ $exco->name }}</h5>
                                    <span class="text-primary fw-medium small mb-1">{{ $exco->office_position }}</span>
                                    <small class="text-muted">{{ $exco->department->name ?? 'Engineering' }}</small>
                                    <div class="team-social mt-2">
                                        @if($exco->twitter_handle)
                                            <a class="btn btn-square btn-dark rounded-circle me-1" href="#"><i class="fab fa-twitter"></i></a>
                                        @endif
                                        @if($exco->linkedin_url)
                                            <a class="btn btn-square btn-dark rounded-circle me-1" href="{{ $exco->linkedin_url }}"><i class="fab fa-linkedin-in"></i></a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center text-muted">No executive council members published yet.</div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- 3. ABOUT NUESA OVERVIEW SECTION -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="p-4 p-md-5 rounded-4 bg-light shadow-sm text-center mx-auto" style="max-width: 900px; border: 1px solid #e2e8f0;">
                <p class="fw-medium text-uppercase text-primary mb-2"><i class="fa fa-info-circle me-2"></i>About NUESA UNIMAID</p>
                <h2 class="fw-bold text-dark mb-3">Empowering Engineering Excellence</h2>
                <p class="text-muted leading-relaxed mb-0 fs-6">
                    {{ $settings['about_overview'] ?? 'The National Association of Engineering Students (NUESA), University of Maiduguri Chapter, represents over 3,000 undergraduate and postgraduate engineering scholars across 8 accredited departments. NUESA serves as the unified voice for student advocacy, professional development, and technological empowerment.' }}
                </p>
            </div>
        </div>
    </div>

    <!-- Departmental Breakdown Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <p class="fw-medium text-uppercase text-primary mb-2">Faculty Disciplines</p>
                <h1 class="display-5 mb-4">Accredited Engineering Departments</h1>
            </div>
            <div class="row g-4">
                @foreach($departments as $dept)
                    <div class="col-md-6 col-lg-3 wow fadeInUp" data-wow-delay="0.1s" id="{{ $dept->slug }}">
                        <div class="p-4 border-0 rounded-4 bg-white shadow-sm h-100 text-center d-flex flex-column align-items-center justify-content-center p-4" style="border-radius: 20px !important;">
                            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                                <i class="fa fa-university fa-2x text-primary"></i>
                            </div>
                            <h5 class="fw-bold text-dark mb-0 fs-6">{{ $dept->name }}</h5>
                            <span class="badge bg-primary rounded-pill px-3 py-1 mt-2">{{ $dept->code }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
