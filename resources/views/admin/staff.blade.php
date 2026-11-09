@extends('layouts.admin')

@section('title', 'Faculty Staff Directory Manager - Admin')
@section('page_header', 'Faculty Academic & Administrative Staff Directory')

@section('content')
    <div class="card border-0 rounded-4 shadow-sm bg-white p-4 mb-4">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <h5 class="fw-bold text-dark mb-1"><i class="fa fa-user-graduate text-primary me-2"></i>Academic & Administrative Staff Directory</h5>
                <p class="text-muted small mb-0">Manage Faculty Deans, Departmental HODs, Lecturers, and Staff Advisers including Office Room Numbers.</p>
            </div>
            <button class="btn btn-primary rounded-pill px-4 btn-sm fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#addStaffModal">
                <i class="fa fa-user-plus me-1"></i>Add Staff Member
            </button>
        </div>
    </div>

    <!-- Staff Members Grid -->
    <div class="row g-4">
        @forelse($staff as $member)
            <div class="col-lg-4 col-md-6">
                <div class="card border-0 rounded-4 shadow-sm bg-white h-100 p-4 position-relative">
                    <form action="{{ route('admin.staff.destroy', $member->id) }}" method="POST" class="position-absolute top-0 end-0 m-3 z-index-10" onsubmit="return confirm('Delete staff profile?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle" title="Delete Staff">
                            <i class="fa fa-trash"></i>
                        </button>
                    </form>
                    <div class="text-center mb-3">
                        <img src="{{ asset($member->photo_path ?? 'img/team-1.jpg') }}" alt="{{ $member->name }}" class="rounded-circle shadow img-fluid" style="width: 100px; height: 100px; object-fit: cover;">
                    </div>
                    <div class="text-center">
                        <h5 class="fw-bold text-dark mb-1">{{ $member->name }}</h5>
                        <p class="text-primary fw-medium small mb-2"><i class="fa fa-graduation-cap me-1"></i>{{ $member->designation }}</p>
                        <div class="bg-light p-3 rounded-3 text-start small mt-2">
                            <div class="mb-1"><i class="fa fa-door-open me-2 text-primary"></i><strong>Office No:</strong> {{ $member->office_number }}</div>
                            <div><i class="fa fa-envelope me-2 text-primary"></i><strong>Email:</strong> {{ $member->email }}</div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center text-muted py-5">No staff members created yet.</div>
        @endforelse
    </div>

    <!-- Add Staff Modal -->
    <div class="modal fade" id="addStaffModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header border-0 bg-light p-4">
                    <h5 class="modal-title fw-bold text-dark"><i class="fa fa-user-plus text-primary me-2"></i>Add Staff Member</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <form action="{{ route('admin.staff.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Full Academic Name & Title</label>
                            <input type="text" name="name" class="form-control rounded-pill px-4" placeholder="e.g. Prof. Engr. Baba Gana Umar" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Designation / Role</label>
                            <input type="text" name="designation" class="form-control rounded-pill px-4" placeholder="e.g. Dean / HOD Civil Engineering" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Office Room No.</label>
                            <input type="text" name="office_number" class="form-control rounded-pill px-4" placeholder="e.g. Office Room 101 (Deanery Building)" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Official Email Address</label>
                            <input type="email" name="email" class="form-control rounded-pill px-4" placeholder="staff@unimaid.edu.ng" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Department (Optional)</label>
                            <select name="department_id" class="form-select rounded-pill px-4">
                                <option value="">Faculty Office / Deanery</option>
                                @foreach($departments as $dept)
                                    <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Photo Profile</label>
                            <input type="file" name="photo" class="form-control rounded-pill px-4" accept="image/*">
                        </div>
                        <div class="modal-footer border-0 p-0 mt-4">
                            <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold">Save Staff Profile</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
