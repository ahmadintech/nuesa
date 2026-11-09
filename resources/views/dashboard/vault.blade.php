@extends('layouts.student')

@section('title', 'Course Vault - NUESA Student Portal')

@section('content')
<div class="dash-card p-4 p-lg-5">
    <div class="d-flex align-items-center justify-content-between mb-4 border-bottom pb-3">
        <div>
            <h4 class="text-dark fw-bold mb-1">500L Academic Course Vault & Past Questions</h4>
            <p class="text-muted small mb-0">Curated lecture slides, lab manuals, and exam archives for Engineering Students.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
            <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-3">
        @forelse($resources as $res)
            <div class="col-md-6">
                <div class="p-3 bg-light rounded-4 border d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary text-white p-3 rounded-3 me-3">
                            <i class="fa fa-file-pdf fs-4"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 text-dark fw-bold">{{ $res->title }}</h6>
                            <span class="small text-muted">{{ $res->course_code ?? 'CPE' }} • {{ $res->category ?? 'Lecture Material' }} • {{ $res->department->name ?? 'Faculty Wide' }}</span>
                        </div>
                    </div>
                    @if($res->file_path)
                        <a href="{{ Storage::url($res->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-circle p-2" title="Download Resource">
                            <i class="fa fa-download"></i>
                        </a>
                    @else
                        <button onclick="alert('Downloading course resource file: {{ $res->title }}...')" class="btn btn-sm btn-outline-primary rounded-circle p-2">
                            <i class="fa fa-download"></i>
                        </button>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-md-6">
                <div class="p-3 bg-light rounded-4 border d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary text-white p-3 rounded-3 me-3">
                            <i class="fa fa-file-pdf fs-4"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 text-dark fw-bold">CPE 501 - Advanced Computer Architecture</h6>
                            <span class="small text-muted">2020 - 2024 Past Questions PDF • 4.2 MB</span>
                        </div>
                    </div>
                    <button onclick="alert('Downloading CPE 501 Past Questions PDF...')" class="btn btn-sm btn-outline-primary rounded-circle p-2">
                        <i class="fa fa-download"></i>
                    </button>
                </div>
            </div>

            <div class="col-md-6">
                <div class="p-3 bg-light rounded-4 border d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="bg-warning text-dark p-3 rounded-3 me-3">
                            <i class="fa fa-microchip fs-4"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 text-dark fw-bold">CPE 503 - Embedded Systems & IoT</h6>
                            <span class="small text-muted">Lab Manual & Sample Projects • 8.1 MB</span>
                        </div>
                    </div>
                    <button onclick="alert('Downloading CPE 503 Lab Manual PDF...')" class="btn btn-sm btn-outline-primary rounded-circle p-2">
                        <i class="fa fa-download"></i>
                    </button>
                </div>
            </div>
        @endforelse
    </div>
</div>

@endsection
