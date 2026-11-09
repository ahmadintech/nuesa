@extends('layouts.admin')

@section('title', 'Manage Academic Course Vault - Admin')
@section('page_header', 'Academic Course Vault & Past Questions PDF Manager')

@section('content')
    <div class="card border-0 rounded-4 shadow-sm bg-white p-4 mb-4">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <h5 class="fw-bold text-dark mb-1"><i class="fa fa-folder-open text-primary me-2"></i>Academic Course Vault & Downloads</h5>
                <p class="text-muted small mb-0">Upload PDF lecture notes, past questions, and academic resources for engineering students.</p>
            </div>
            <button class="btn btn-primary rounded-pill px-4 btn-sm fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#uploadResourceModal">
                <i class="fa fa-cloud-upload me-1"></i>Upload PDF Resource
            </button>
        </div>
    </div>

    <!-- Resource Table Card -->
    <div class="card border-0 rounded-4 shadow-sm bg-white overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Course Code / Document Title</th>
                        <th>Category</th>
                        <th>Department</th>
                        <th>File Size</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($resources as $res)
                        <tr>
                            <td class="ps-4">
                                <strong class="text-dark">{{ $res->course_code }} - {{ $res->title }}</strong>
                            </td>
                            <td><span class="badge bg-light text-primary border rounded-pill px-3 py-1">{{ $res->category }}</span></td>
                            <td><span class="text-muted small"><i class="fa fa-university me-1 text-primary"></i>{{ $res->department->name ?? 'General Engineering' }}</span></td>
                            <td><span class="text-muted small">{{ $res->file_size }}</span></td>
                            <td class="text-end pe-4">
                                <a href="{{ asset($res->file_path) }}" class="btn btn-sm btn-outline-primary rounded-circle me-1" title="Download Document" download><i class="fa fa-download"></i></a>
                                <form action="{{ route('admin.resources.destroy', $res->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this PDF resource?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle" title="Delete Resource"><i class="fa fa-trash"></i></button>
                                </form>
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

    <!-- Upload Resource Modal -->
    <div class="modal fade" id="uploadResourceModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header border-0 bg-light p-4">
                    <h5 class="modal-title fw-bold text-dark"><i class="fa fa-cloud-upload text-primary me-2"></i>Upload Course Resource PDF</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <form action="{{ route('admin.resources.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Resource Title / Topic</label>
                            <input type="text" name="title" class="form-control rounded-pill px-4" placeholder="e.g. Fluid Mechanics Past Question 2024" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Course Code</label>
                            <input type="text" name="course_code" class="form-control rounded-pill px-4" placeholder="e.g. MEE 311 / CVE 401" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Category</label>
                            <select name="category" class="form-select rounded-pill px-4" required>
                                <option value="Past Question">Past Examination Paper</option>
                                <option value="Lecture Note">PDF Lecture Note</option>
                                <option value="Tutorial Guide">Tutorial Guide</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Department</label>
                            <select name="department_id" class="form-select rounded-pill px-4" required>
                                @foreach($departments as $dept)
                                    <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Select PDF Document</label>
                            <input type="file" name="document" class="form-control rounded-pill px-4" accept=".pdf,.doc,.docx" required>
                        </div>
                        <div class="modal-footer border-0 p-0 mt-4">
                            <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold">Upload to Vault</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
