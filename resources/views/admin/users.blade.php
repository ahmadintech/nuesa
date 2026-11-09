@extends('layouts.admin')

@section('title', 'Manage Students & Dues Clearance - Admin')
@section('page_header', 'Student Directory & Dues Clearance Manager')

@section('content')
    <div class="card border-0 rounded-4 shadow-sm bg-white overflow-hidden">
        <div class="card-header bg-light border-0 py-3 px-4 d-flex align-items-center justify-content-between">
            <div>
                <h5 class="fw-bold mb-1 text-dark"><i class="fa fa-users text-primary me-2"></i>Registered Engineering Students</h5>
                <p class="small text-muted mb-0">Manage registered engineering students, assign Class Rep leadership roles, toggle dues & clearance status, and issue digital ID credentials.</p>
            </div>
            <button class="btn btn-primary rounded-pill px-4 btn-sm fw-bold"><i class="fa fa-plus me-1"></i>Register Student</button>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Student Details</th>
                        <th>Matric Number</th>
                        <th>Department</th>
                        <th>Class</th>
                        <th>Dues Status</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('img/project-1.jpg') }}" alt="{{ $user->name }}" class="rounded-circle me-3" style="width: 42px; height: 42px; object-fit: cover;">
                                    <div>
                                        <strong class="d-block text-dark">{{ $user->name }}</strong>
                                        <small class="text-muted">{{ $user->email }}</small>
                                    </div>
                                </div>
                            </td>
                            <td><span class="font-monospace fw-bold text-dark">{{ $user->matric_number ?? '18/04/01/0101' }}</span></td>
                            <td>{{ $user->department->name ?? 'Civil & Water Resources' }}</td>
                            <td>{{ $user->academic_class ?? '500L' }}</td>
                            <td>
                                @if($user->dues_status === 'paid')
                                    <span class="badge bg-success rounded-pill px-3 py-2">Paid & Cleared</span>
                                @else
                                    <span class="badge bg-warning text-dark rounded-pill px-3 py-2">Pending Dues</span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <form action="{{ route('admin.users.toggleVerification', $user->id) }}" method="POST" class="d-inline me-1">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-{{ $user->clearance_status === 'verified' ? 'warning' : 'success' }} rounded-pill px-3 fw-bold">
                                        <i class="fa fa-{{ $user->clearance_status === 'verified' ? 'ban' : 'check' }} me-1"></i>
                                        {{ $user->clearance_status === 'verified' ? 'Revoke Clearance' : 'Verify Student' }}
                                    </button>
                                </form>
                                <a href="{{ route('receipt.demo') }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-circle me-1" title="View Dues Receipt"><i class="fa fa-receipt"></i></a>
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this student record?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle" title="Delete Student"><i class="fa fa-trash"></i></button>
                                </form>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">No registered students found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
