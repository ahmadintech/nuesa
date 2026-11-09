@extends('layouts.student')

@section('title', 'Digital Student ID - NUESA Student Portal')

@push('styles')
<style>
    /* Standard CR80 Portrait ID Card Styles (Ratio 330px x 520px) */
    .nuesa-portrait-card {
        width: 330px;
        height: 520px;
        border-radius: 18px;
        position: relative;
        overflow: hidden;
        background: #ffffff;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.18);
        border: 2px solid #e2e8f0;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        font-family: 'Rubik', sans-serif;
        text-align: left;
    }

    .id-header-front {
        background: linear-gradient(135deg, #00351d 0%, #008751 70%, #eb7c13 100%);
        color: #ffffff;
        padding: 14px 14px 10px;
        border-bottom: 3px solid #eb7c13;
    }

    .id-watermark {
        position: absolute;
        top: 55%;
        left: 50%;
        transform: translate(-50%, -50%) rotate(-15deg);
        width: 220px;
        opacity: 0.06;
        pointer-events: none;
        z-index: 1;
    }

    .id-card-body {
        position: relative;
        z-index: 2;
        padding: 14px 16px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .id-avatar-wrapper {
        position: relative;
        margin-bottom: 8px;
    }

    .id-avatar-img {
        width: 105px;
        height: 125px;
        object-fit: cover;
        border-radius: 12px;
        border: 3px solid #008751;
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
    }

    .id-verified-pill {
        background: #008751;
        color: #ffffff;
        font-size: 9px;
        font-weight: 700;
        padding: 3px 10px;
        border-radius: 50px;
        letter-spacing: 0.5px;
        display: inline-flex;
        align-items: center;
        box-shadow: 0 2px 6px rgba(0, 135, 81, 0.3);
    }

    .id-field-group {
        width: 100%;
        margin-bottom: 6px;
    }

    .id-label {
        font-size: 8.5px;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 1px;
    }

    .id-value {
        font-size: 13px;
        font-weight: 700;
        color: #0f172a;
        line-height: 1.2;
    }

    .id-value-highlight {
        color: #008751;
        font-family: 'Courier New', monospace;
        letter-spacing: 0.5px;
    }

    .id-footer-strip {
        background: #002b18;
        color: #ffffff;
        padding: 8px 14px;
        border-top: 2px solid #eb7c13;
        display: flex;
        align-items: center;
        justify-content: space-between;
        z-index: 2;
    }

    .nuesa-portrait-card-back {
        background: linear-gradient(180deg, #f8fafc 0%, #ffffff 100%);
    }

    .mag-stripe {
        width: 100%;
        height: 38px;
        background: #1e293b;
        margin-top: 15px;
    }

    @media print {
        body {
            background: #ffffff !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .sidebar-backdrop,
        .app-sidebar,
        .app-topbar,
        footer,
        .non-printable,
        .dash-card-header {
            display: none !important;
        }

        .app-wrapper,
        .app-main,
        .app-content,
        .dash-card {
            padding: 0 !important;
            margin: 0 !important;
            background: none !important;
            border: none !important;
            box-shadow: none !important;
        }

        .printable-id-wrapper {
            display: flex !important;
            flex-direction: row !important;
            justify-content: center !important;
            align-items: center !important;
            gap: 25px !important;
            padding: 30px 10px !important;
            width: 100% !important;
            margin: 0 auto !important;
        }

        .nuesa-portrait-card {
            box-shadow: none !important;
            border: 1.5px solid #004d2e !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            page-break-inside: avoid !important;
        }

        @page {
            size: A4 portrait;
            margin: 10mm;
        }
    }
</style>
@endpush

@section('content')
<div class="dash-card p-4 p-lg-5">
    <div class="d-flex align-items-center justify-content-between mb-4 border-bottom pb-3 dash-card-header">
        <div>
            <h4 class="text-dark fw-bold mb-1">Standard Digital Student ID Card (CR80 Portrait)</h4>
            <p class="text-muted small mb-0">Official identity badge for Faculty of Engineering, University of Maiduguri.</p>
        </div>
        <button class="btn btn-secondary rounded-pill px-4 fw-bold shadow-sm" onclick="window.print()">
            <i class="fa fa-print me-2"></i>Print ID Card
        </button>
    </div>

    <!-- PRINTABLE ID WRAPPER -->
    <div class="printable-id-wrapper d-flex flex-wrap justify-content-center gap-4 my-3">

        <!-- FRONT SIDE (PORTRAIT CR80) -->
        <div class="nuesa-portrait-card">
            <img src="{{ asset('img/logos/NUESA_logo.png') }}" class="id-watermark" alt="Watermark Seal">

            <!-- Header -->
            <div class="id-header-front">
                <div class="d-flex align-items-center justify-content-between">
                    <img src="{{ asset('img/logos/NUESA_logo.png') }}" alt="NUESA Logo" class="rounded-circle bg-white p-1" style="width: 42px; height: 42px; object-fit: contain;">
                    <div class="text-center px-1">
                        <div class="fw-bold extra-small text-uppercase tracking-wider" style="font-size: 8px; color: #ffffff;">NIGERIAN UNIVERSITIES ENGINEERING STUDENTS' ASSOCIATION</div>
                        <div class="fw-bold extra-small text-uppercase tracking-wider" style="font-size: 10.5px; color: #ffffff;">NUESA UNIMAID CHAPTER</div>
                        <div class="extra-small text-warning fw-bold" style="font-size: 8px;">FACULTY OF ENGINEERING • UNIMAID</div>
                    </div>
                    <img src="{{ asset('img/logos/unimaid logo.jpeg') }}" alt="UNIMAID Logo" class="rounded-circle bg-white p-1" style="width: 40px; height: 40px; object-fit: cover;">
                </div>
            </div>

            <!-- Body -->
            <div class="id-card-body pt-3">
                <div class="id-avatar-wrapper text-center" style="margin-top: 28px;">
                    <img src="{{ asset('img/team-1.jpg') }}" alt="Student Photo" class="id-avatar-img" id="cardPhotoImg" style="width: 125px; height: 140px; object-fit: cover; border-radius: 14px; border: 3px solid #008751; box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);">
                </div>

                <div class="mb-2 text-center">
                    <span class="id-verified-pill">
                        <i class="fa fa-check-circle me-1"></i> VERIFIED MEMBER
                    </span>
                </div>

                <div class="id-field-group text-center mb-1">
                    <div class="id-label">STUDENT FULL NAME</div>
                    <div class="id-value text-uppercase" id="cardFullName">{{ $user->name ?? 'Ismail Yusuf' }}</div>
                </div>

                <div class="w-100 row g-1 text-start my-1">
                    <div class="col-6">
                        <div class="id-label">MATRIC NO</div>
                        <div class="id-value id-value-highlight" id="cardMatricNo" style="font-size: 11.5px;">{{ $user->matric_number ?? '18/04/07/042' }}</div>
                    </div>
                    <div class="col-6">
                        <div class="id-label">NUESA ID NO.</div>
                        <div class="id-value text-success fw-bold" style="font-size: 11px;" id="cardNuesaId">NUESA/2026/{{ strtoupper(substr($user->department->name ?? 'CPE', 0, 3)) }}/0042</div>
                    </div>
                </div>

                <div class="w-100 row g-1 text-start mt-2">
                    <div class="col-6">
                        <div class="id-label">DEPT / LEVEL</div>
                        <div class="id-value" style="font-size: 11px;" id="cardDeptLevel">{{ strtoupper(substr($user->department->name ?? 'CPE', 0, 3)) }} • {{ $user->level ?? '500L' }}</div>
                    </div>
                    <div class="col-6">
                        <div class="id-label">VALID SESSION</div>
                        <div class="id-value text-success" style="font-size: 11px;">2025/2026</div>
                    </div>
                </div>
            </div>

            <!-- Footer Strip Background Bar -->
            <div class="id-footer-strip py-2" style="min-height: 24px;"></div>
        </div>

        <!-- BACK SIDE (PORTRAIT CR80) -->
        <div class="nuesa-portrait-card nuesa-portrait-card-back">
            <!-- Magnetic Stripe Visual -->
            <div class="mag-stripe"></div>

            <div class="p-3 flex-grow-1 d-flex flex-column justify-content-between text-center">
                <div>
                    <div class="border-bottom pb-3 mb-2 text-center" style="margin-top: 32px;">
                        <div class="fw-bold text-dark mb-2 text-center" style="font-size: 12.5px; color: #004d2e !important; letter-spacing: 0.3px;">TERMS OF USE & PROPERTY NOTICE</div>
                        <p class="text-dark fw-normal mb-3 text-center" style="font-size: 11.5px; line-height: 1.5; color: #1e293b !important;">
                            This card is the official property of NUESA UNIMAID Chapter, Faculty of Engineering. It must be presented upon request for access to Faculty facilities, exams, and voting. If found, please return to the NUESA Secretariat, UNIMAID.
                        </p>

                        <!-- QR CODE DIRECTLY UNDER TERMS TEXT -->
                        <div class="text-center pt-2 border-top">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=80x80&data=NUESA-UNIMAID-VERIFIED-STUDENT-{{ $user->matric_number ?? '180407042' }}" alt="QR Code Verification" class="bg-white p-1 rounded border shadow-sm" style="width: 70px; height: 70px;">
                            <div class="extra-small text-muted mt-1 fw-semibold" style="font-size: 8.5px;">SCAN TO VERIFY FACULTY MEMBERSHIP</div>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="row align-items-end my-2">
                        <div class="col-6 text-center">
                            <div class="fst-italic text-dark fw-bold" style="font-family: 'Brush Script MT', cursive; font-size: 17px; color: #004d2e;">Engr. Babagana A.</div>
                            <div class="border-top pt-1 text-muted extra-small" style="font-size: 8px; font-weight: 600;">NUESA PRESIDENT SIGN</div>
                        </div>
                        <div class="col-6 text-center">
                            <img src="{{ asset('img/logos/NUESA_logo.png') }}" alt="Seal" style="width: 36px; height: 36px; opacity: 0.85;">
                            <div class="border-top pt-1 text-muted extra-small" style="font-size: 8px; font-weight: 600;">OFFICIAL STAMP</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
