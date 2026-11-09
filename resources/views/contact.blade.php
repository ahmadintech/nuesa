@extends('layouts.frontend')

@section('title', 'Contact & Helpdesk - NUESA UNIMAID')

@section('content')
    <!-- Page Header Start -->
    <div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <h1 class="display-3 text-white animated slideInRight">Contact & Helpdesk</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb animated slideInRight mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page">Contact</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Contact Details & Form Section -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5">
                <!-- Left Info Box -->
                <div class="col-lg-5 wow fadeInUp" data-wow-delay="0.1s">
                    <p class="fw-medium text-uppercase text-primary mb-2">Secretariat Helpdesk</p>
                    <h1 class="display-5 mb-4">Get in Touch with NUESA Executives</h1>
                    <p class="text-muted mb-4">Have questions about departmental dues clearance, e-ID card issuance, or engineering week events? Visit the secretariat or send us a direct message.</p>

                    <div class="d-flex align-items-center mb-4">
                        <div class="btn-square bg-primary text-white rounded-circle me-3" style="width: 50px; height: 50px;">
                            <i class="fa fa-map-marker-alt"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold">Secretariat Address</h6>
                            <small class="text-muted">Faculty of Engineering Complex, University of Maiduguri, Borno State</small>
                        </div>
                    </div>

                    <div class="d-flex align-items-center mb-4">
                        <div class="btn-square bg-primary text-white rounded-circle me-3" style="width: 50px; height: 50px;">
                            <i class="fa fa-phone-alt"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold">Executive Phone Lines</h6>
                            <small class="text-muted">+234 800 NUESA UNIMAID / +234 803 456 7890</small>
                        </div>
                    </div>

                    <div class="d-flex align-items-center">
                        <div class="btn-square bg-primary text-white rounded-circle me-3" style="width: 50px; height: 50px;">
                            <i class="fa fa-envelope"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold">Email Support</h6>
                            <small class="text-muted">info@nuesaunimaid.org.ng</small>
                        </div>
                    </div>
                </div>

                <!-- Right Form Box -->
                <div class="col-lg-7 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="bg-white p-5 rounded-4 shadow-sm border">
                        <h4 class="fw-bold mb-4 text-dark"><i class="fa fa-paper-plane text-primary me-2"></i>Send Message to NUESA PRO</h4>
                        <form onsubmit="event.preventDefault(); alert('Thank you! Your message has been submitted to the NUESA Secretariat helpdesk.');">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Full Name</label>
                                    <input type="text" class="form-control rounded-pill px-4" placeholder="Comr. Student Name" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Matric Number</label>
                                    <input type="text" class="form-control rounded-pill px-4" placeholder="18/04/01/0101" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Email Address</label>
                                    <input type="email" class="form-control rounded-pill px-4" placeholder="student@unimaid.edu.ng" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Department</label>
                                    <select class="form-select rounded-pill px-4" required>
                                        <option value="">Select Department</option>
                                        <option value="civil">Civil & Water Resources Eng.</option>
                                        <option value="electrical">Electrical & Electronics Eng.</option>
                                        <option value="mechanical">Mechanical Engineering</option>
                                        <option value="computer">Computer Engineering</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="form-label small fw-bold">Message Subject</label>
                                    <input type="text" class="form-control rounded-pill px-4" placeholder="Inquiry topic" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label small fw-bold">Message Body</label>
                                    <textarea class="form-control rounded-4 p-3" rows="4" placeholder="Type your inquiry here..." required></textarea>
                                </div>
                                <div class="col-12 mt-4">
                                    <button type="submit" class="btn btn-primary rounded-pill py-3 px-5 fw-bold w-100 shadow-sm">Submit Inquiry to Secretariat</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
