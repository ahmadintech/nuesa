@extends('layouts.admin')

@section('title', 'Manage Faculty Gallery Album - Admin')
@section('page_header', 'Faculty Gallery & Student Profile Album Manager')

@section('content')
    <div class="card border-0 rounded-4 shadow-sm bg-white p-4 mb-4">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <h5 class="fw-bold text-dark mb-1"><i class="fa fa-photo-video text-primary me-2"></i>Faculty Gallery & Student Album</h5>
                <p class="text-muted small mb-0">Upload event photos or verify student photo profiles for the NUESA gallery directory.</p>
            </div>
            <button class="btn btn-primary rounded-pill px-4 btn-sm fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#uploadPhotoModal">
                <i class="fa fa-upload me-1"></i>Upload Photo / Profile
            </button>
        </div>
    </div>

    <!-- Gallery Items Grid -->
    <div class="row g-4">
        @forelse($items as $item)
            <div class="col-md-6 col-lg-4">
                <div class="card border-0 rounded-4 shadow-sm bg-white overflow-hidden h-100 position-relative">
                    <form action="{{ route('admin.gallery.destroy', $item->id) }}" method="POST" class="position-absolute top-0 end-0 m-3 z-index-10" onsubmit="return confirm('Delete photo?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger rounded-circle" title="Delete Photo">
                            <i class="fa fa-trash"></i>
                        </button>
                    </form>
                    <div style="height: 220px;" class="overflow-hidden">
                        <img src="{{ asset($item->image_path) }}" alt="{{ $item->title }}" class="img-fluid w-100 h-100" style="object-fit: cover;">
                    </div>
                    <div class="p-4">
                        <h6 class="fw-bold text-dark mb-1">{{ $item->title }}</h6>
                        <small class="text-muted d-block mb-2"><i class="fa fa-university me-1 text-primary"></i>{{ $item->department->name ?? 'Faculty Event' }}</small>
                        <span class="badge bg-success rounded-pill px-3 py-1"><i class="fa fa-check-circle me-1"></i>{{ ucfirst($item->category) }}</span>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center text-muted py-5">No gallery photos currently uploaded.</div>
        @endforelse
    </div>

    <!-- Upload Photo Modal -->
    <div class="modal fade" id="uploadPhotoModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header border-0 bg-light p-4">
                    <h5 class="modal-title fw-bold text-dark"><i class="fa fa-upload text-primary me-2"></i>Upload Photo / Student Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Title / Student Name</label>
                            <input type="text" name="title" class="form-control rounded-pill px-4" placeholder="Title or student name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Category</label>
                            <select name="category" class="form-select rounded-pill px-4" required>
                                <option value="civil">Civil Engineering</option>
                                <option value="electrical">Electrical Engineering</option>
                                <option value="mechanical">Mechanical Engineering</option>
                                <option value="computer">Computer Engineering</option>
                                <option value="events">Faculty Event Photo</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Department (Optional)</label>
                            <select name="department_id" class="form-select rounded-pill px-4">
                                <option value="">General / Faculty Event</option>
                                @foreach($departments as $dept)
                                    <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Select Image File</label>
                            <input type="file" name="image" class="form-control rounded-pill px-4" accept="image/*" required>
                        </div>
                        <div class="modal-footer border-0 p-0 mt-4">
                            <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold">Upload to Gallery</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
