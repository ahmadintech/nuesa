@extends('layouts.frontend')

@section('title', $post->title . ' - NUESA UNIMAID')

@section('content')
    <!-- Page Header Start -->
    <div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <h1 class="display-4 text-white mb-3 animated slideInDown">Article & Announcement Details</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb text-uppercase mb-0">
                    <li class="breadcrumb-item"><a class="text-white" href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a class="text-white" href="{{ route('news') }}">News & Events</a></li>
                    <li class="breadcrumb-item text-primary active" aria-current="page">Article Details</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- News Details Section Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5">
                <!-- Left Column: Article Content (8 cols) -->
                <div class="col-lg-8 wow fadeInUp" data-wow-delay="0.1s">
                    <span class="badge bg-primary px-3 py-2 rounded-pill mb-3">{{ $post->category }}</span>
                    <h1 class="display-6 text-dark fw-bold mb-3">{{ $post->title }}</h1>
                    
                    <!-- Metadata Header -->
                    <div class="d-flex flex-wrap align-items-center text-muted border-top border-bottom py-3 mb-4 gap-4 small">
                        <span class="d-flex align-items-center"><span class="material-symbols-outlined text-primary me-1">calendar_today</span> {{ $post->published_at ? $post->published_at->format('M d, Y') : now()->format('M d, Y') }}</span>
                        <span class="d-flex align-items-center"><span class="material-symbols-outlined text-primary me-1">person</span> NUESA Executive Council</span>
                        <span class="d-flex align-items-center"><span class="material-symbols-outlined text-primary me-1">schedule</span> 4 min read</span>
                        <span class="d-flex align-items-center"><span class="material-symbols-outlined text-primary me-1">visibility</span> 1,240 Views</span>
                    </div>

                    <!-- Featured Image -->
                    <div class="position-relative mb-4 overflow-hidden shadow-sm" style="border-radius: 24px;">
                        <img src="{{ asset($post->featured_image ?? 'img/project-1.jpg') }}" alt="{{ $post->title }}" class="img-fluid w-100" style="max-height: 450px; object-fit: cover;">
                    </div>

                    <!-- Article Body -->
                    <div class="article-content lh-lg text-secondary mb-5">
                        @if($post->summary)
                            <p class="fs-5 text-dark fw-medium mb-4">{{ $post->summary }}</p>
                        @endif

                        {!! nl2br(e($post->body)) !!}

                        <!-- Highlights Callout Card -->
                        <div class="p-4 bg-light rounded-4 border-start border-primary border-4 my-4">
                            <h5 class="fw-bold text-dark mb-2"><i class="fa fa-star text-warning me-2"></i>Official Announcement Highlights:</h5>
                            <ul class="mb-0 ps-3 text-dark">
                                <li class="mb-1"><strong>Verification & Accreditation:</strong> Authorized by NUESA UNIMAID Secretariat.</li>
                                <li class="mb-1"><strong>Target Audience:</strong> Engineering Students across all 8 Departments.</li>
                                <li class="mb-0"><strong>Inquiries:</strong> Contact class representatives or visit the NUESA Secretariat.</li>
                            </ul>
                        </div>

                        <!-- Quote Card -->
                        <blockquote class="blockquote p-4 bg-primary text-white rounded-4 shadow-sm my-4">
                            <p class="mb-2 fs-5 fst-italic">"Fostering excellence, innovation, and unity across all engineering disciplines at the University of Maiduguri."</p>
                            <footer class="blockquote-footer text-white-50 mt-1 fw-semibold">Executive President, NUESA UNIMAID Chapter</footer>
                        </blockquote>
                    </div>

                    <!-- Social Share & Tags -->
                    <div class="d-flex flex-wrap align-items-center justify-content-between border-top border-bottom py-3 mb-5 gap-3">
                        <div class="d-flex align-items-center gap-2">
                            <span class="fw-bold text-dark me-2">Share Article:</span>
                            <a href="#" class="btn btn-sm-square btn-outline-primary rounded-circle"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="btn btn-sm-square btn-outline-primary rounded-circle"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="btn btn-sm-square btn-outline-primary rounded-circle"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#" class="btn btn-sm-square btn-outline-success rounded-circle"><i class="fab fa-whatsapp"></i></a>
                        </div>
                        <div>
                            <span class="badge bg-light text-dark me-1">#NUESAUNIMAID</span>
                            <span class="badge bg-light text-dark">#FacultyOfEngineering</span>
                        </div>
                    </div>

                    <!-- Author Box -->
                    <div class="d-flex align-items-center bg-light p-4 rounded-4 shadow-sm mb-5" style="border-radius: 20px !important;">
                        <img src="{{ asset('img/logos/NUESA logo.jpeg') }}" alt="NUESA Secretariat" class="rounded-circle me-4 shadow-sm" style="width: 80px; height: 80px; object-fit: cover;">
                        <div>
                            <h5 class="fw-bold text-dark mb-1">NUESA Media & Information Secretariat</h5>
                            <p class="small text-muted mb-0">Official communications wing of the Nigerian Universities Engineering Students Association (NUESA), University of Maiduguri Chapter.</p>
                        </div>
                    </div>

                    <!-- Related Articles -->
                    @if(count($relatedPosts) > 0)
                        <h4 class="fw-bold text-dark mb-4">Related Announcements & Events</h4>
                        <div class="row g-4">
                            @foreach($relatedPosts as $rel)
                                <div class="col-md-6">
                                    <div class="card border-0 rounded-4 shadow-sm h-100 bg-white overflow-hidden" style="border-radius: 20px !important;">
                                        <img src="{{ asset($rel->featured_image ?? 'img/project-4.jpg') }}" class="card-img-top" alt="{{ $rel->title }}" style="height: 200px; object-fit: cover;">
                                        <div class="card-body p-4">
                                            <span class="badge bg-secondary text-dark mb-2">{{ $rel->category }}</span>
                                            <h6 class="fw-bold text-dark"><a href="{{ route('news.show', $rel->slug) }}" class="text-dark text-decoration-none">{{ $rel->title }}</a></h6>
                                            <small class="text-muted"><i class="far fa-calendar-alt me-1"></i>{{ $rel->published_at ? $rel->published_at->format('M d, Y') : now()->format('M d, Y') }}</small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Right Column: Sidebar (4 cols) -->
                <div class="col-lg-4 wow fadeInUp" data-wow-delay="0.2s">
                    <!-- Quick Action Widget -->
                    <div class="bg-light p-4 rounded-4 shadow-sm mb-4" style="border-radius: 20px !important;">
                        <h5 class="fw-bold text-dark mb-3"><i class="fa fa-ticket-alt text-primary me-2"></i>Student Portal Action</h5>
                        <p class="small text-muted mb-3">Pay departmental dues, download clearance certificates, and access past question vaults.</p>
                        <a href="{{ route('login') }}" class="btn btn-primary rounded-pill w-100 py-2 fw-semibold shadow-sm">Portal Student Login &rarr;</a>
                    </div>

                    <!-- Categories Widget -->
                    <div class="bg-light p-4 rounded-4 shadow-sm mb-4" style="border-radius: 20px !important;">
                        <h5 class="fw-bold text-dark mb-3">Bulletin Categories</h5>
                        <div class="d-flex flex-column gap-2">
                            <a href="{{ route('news') }}" class="d-flex justify-content-between align-items-center text-dark text-decoration-none py-2 border-bottom">
                                <span><i class="fa fa-tag text-primary me-2"></i>Announcements</span>
                                <span class="badge bg-primary rounded-pill">12</span>
                            </a>
                            <a href="{{ route('news') }}" class="d-flex justify-content-between align-items-center text-dark text-decoration-none py-2 border-bottom">
                                <span><i class="fa fa-calendar-alt text-primary me-2"></i>Upcoming Events</span>
                                <span class="badge bg-primary rounded-pill">8</span>
                            </a>
                            <a href="{{ route('news') }}" class="d-flex justify-content-between align-items-center text-dark text-decoration-none py-2 border-bottom">
                                <span><i class="fa fa-graduation-cap text-primary me-2"></i>Academic & SIWES</span>
                                <span class="badge bg-primary rounded-pill">15</span>
                            </a>
                            <a href="{{ route('news') }}" class="d-flex justify-content-between align-items-center text-dark text-decoration-none py-2 border-bottom">
                                <span><i class="fa fa-vote-yea text-primary me-2"></i>Elections & Governance</span>
                                <span class="badge bg-primary rounded-pill">5</span>
                            </a>
                        </div>
                    </div>

                    <!-- Recent Announcements Widget -->
                    @if(count($recentPosts) > 0)
                        <div class="bg-light p-4 rounded-4 shadow-sm mb-4" style="border-radius: 20px !important;">
                            <h5 class="fw-bold text-dark mb-3">Recent Posts</h5>
                            <div class="d-flex flex-column gap-3">
                                @foreach($recentPosts as $rec)
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset($rec->featured_image ?? 'img/project-1.jpg') }}" alt="{{ $rec->title }}" class="rounded-3 me-3" style="width: 70px; height: 70px; object-fit: cover;">
                                        <div>
                                            <small class="text-primary fw-semibold"><i class="far fa-calendar-alt me-1"></i>{{ $rec->published_at ? $rec->published_at->format('M d, Y') : now()->format('M d, Y') }}</small>
                                            <h6 class="mb-0 text-dark small fw-bold"><a href="{{ route('news.show', $rec->slug) }}" class="text-dark text-decoration-none">{{ $rec->title }}</a></h6>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- News Details Section End -->
@endsection
