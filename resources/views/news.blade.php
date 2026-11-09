@extends('layouts.frontend')

@section('title', 'News & Events Center - NUESA UNIMAID')

@section('content')
    <!-- Page Header Start -->
    <div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <h1 class="display-3 text-white animated slideInRight">News & Announcements</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb animated slideInRight mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page">News & Events</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- News Grid -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <p class="fw-medium text-uppercase text-primary mb-2">Faculty Bulletin</p>
                <h1 class="display-5 mb-4">Latest Faculty News & Timetables</h1>
                <p class="text-muted">Official announcements regarding exam schedules, NUESA elections, and Engineering Week.</p>
            </div>

            <div class="row g-4">
                @forelse($posts as $post)
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="card border-0 rounded-4 shadow-sm h-100 bg-white overflow-hidden">
                            <a href="{{ route('news.show', $post->slug) }}" class="position-relative overflow-hidden d-block" style="height: 240px;">
                                <img class="img-fluid w-100 h-100" src="{{ asset($post->featured_image ?? 'img/project-1.jpg') }}" alt="{{ $post->title }}" style="object-fit: cover;">
                                <span class="badge bg-primary position-absolute top-0 start-0 m-3 px-3 py-2 rounded-pill shadow-sm">{{ $post->category }}</span>
                            </a>
                            <div class="card-body p-4 d-flex flex-column">
                                <div class="text-muted small mb-2"><i class="fa fa-calendar-alt text-primary me-2"></i>{{ $post->published_at ? $post->published_at->format('M d, Y') : now()->format('M d, Y') }}</div>
                                <h5 class="card-title fw-bold text-dark mb-3"><a href="{{ route('news.show', $post->slug) }}" class="text-dark text-decoration-none">{{ $post->title }}</a></h5>
                                <p class="card-text text-muted small flex-grow-1 mb-4">{{ Str::limit($post->summary ?? $post->body, 120) }}</p>
                                <div>
                                    <a href="{{ route('news.show', $post->slug) }}" class="btn btn-outline-primary rounded-pill px-4 py-2 btn-sm fw-semibold">Read Announcement</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center text-muted py-5">No news posts published yet.</div>
                @endforelse
            </div>

            <div class="d-flex justify-content-center mt-5">
                {{ $posts->links() }}
            </div>
        </div>
    </div>
@endsection
