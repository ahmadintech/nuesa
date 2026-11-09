@extends('layouts.frontend')

@section('title', 'Photo Gallery & Events - NUESA UNIMAID Chapter')

@section('content')
    <!-- Page Header Start -->
    <div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <h1 class="display-3 text-white animated slideInRight">Faculty Photo Gallery</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb animated slideInRight mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page">Photo Gallery</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- GALLERY SECTION -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <p class="fw-medium text-uppercase text-primary mb-2"><i class="fa fa-camera me-2"></i>Campus Life & Events</p>
                <h1 class="display-5 mb-4">Faculty Engineering Gallery</h1>
                <p class="text-muted">Highlights from Engineering Week, departmental laboratory experiments, cultural carnivals, and industrial field trips.</p>
            </div>

            <!-- Dynamic Category Filter Buttons -->
            <div class="d-flex flex-wrap gap-2 justify-content-center mb-5 wow fadeInUp" data-wow-delay="0.2s">
                <button class="btn btn-primary gallery-filter-btn active rounded-pill px-3 py-2 shadow-sm" data-filter="all"><i class="fa fa-th-large me-1"></i>All Gallery</button>
                <button class="btn btn-outline-primary gallery-filter-btn rounded-pill px-3 py-2 shadow-sm" data-filter="civil">Civil Eng.</button>
                <button class="btn btn-outline-primary gallery-filter-btn rounded-pill px-3 py-2 shadow-sm" data-filter="electrical">Electrical Eng.</button>
                <button class="btn btn-outline-primary gallery-filter-btn rounded-pill px-3 py-2 shadow-sm" data-filter="mechanical">Mechanical Eng.</button>
                <button class="btn btn-outline-primary gallery-filter-btn rounded-pill px-3 py-2 shadow-sm" data-filter="computer">Computer Eng.</button>
                <button class="btn btn-outline-secondary gallery-filter-btn rounded-pill px-3 py-2 shadow-sm" data-filter="events">Engineering Week</button>
                <button class="btn btn-outline-secondary gallery-filter-btn rounded-pill px-3 py-2 shadow-sm" data-filter="campus">Campus Facilities</button>
            </div>

            <!-- Gallery Cards Grid -->
            <div class="row g-4" id="galleryContainer">
                @forelse($items as $index => $item)
                    <div class="col-lg-4 col-md-6 gallery-item-col {{ $item->category }} wow fadeInUp" data-wow-delay="{{ 0.1 * (($index % 3) + 1) }}s">
                        <div class="card border-0 rounded-4 shadow-sm overflow-hidden h-100 bg-white" style="border-radius: 20px !important;">
                            <div class="position-relative overflow-hidden" style="height: 240px;">
                                <img class="img-fluid w-100 h-100" src="{{ asset($item->image_path) }}" alt="{{ $item->title }}" style="object-fit: cover;">
                                <span class="badge bg-primary position-absolute top-0 start-0 m-3 px-3 py-2 rounded-pill shadow-sm text-uppercase" style="font-size: 0.75rem;">
                                    {{ $item->department->code ?? Str::headline($item->category) }}
                                </span>
                            </div>
                            <div class="card-body p-4 text-center">
                                <h5 class="fw-bold text-dark mb-2">{{ $item->title }}</h5>
                                <p class="text-muted small mb-0"><i class="fa fa-university text-primary me-2"></i>{{ $item->department->name ?? 'Faculty of Engineering' }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center text-muted py-5">
                        <i class="fa fa-images fa-3x text-muted mb-3 d-block"></i>
                        <h5>No gallery images uploaded yet.</h5>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.gallery-filter-btn').on('click', function() {
                $('.gallery-filter-btn').removeClass('btn-primary active').addClass('btn-outline-primary');
                $(this).removeClass('btn-outline-primary btn-outline-secondary').addClass('btn-primary active');
                
                var filter = $(this).attr('data-filter');
                if (filter === 'all') {
                    $('.gallery-item-col').fadeIn(300);
                } else {
                    $('.gallery-item-col').not('.' + filter).fadeOut(200);
                    $('.gallery-item-col.' + filter).fadeIn(300);
                }
            });
        });
    </script>
@endpush
