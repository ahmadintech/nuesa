@extends('layouts.admin')

@section('title', 'Portal Settings - Admin')
@section('page_header', 'NUESA Portal Configuration & Contact Settings')

@section('content')
    <div class="card border-0 rounded-4 shadow-sm bg-white p-5">
        <h5 class="fw-bold text-dark mb-4"><i class="fa fa-cogs text-primary me-2"></i>Official Portal & Executive Settings</h5>
        <form onsubmit="event.preventDefault(); alert('Portal settings saved successfully!');">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label small fw-bold">Active Academic Session</label>
                    <input type="text" class="form-control rounded-pill px-4" value="2025/2026">
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-bold">Departmental Dues Amount (₦)</label>
                    <input type="number" class="form-control rounded-pill px-4" value="3500">
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-bold">Secretariat Official Phone</label>
                    <input type="text" class="form-control rounded-pill px-4" value="+234 800 NUESA UNIMAID">
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-bold">Secretariat Support Email</label>
                    <input type="email" class="form-control rounded-pill px-4" value="info@nuesaunimaid.org.ng">
                </div>
                <div class="col-12 mt-4">
                    <button type="submit" class="btn btn-primary rounded-pill px-5 py-3 fw-bold shadow-sm">Save Portal Settings</button>
                </div>
            </div>
        </form>
    </div>
@endsection
