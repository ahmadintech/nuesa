@extends('layouts.frontend')

@section('title', 'Student Portal Login - NUESA UNIMAID Chapter')

@section('content')
    <div class="container-fluid py-5 my-3">
        <div class="container">
            <div class="row justify-content-center align-items-center g-5">
                <!-- Left Feature Info Box -->
                <div class="col-lg-6 d-none d-lg-block wow fadeIn" data-wow-delay="0.1s">
                    <div class="p-4 p-lg-5 bg-white rounded-5 shadow-sm border border-2 border-light position-relative overflow-hidden" style="border-radius: 30px !important;">
                        <div class="d-flex align-items-center mb-4">
                            <div class="bg-primary-subtle text-primary p-3 rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 64px; height: 64px; background: rgba(0, 135, 81, 0.1);">
                                <span class="material-symbols-outlined text-primary" style="font-size: 36px;">verified_user</span>
                            </div>
                            <div>
                                <h2 class="text-dark mb-0 fw-bold" style="letter-spacing: -0.5px;">NUESA Student Portal</h2>
                                <span class="badge bg-primary-subtle text-primary px-3 py-1 rounded-pill fw-semibold mt-1">Faculty of Engineering • UNIMAID</span>
                            </div>
                        </div>
                        <p class="fs-5 mb-4 text-muted">Access your personalized engineering academic dashboard, session clearance, and e-learning resources.</p>
                        
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <div class="p-3 bg-light rounded-4 border-start border-4 border-primary shadow-sm">
                                    <h6 class="text-dark fw-bold mb-1 d-flex align-items-center"><span class="material-symbols-outlined text-primary me-2" style="font-size: 20px;">receipt_long</span>Dues Payment</h6>
                                    <small class="text-muted">Generate Remita / Pay NUESA annual dues online.</small>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="p-3 bg-light rounded-4 border-start border-4 border-warning shadow-sm">
                                    <h6 class="text-dark fw-bold mb-1 d-flex align-items-center"><span class="material-symbols-outlined text-warning me-2" style="font-size: 20px;">folder_zip</span>Course Vault</h6>
                                    <small class="text-muted">Download verified past questions & lecture slides.</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Login Form Card -->
                <div class="col-lg-5 col-md-8 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="card border-0 bg-white shadow-lg overflow-hidden" style="border-radius: 32px !important; border: 2px solid rgba(0, 135, 81, 0.12) !important;">
                        <div style="height: 6px; background: linear-gradient(90deg, #008751 0%, #ffc107 50%, #008751 100%);"></div>

                        <div class="card-body p-4 p-sm-5">
                            <div class="text-center mb-4">
                                <div class="position-relative d-inline-block mb-3">
                                    <div class="p-2 rounded-circle bg-white shadow-sm" style="border: 3px solid #008751;">
                                        <img src="{{ asset('img/logos/NUESA logo.jpeg') }}" alt="NUESA UNIMAID Logo" class="rounded-circle" style="width: 78px; height: 78px; object-fit: cover;">
                                    </div>
                                </div>
                                <h3 class="text-dark fw-bold mb-1">Student Portal Login</h3>
                                <p class="text-muted small mb-0">Enter your Email or Student ID & Password</p>
                            </div>

                            <form action="{{ route('login.submit') }}" method="POST">
                                @csrf
                                @if(session('error'))
                                    <div class="alert alert-danger py-2 px-3 small rounded-3 mb-3">
                                        {{ session('error') }}
                                    </div>
                                @endif
                                @if($errors->has('login_id'))
                                    <div class="alert alert-danger py-2 px-3 small rounded-3 mb-3">
                                        {{ $errors->first('login_id') }}
                                    </div>
                                @endif

                                <div class="mb-3">
                                    <label class="form-label fw-semibold text-dark small">Email or Student ID</label>
                                    <input type="text" name="login_id" class="form-control bg-light py-3 fs-6 rounded-pill px-4" placeholder="Email or Matric Number" value="{{ old('login_id') }}" autocomplete="off" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold text-dark small">Portal Password</label>
                                    <input type="password" name="password" class="form-control bg-light py-3 fs-6 rounded-pill px-4" placeholder="••••••••••••" autocomplete="new-password" required>
                                </div>

                                <button type="submit" class="btn btn-primary w-100 py-3 fw-bold rounded-pill shadow-sm mt-3">Access Student Portal</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
