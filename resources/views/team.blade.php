@extends('layouts.frontend')

@section('title', 'Faculty Staff Directory & Leadership - NUESA UNIMAID')

@section('content')
    <!-- Page Header Start -->
    <div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <h1 class="display-3 text-white animated slideInRight">Faculty Staff Directory</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb animated slideInRight mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page">Staff Directory</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Staff Directory Grid -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <p class="fw-medium text-uppercase text-primary mb-2">Faculty Leadership & Lecturers</p>
                <h1 class="display-5 mb-4">Academic & Administrative Staff</h1>
                <p class="text-muted">Meet the distinguished deans, HODs, lecturers, and advisers guiding the Faculty of Engineering.</p>
            </div>

            <div class="row g-4">
                @forelse($staff as $member)
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="card border-0 rounded-4 shadow-sm h-100 bg-white p-4">
                            <div class="text-center mb-3">
                                <img class="rounded-circle shadow img-fluid" src="{{ asset($member->photo_path ?? 'img/team-1.jpg') }}" alt="{{ $member->name }}" style="width: 120px; height: 120px; object-fit: cover;">
                            </div>
                            <div class="text-center flex-grow-1">
                                <h5 class="fw-bold text-dark mb-1">{{ $member->name }}</h5>
                                <p class="text-primary fw-medium small mb-2"><i class="fa fa-graduation-cap me-1"></i>{{ $member->designation }}</p>
                                <span class="badge bg-light text-dark rounded-pill px-3 py-2 extra-small mb-3 border">
                                    <i class="fa fa-building me-1 text-primary"></i>{{ $member->department->name ?? 'Faculty Office' }}
                                </span>
                                <div class="bg-light p-3 rounded-3 text-start small mt-2">
                                    <div class="mb-1"><i class="fa fa-door-open me-2 text-primary"></i><strong>Office:</strong> {{ $member->office_number ?? 'Faculty Room' }}</div>
                                    <div><i class="fa fa-envelope me-2 text-primary"></i><strong>Email:</strong> {{ $member->email ?? 'staff@unimaid.edu.ng' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center text-muted">No staff members currently published.</div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
