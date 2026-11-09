@extends('layouts.frontend')

@section('title', 'Academic Resources Hub & Course Vault - NUESA UNIMAID')

@section('content')
    <!-- Page Header Start -->
    <div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <h1 class="display-3 text-white animated slideInRight">Academic Resources Hub</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb animated slideInRight mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page">Resources</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Resource Vault Section -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <p class="fw-medium text-uppercase text-primary mb-2">Academic Past Questions & Lecture Vault</p>
                <h1 class="display-5 mb-4">Engineering Course Vault</h1>
                <p class="text-muted">Download free PDF lecture handouts, past examination papers, and tutorial guides contributed by departmental class reps.</p>
            </div>

            <!-- Resource Search Bar -->
            <div class="row justify-content-center mb-5">
                <div class="col-md-8">
                    <div class="input-group input-group-lg shadow-sm rounded-pill overflow-hidden border">
                        <span class="input-group-text bg-white border-0 ps-4"><i class="fa fa-search text-primary"></i></span>
                        <input type="text" class="form-control border-0 px-3" id="resourceSearch" placeholder="Search by course code e.g. MEE 311, CVE 401, or title..." onkeyup="filterResources()">
                        <button class="btn btn-primary px-4 fw-bold" type="button">Search Vault</button>
                    </div>
                </div>
            </div>

            <!-- Resource Table Card -->
            <div class="card border-0 rounded-4 shadow-sm bg-white overflow-hidden">
                <div class="card-header bg-light border-0 py-3 px-4 d-flex align-items-center justify-content-between">
                    <h5 class="fw-bold mb-0 text-dark"><i class="fa fa-folder-open text-primary me-2"></i>Available Academic Documents</h5>
                    <span class="badge bg-primary rounded-pill px-3 py-2">{{ count($resources) }} Files Available</span>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="resourceTable">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Course Code / Document</th>
                                <th>Category</th>
                                <th>Department</th>
                                <th>File Size</th>
                                <th class="text-end pe-4">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($resources as $res)
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-bold text-dark">{{ $res->course_code ? $res->course_code . ' - ' : '' }}{{ $res->title }}</div>
                                    </td>
                                    <td><span class="badge bg-light text-primary border rounded-pill px-3 py-1">{{ $res->category }}</span></td>
                                    <td><span class="text-muted small"><i class="fa fa-university me-1 text-primary"></i>{{ $res->department->name ?? 'General Engineering' }}</span></td>
                                    <td><span class="text-muted small">{{ $res->file_size ?? '2.4 MB' }}</span></td>
                                    <td class="text-end pe-4">
                                        <a href="{{ asset($res->file_path ?? '#') }}" class="btn btn-sm btn-primary rounded-pill px-3" download>
                                            <i class="fa fa-download me-1"></i>Download PDF
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">No course resources uploaded yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function filterResources() {
            let input = document.getElementById("resourceSearch").value.toLowerCase();
            let rows = document.querySelectorAll("#resourceTable tbody tr");
            rows.forEach(row => {
                let text = row.innerText.toLowerCase();
                row.style.display = text.includes(input) ? "" : "none";
            });
        }
    </script>
    @endpush
@endsection
