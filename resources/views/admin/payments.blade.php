@extends('layouts.admin')

@section('title', 'Payments & Revenue Control - Admin')

@push('styles')
<style>
    .profile-input-group .input-group-text {
        background-color: #f8f9fa !important;
        border-color: #e2e8f0 !important;
        color: #64748b !important;
        border-top-left-radius: 14px !important;
        border-bottom-left-radius: 14px !important;
    }

    .profile-input-group .form-control,
    .profile-input-group .form-select {
        background-color: #f8f9fa !important;
        border-color: #e2e8f0 !important;
        border-top-right-radius: 14px !important;
        border-bottom-right-radius: 14px !important;
        padding: 12px 16px;
        font-size: 0.95rem;
        color: #1e293b;
    }

    .profile-input-group .form-control:focus,
    .profile-input-group .form-select:focus {
        background-color: #ffffff !important;
        border-color: #008751 !important;
        box-shadow: 0 0 0 4px rgba(0, 135, 81, 0.1) !important;
    }

    .stat-card-gradient {
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        transition: all 0.3s ease;
    }

    .stat-card-gradient:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0, 135, 81, 0.08);
    }

    /* LANDSCAPE RECEIPT STYLES */
    .landscape-receipt-card {
        background: #ffffff;
        border: 2px solid #008751;
        border-radius: 16px;
        padding: 24px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
    }

    .receipt-watermark {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 320px;
        opacity: 0.06;
        pointer-events: none;
        z-index: 0;
    }

    @media print {
        @page {
            size: A4 landscape;
            margin: 5mm;
        }
        html, body {
            background: #ffffff !important;
            color: #000000 !important;
            margin: 0 !important;
            padding: 0 !important;
        }
        .app-wrapper, .app-sidebar, .app-topbar, .app-main, .sidebar-backdrop, header, footer, nav, .modal-backdrop, .no-print, .modal-header, .modal-footer, .btn-close {
            display: none !important;
        }
        #receiptModal {
            position: absolute !important;
            left: 0 !important;
            top: 0 !important;
            width: 100% !important;
            height: auto !important;
            margin: 0 !important;
            padding: 0 !important;
            display: block !important;
            visibility: visible !important;
            background: #ffffff !important;
        }
        #receiptModal .modal-dialog {
            max-width: 100% !important;
            width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
        }
        #receiptModal .modal-content {
            border: none !important;
            box-shadow: none !important;
            background: #ffffff !important;
        }
        #printReceiptArea, #printReceiptArea * {
            visibility: visible !important;
        }
        #printReceiptArea {
            position: relative !important;
            width: 100% !important;
            padding: 0 !important;
            margin: 0 !important;
        }
        .landscape-receipt-card {
            border: 2px solid #008751 !important;
            box-shadow: none !important;
            padding: 20px !important;
        }
    }
</style>
@endpush

@section('content')
    <!-- Header Banner -->
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 gap-3">
        <div>
            <h3 class="fw-bold text-dark mb-1">Payments & Revenue Control</h3>
            <p class="text-muted small mb-0">Monitor dues collection, track transaction receipts, verify bank transfers, and issue official financial clearance.</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-success rounded-pill px-4 py-2 fw-bold shadow-sm d-inline-flex align-items-center" data-bs-toggle="modal" data-bs-target="#recordPaymentModal" style="background: linear-gradient(135deg, #008751 0%, #006038 100%); border: none;">
                <i class="fa fa-plus-circle me-2"></i>Record New Payment
            </button>
        </div>
    </div>

    <!-- TOP FINANCIAL STATS CARDS -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="stat-card-gradient p-4 h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted extra-small text-uppercase fw-bold">Total Dues Collected</span>
                    <span class="material-symbols-outlined text-success fs-3">account_balance_wallet</span>
                </div>
                <h3 class="fw-bold text-success mb-1">₦ {{ number_format($payments->where('status', 'successful')->sum('amount'), 2) }}</h3>
                <div class="extra-small text-muted fw-semibold"><i class="fa fa-arrow-up text-success me-1"></i>+12.4% from last session</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card-gradient p-4 h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted extra-small text-uppercase fw-bold">Paid & Verified Students</span>
                    <span class="material-symbols-outlined text-primary fs-3">verified</span>
                </div>
                <h3 class="fw-bold text-dark mb-1">{{ $payments->where('status', 'successful')->count() }}</h3>
                <div class="extra-small text-muted fw-semibold">Verified Receipts</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card-gradient p-4 h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted extra-small text-uppercase fw-bold">Pending Bank Clearance</span>
                    <span class="material-symbols-outlined text-warning fs-3">pending_actions</span>
                </div>
                <h3 class="fw-bold text-warning mb-1">{{ $payments->where('status', '!=', 'successful')->count() }} Receipts</h3>
                <div class="extra-small text-muted fw-semibold">Awaiting bank audit</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card-gradient p-4 h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted extra-small text-uppercase fw-bold">Elections Revenue</span>
                    <span class="material-symbols-outlined text-info fs-3">how_to_vote</span>
                </div>
                <h3 class="fw-bold text-info mb-1">₦ 950,000</h3>
                <div class="extra-small text-muted fw-semibold">Form sales & filings</div>
            </div>
        </div>
    </div>

    <!-- TRANSACTIONS TABLE CARD -->
    <div class="dash-card p-4">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-3 gap-3">
            <h5 class="fw-bold text-dark mb-0"><i class="fa fa-receipt text-success me-2"></i>Recent Payment Transactions</h5>
            <div class="d-flex gap-2">
                <select class="form-select rounded-pill px-3 small" id="filterCategory" onchange="filterPaymentTable()">
                    <option value="">All Categories</option>
                    <option value="Faculty Dues">Faculty Dues</option>
                    <option value="Department Dues">Department Dues</option>
                    <option value="Election Form">Election Form</option>
                </select>
                <select class="form-select rounded-pill px-3 small" id="filterStatus" onchange="filterPaymentTable()">
                    <option value="">All Statuses</option>
                    <option value="VERIFIED">Verified</option>
                    <option value="PENDING">Pending Audit</option>
                </select>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle" id="paymentsTable">
                <thead class="table-light extra-small text-uppercase">
                    <tr>
                        <th>Receipt Ref</th>
                        <th>Student Name</th>
                        <th>Matric No</th>
                        <th>Category</th>
                        <th>Amount Paid</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody id="paymentTableBody">
                    @forelse($payments as $payment)
                        <tr>
                            <td class="fw-bold small font-monospace text-primary">{{ $payment->reference ?? $payment->uuid }}</td>
                            <td>
                                <div class="fw-bold text-dark small">{{ $payment->user->name ?? 'Student' }}</div>
                                <div class="text-muted extra-small">{{ $payment->user->department->name ?? 'Engineering Student' }} • {{ $payment->user->academic_class ?? 'N/A' }}</div>
                            </td>
                            <td class="small font-monospace">{{ $payment->user->matric_number ?? 'N/A' }}</td>
                            <td><span class="badge bg-success-subtle text-success rounded-pill px-2 py-1 extra-small fw-bold">{{ $payment->payment_type ?? 'Faculty Dues' }}</span></td>
                            <td class="fw-bold text-dark small">₦ {{ number_format($payment->amount, 2) }}</td>
                            <td class="small text-muted">{{ $payment->paid_at ? $payment->paid_at->format('d M Y') : $payment->created_at->format('d M Y') }}</td>
                            <td>
                                @if($payment->status === 'successful')
                                    <span class="badge bg-success-subtle text-success rounded-pill px-3 py-1">VERIFIED</span>
                                @else
                                    <span class="badge bg-warning-subtle text-warning rounded-pill px-3 py-1">PENDING AUDIT</span>
                                @endif
                            </td>
                            <td class="text-end">
                                @if($payment->status !== 'successful')
                                    <form action="{{ route('admin.payments.approve', $payment->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm rounded-pill px-3 extra-small fw-bold me-1"><i class="fa fa-check me-1"></i>Approve</button>
                                    </form>
                                @endif
                                <button class="btn btn-outline-success btn-sm rounded-pill px-3 extra-small fw-bold me-1" 
                                    onclick="openOfficialReceiptModal(
                                        '{{ $payment->reference ?? $payment->uuid }}', 
                                        '{{ addslashes($payment->user->name ?? 'Student') }}', 
                                        '{{ $payment->user->matric_number ?? 'N/A' }}', 
                                        '{{ addslashes($payment->user->department->name ?? 'Faculty of Engineering') }}', 
                                        '{{ $payment->payment_type ?? 'Faculty Dues' }}', 
                                        '{{ number_format($payment->amount, 2) }}', 
                                        '{{ $payment->paid_at ? $payment->paid_at->format('d M Y') : $payment->created_at->format('d M Y') }}', 
                                        '{{ $payment->payment_channel ?? 'Remita / Bank Transfer' }}'
                                    )">
                                    <i class="fa fa-print me-1"></i>Receipt
                                </button>
                                <form action="{{ route('admin.payments.destroy', $payment->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete transaction record?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-light btn-sm rounded-circle text-danger"><i class="fa fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">No payment transactions recorded yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- RECORD PAYMENT MODAL -->
    <div class="modal fade" id="recordPaymentModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow-lg">
                <div class="modal-header border-bottom">
                    <h5 class="modal-title fw-bold text-dark"><i class="fa fa-cash-register text-success me-2"></i>Record Manual Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <form action="{{ route('admin.payments.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Student Full Name</label>
                            <div class="input-group profile-input-group">
                                <span class="input-group-text"><span class="material-symbols-outlined">person</span></span>
                                <input type="text" class="form-control" name="student_name" placeholder="e.g. Ibrahim Abubakar" required>
                            </div>
                        </div>
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="form-label small fw-bold">Matric Number</label>
                                <div class="input-group profile-input-group">
                                    <span class="input-group-text"><span class="material-symbols-outlined">badge</span></span>
                                    <input type="text" class="form-control" name="matric_number" placeholder="22/05/01/000" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <label class="form-label small fw-bold">Payment Category</label>
                                <div class="input-group profile-input-group">
                                    <span class="input-group-text"><span class="material-symbols-outlined">category</span></span>
                                    <select class="form-select" name="category" required>
                                        <option value="Faculty Dues">Faculty Dues</option>
                                        <option value="Department Dues">Department Dues</option>
                                        <option value="Election Form">Election Form</option>
                                        <option value="Digital ID Replacement">Digital ID Replacement</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="form-label small fw-bold">Amount Paid (₦)</label>
                                <div class="input-group profile-input-group">
                                    <span class="input-group-text"><span class="material-symbols-outlined">payments</span></span>
                                    <input type="number" step="0.01" class="form-control" name="amount" placeholder="3500" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <label class="form-label small fw-bold">Payment Channel</label>
                                <div class="input-group profile-input-group">
                                    <span class="input-group-text"><span class="material-symbols-outlined">account_balance</span></span>
                                    <select class="form-select" name="channel">
                                        <option value="Bank Transfer">Bank Transfer</option>
                                        <option value="Remita / Paystack">Remita / Paystack</option>
                                        <option value="Cash Deposit">Cash Deposit</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-success rounded-pill fw-bold py-3" style="background: linear-gradient(135deg, #008751 0%, #006038 100%); border: none;">
                                <i class="fa fa-check-circle me-2"></i>Save & Generate Official Receipt
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- PRINTABLE LANDSCAPE RECEIPT MODAL -->
    <div class="modal fade" id="receiptModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow-lg position-relative overflow-hidden">
                <div class="modal-header border-bottom no-print">
                    <h5 class="modal-title fw-bold text-dark"><i class="fa fa-print text-success me-2"></i>Official Receipt Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4" id="printReceiptArea">
                    <div class="landscape-receipt-card position-relative">
                        <!-- Watermark -->
                        <img src="{{ asset('img/logos/NUESA logo.jpeg') }}" alt="Watermark" class="receipt-watermark">

                        <div class="position-relative" style="z-index: 1;">
                            <!-- Header with logos -->
                            <div class="d-flex align-items-center justify-content-between border-bottom border-2 border-success pb-3 mb-3">
                                <img src="{{ asset('img/logos/unimaid logo.jpeg') }}" alt="UNIMAID Logo" style="height: 70px; object-fit: contain;">
                                <div class="text-center">
                                    <h5 class="fw-bold text-dark mb-0 text-uppercase" style="letter-spacing: 0.5px;">University of Maiduguri</h5>
                                    <h6 class="fw-bold text-success mb-1">FACULTY OF ENGINEERING</h6>
                                    <div class="small fw-bold text-dark text-uppercase">National Association of Engineering Students (NUESA)</div>
                                    <div class="extra-small text-muted">Official Dues & Financial Clearance Receipt</div>
                                </div>
                                <img src="{{ asset('img/logos/NUESA logo.jpeg') }}" alt="NUESA Logo" style="height: 70px; object-fit: contain;">
                            </div>

                            <!-- Receipt Meta Row -->
                            <div class="row bg-light rounded-3 p-3 mb-3 border align-items-center">
                                <div class="col-md-3">
                                    <div class="extra-small text-muted text-uppercase fw-bold">Receipt Ref No</div>
                                    <div class="fw-bold text-primary fs-5 font-monospace" id="recRef">NUESA-2025-001</div>
                                </div>
                                <div class="col-md-3">
                                    <div class="extra-small text-muted text-uppercase fw-bold">Payment Date</div>
                                    <div class="fw-bold text-dark" id="recDate">22 Aug 2026</div>
                                </div>
                                <div class="col-md-3">
                                    <div class="extra-small text-muted text-uppercase fw-bold">Payment Channel</div>
                                    <div class="fw-bold text-dark" id="recChannel">Remita / Online</div>
                                </div>
                                <div class="col-md-3 text-md-end">
                                    <span class="badge bg-success text-white px-3 py-2 rounded-pill fw-bold" id="recStatus">VERIFIED & CLEARED</span>
                                </div>
                            </div>

                            <!-- Student Info Grid -->
                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <div class="p-3 border rounded-3 bg-white h-100">
                                        <h6 class="fw-bold text-success border-bottom pb-2 mb-2"><i class="fa fa-user me-2"></i>Student Details</h6>
                                        <div class="row g-2 extra-small">
                                            <div class="col-4 text-muted fw-semibold">Student Name:</div>
                                            <div class="col-8 fw-bold text-dark" id="recStudentName">Ismail Yusuf</div>
                                            <div class="col-4 text-muted fw-semibold">Matric Number:</div>
                                            <div class="col-8 fw-bold text-dark font-monospace" id="recMatric">20/05/01/000</div>
                                            <div class="col-4 text-muted fw-semibold">Department:</div>
                                            <div class="col-8 fw-bold text-dark" id="recDept">Computer Engineering</div>
                                            <div class="col-4 text-muted fw-semibold">Academic Level:</div>
                                            <div class="col-8 fw-bold text-dark">500 Level</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="p-3 border rounded-3 bg-white h-100">
                                        <h6 class="fw-bold text-success border-bottom pb-2 mb-2"><i class="fa fa-info-circle me-2"></i>Payment Particulars</h6>
                                        <div class="row g-2 extra-small">
                                            <div class="col-4 text-muted fw-semibold">Session:</div>
                                            <div class="col-8 fw-bold text-dark">2025/2026 Academic Session</div>
                                            <div class="col-4 text-muted fw-semibold">Category:</div>
                                            <div class="col-8 fw-bold text-dark" id="recCategory">Faculty Dues</div>
                                            <div class="col-4 text-muted fw-semibold">Faculty:</div>
                                            <div class="col-8 fw-bold text-dark">Faculty of Engineering</div>
                                            <div class="col-4 text-muted fw-semibold">Issuer:</div>
                                            <div class="col-8 fw-bold text-dark">NUESA Financial Secretariat</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Financial Breakdown Table -->
                            <table class="table table-bordered align-middle mb-3">
                                <thead class="table-light extra-small text-uppercase">
                                    <tr>
                                        <th>S/N</th>
                                        <th>Description of Fee / Particulars</th>
                                        <th class="text-end">Amount (₦)</th>
                                    </tr>
                                </thead>
                                <tbody class="small">
                                    <tr>
                                        <td class="fw-bold">1</td>
                                        <td id="recParticulars">NUESA UNIMAID Faculty Annual Dues & Registration Fee</td>
                                        <td class="text-end fw-bold text-dark" id="recTableAmount">3,500.00</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr class="table-light">
                                        <th colspan="2" class="text-end text-uppercase fw-bold">Total Cleared Amount:</th>
                                        <th class="text-end fs-5 fw-bold text-success" id="recTotalAmount">₦ 3,500.00</th>
                                    </tr>
                                </tfoot>
                            </table>

                            <!-- Signatures & Verification Stamp Footer -->
                            <div class="row align-items-center mt-4 pt-3 border-top">
                                <div class="col-4 text-center">
                                    <div style="height: 45px;"></div>
                                    <div class="border-top pt-1 mx-4"></div>
                                </div>
                                <div class="col-4 text-center">
                                    <div class="p-2 border border-success rounded-3 bg-success bg-opacity-10 d-inline-block">
                                        <i class="fa fa-qrcode text-success fs-3 mb-1"></i>
                                        <div class="extra-small fw-bold text-success">NUESA DIGITAL SEAL</div>
                                        <div class="extra-small text-muted font-monospace" style="font-size: 9px;">VERIFIED OK • NUESA ID</div>
                                    </div>
                                </div>
                                <div class="col-4 text-center">
                                    <div style="height: 45px;"></div>
                                    <div class="border-top pt-1 mx-4"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top no-print">
                    <button type="button" class="btn btn-light rounded-pill px-4 fw-bold" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success rounded-pill px-4 fw-bold shadow-sm" onclick="window.print()" style="background: linear-gradient(135deg, #008751 0%, #006038 100%); border: none;">
                        <i class="fa fa-print me-2"></i>Print Receipt
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function openOfficialReceiptModal(ref, student, matric, dept, category, amount, date, channel) {
        $('#recRef').text(ref);
        $('#recStudentName').text(student);
        $('#recMatric').text(matric);
        $('#recDept').text(dept);
        $('#recCategory').text(category);
        $('#recParticulars').text('NUESA UNIMAID ' + category + ' Clearance & Official Fee');
        $('#recTableAmount').text(amount);
        $('#recTotalAmount').text('₦ ' + amount);
        $('#recDate').text(date);
        $('#recChannel').text(channel);

        const modal = new bootstrap.Modal(document.getElementById('receiptModal'));
        modal.show();
    }

    function filterPaymentTable() {
        const cat = $('#filterCategory').val().toLowerCase();
        const status = $('#filterStatus').val().toLowerCase();

        $('#paymentTableBody tr').each(function() {
            const text = $(this).text().toLowerCase();
            const matchesCat = !cat || text.indexOf(cat) > -1;
            const matchesStatus = !status || text.indexOf(status) > -1;

            if (matchesCat && matchesStatus) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    }
</script>
@endpush
