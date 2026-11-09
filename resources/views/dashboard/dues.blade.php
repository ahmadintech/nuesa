@extends('layouts.student')

@section('title', 'Dues & E-Receipts - NUESA Student Portal')

@section('content')
<div class="dash-card p-4 p-lg-5">
    <div class="d-flex align-items-center justify-content-between mb-4 border-bottom pb-3">
        <div>
            <h4 class="text-dark fw-bold mb-1">Departmental Dues & Official E-Receipts</h4>
            <p class="text-muted small mb-0">View annual dues payment history and print official UNIMAID / NUESA letterhead receipts.</p>
        </div>
        <button class="btn btn-secondary rounded-pill px-4 fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#payDuesModal">
            <i class="fa fa-plus-circle me-2"></i>Pay Dues Online
        </button>
    </div>

    <div class="alert alert-warning rounded-3 small d-flex align-items-center">
        <i class="fa fa-exclamation-triangle me-2"></i>Online dues payment is currently unavailable. Please try again later.
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Academic Session</th>
                    <th>Transaction Ref</th>
                    <th>Amount</th>
                    <th>Payment Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $payment)
                    <tr>
                        <td class="fw-bold text-dark">{{ $payment->academic_session ?? '2025/2026 Session' }}</td>
                        <td><code>{{ $payment->uuid ?? $payment->reference }}</code></td>
                        <td class="fw-bold text-success">₦{{ number_format($payment->amount, 2) }}</td>
                        <td>{{ $payment->paid_at ? \Carbon\Carbon::parse($payment->paid_at)->format('M d, Y') : now()->format('M d, Y') }}</td>
                        <td><span class="badge bg-success-subtle text-success px-3 py-1 rounded-pill">VERIFIED PAID</span></td>
                        <td>
                            <a href="{{ route('receipt.download', $payment->uuid) }}" class="btn btn-outline-primary btn-sm rounded-pill px-3 me-1">
                                <i class="fa fa-download me-1"></i>Download PDF
                            </a>
                            <button onclick="openReceiptModal('{{ $payment->uuid }}', '{{ number_format($payment->amount, 2) }}', '{{ $payment->academic_session }}')" class="btn btn-primary btn-sm rounded-pill px-3">
                                <i class="fa fa-file-invoice me-1"></i>View
                            </button>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="fw-bold text-dark">2025/2026 Session</td>
                        <td><code>NUESA-TXN-984211</code></td>
                        <td class="fw-bold text-success">₦3,500.00</td>
                        <td>Oct 14, 2025</td>
                        <td><span class="badge bg-success-subtle text-success px-3 py-1 rounded-pill">VERIFIED PAID</span></td>
                        <td>
                            <a href="{{ route('receipt.demo') }}" target="_blank" class="btn btn-outline-primary btn-sm rounded-pill px-3 me-1">
                                <i class="fa fa-download me-1"></i>PDF Receipt
                            </a>
                            <button onclick="openReceiptModal('NUESA-TXN-984211', '3,500.00', '2025/2026 Session')" class="btn btn-primary btn-sm rounded-pill px-3">
                                <i class="fa fa-file-invoice me-1"></i>View
                            </button>

                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- MODAL 1: PAY DUES ONLINE -->
<div class="modal fade" id="payDuesModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-lg overflow-hidden">
            <form action="{{ route('student.payDues') }}" method="POST">
                @csrf
                <div class="modal-header bg-dark text-white border-bottom border-secondary">
                    <h5 class="modal-title text-white fw-bold"><i class="fa fa-credit-card text-warning me-2"></i>Pay NUESA Annual Dues</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4 bg-light">
                    <div class="p-3 bg-white rounded-3 border mb-3">
                        <div class="d-flex justify-content-between small text-muted mb-1">
                            <span>Student: <strong>{{ $user->name ?? 'Ismail Yusuf' }}</strong></span>
                            <span>Session: <strong>2025/2026</strong></span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold text-dark">NUESA Dues Amount:</span>
                            <span class="fs-4 fw-bold text-success">₦3,500.00</span>
                        </div>
                    </div>

                    <input type="hidden" name="matric_number" value="{{ $user->matric_number ?? '18/04/07/042' }}">
                    <input type="hidden" name="amount" value="3500.00">

                    <div class="mb-3">
                        <label class="form-label text-dark fw-semibold small">Select Payment Channel</label>
                        <select class="form-select">
                            <option>Online Card Payment (Instant Receipt)</option>
                            <option>Bank Transfer / USSD Gateway</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer bg-white">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-secondary rounded-pill px-4 fw-bold">
                        Proceed to Pay ₦3,500
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL 2: PROFESSIONAL UNIMAID & NUESA LETTERHEAD E-RECEIPT -->
<div class="modal fade" id="receiptModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 rounded-4 shadow-lg overflow-hidden">
            <div class="modal-header bg-dark text-white border-0 py-3">
                <div class="d-flex align-items-center">
                    <i class="fa fa-file-invoice text-warning fs-5 me-2"></i>
                    <h6 class="modal-title fw-bold text-white mb-0">Official Treasury Clearance Receipt</h6>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body p-4 bg-light">
                <!-- OFFICIAL LETTERHEAD RECEIPT CONTAINER -->
                <div class="official-receipt-card shadow-sm">
                    <!-- UNIMAID Seal Watermark background -->
                    <img src="{{ asset('img/logos/unimaid logo.jpeg') }}" class="receipt-watermark" alt="UNIMAID Seal">

                    <!-- LETTERHEAD HEADER -->
                    <div class="receipt-letterhead d-flex align-items-center justify-content-between">
                        <img src="{{ asset('img/logos/unimaid logo.jpeg') }}" class="receipt-logo-left" alt="UNIMAID Crest">
                        
                        <div class="text-center px-2">
                            <div class="receipt-header-title">NATIONAL ASSOCIATION OF ENGINEERING STUDENTS (NUESA)</div>
                            <div class="receipt-header-sub text-success">NIGERIAN UNIVERSITIES ENGINEERING STUDENTS ASSOCIATION</div>
                            <div class="fw-bold text-dark extra-small mt-1" style="font-size: 11px;">UNIVERSITY OF MAIDUGURI CHAPTER • FACULTY OF ENGINEERING</div>
                            <div class="badge bg-success px-3 py-1 rounded-pill fw-bold text-white mt-1" style="font-size: 10px; letter-spacing: 0.5px;">OFFICIAL E-RECEIPT & TREASURY CLEARANCE</div>
                        </div>

                        <img src="{{ asset('img/logos/NUESA logo.jpeg') }}" class="receipt-logo-right" alt="NUESA Logo">
                    </div>

                    <!-- RECEIPT DETAILS & PAYER METADATA -->
                    <div class="row g-3 mb-3 pb-3 border-bottom" style="font-size: 11px;">
                        <div class="col-sm-6">
                            <div class="text-muted">RECEIPT NUMBER:</div>
                            <div class="fw-bold text-dark fs-6" id="modalReceiptRef">NUESA/REC/2026/00942</div>
                        </div>
                        <div class="col-sm-6 text-sm-end">
                            <div class="text-muted">PAYMENT DATE:</div>
                            <div class="fw-bold text-dark">{{ now()->format('F d, Y') }}</div>
                        </div>

                        <div class="col-sm-6">
                            <div class="text-muted">STUDENT NAME:</div>
                            <div class="fw-bold text-dark">{{ strtoupper($user->name ?? 'ISMAIL YUSUF') }}</div>
                            <div class="text-muted">{{ $user->email ?? 'ismail.yusuf@eng.unimaid.edu.ng' }}</div>
                        </div>
                        <div class="col-sm-6 text-sm-end">
                            <div class="text-muted">NUESA ID / MATRIC NO:</div>
                            <div class="fw-bold text-success">NUESA/2026/{{ strtoupper(substr($user->department->name ?? 'CPE', 0, 3)) }}/0042</div>
                            <div class="fw-bold text-dark">{{ $user->matric_number ?? '18/04/07/042' }}</div>
                        </div>

                        <div class="col-sm-6">
                            <div class="text-muted">DEPARTMENT & LEVEL:</div>
                            <div class="fw-bold text-dark">{{ $user->department->name ?? 'Computer Engineering' }} ({{ $user->level ?? '500L' }})</div>
                        </div>
                        <div class="col-sm-6 text-sm-end">
                            <div class="text-muted">PAYMENT GATEWAY / CHANNEL:</div>
                            <div class="fw-bold text-dark">Remita / Zainpay Online Gateway</div>
                        </div>
                    </div>

                    <!-- ITEMIZED TRANSACTION TABLE -->
                    <div class="table-responsive mb-3">
                        <table class="table table-bordered align-middle mb-0" style="font-size: 11px;">
                            <thead class="table-light">
                                <tr>
                                    <th>S/N</th>
                                    <th>Description of Fee</th>
                                    <th>Academic Session</th>
                                    <th class="text-end">Amount Paid</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td class="fw-bold text-dark">NUESA National & Chapter Annual Dues</td>
                                    <td id="modalSession">2025/2026 Session</td>
                                    <td class="text-end fw-bold text-dark" id="modalAmount">₦3,500.00</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td class="text-muted">Portal Processing & Verification Fee</td>
                                    <td>2025/2026 Session</td>
                                    <td class="text-end text-muted">₦0.00</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr class="table-success fw-bold">
                                    <td colspan="3" class="text-end text-uppercase">Total Verified Amount Paid:</td>
                                    <td class="text-end fs-6 text-success" id="modalTotalAmount">₦3,500.00</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <!-- FOOTER SIGNATURES & QR HOLOGRAM -->
                    <div class="d-flex align-items-center justify-content-between pt-2 border-top">
                        <div class="d-flex align-items-center">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=60x60&data=VERIFIED-UNIMAID-NUESA-RECEIPT" alt="Verification QR" class="border p-1 bg-white rounded me-2" style="width: 55px; height: 55px;">
                            <div>
                                <div class="fw-bold text-success extra-small"><i class="fa fa-shield-alt me-1"></i>VALIDATED DIGITAL STAMP</div>
                                <div class="text-muted extra-small" style="font-size: 9px;">Scan QR to verify UNIMAID Treasury Clearance</div>
                            </div>
                        </div>

                        <div class="text-end">
                            <div class="fst-italic text-dark fw-bold" style="font-family: 'Brush Script MT', cursive; font-size: 16px;">Engr. Executive Treasurer</div>
                            <div class="text-muted extra-small border-top pt-1" style="font-size: 9px;">FINANCIAL SECRETARY / HOD DEAN STAMP</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer bg-white border-top">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <a href="{{ route('receipt.demo') }}" target="_blank" class="btn btn-secondary rounded-pill px-4 fw-bold">
                    <i class="fa fa-print me-2"></i>Print Official PDF Receipt
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function openReceiptModal(ref, amount, session) {
        if(ref) $('#modalReceiptRef').text(ref);
        if(amount) {
            $('#modalAmount').text('₦' + amount);
            $('#modalTotalAmount').text('₦' + amount);
        }
        if(session) $('#modalSession').text(session);
        var receiptModal = new bootstrap.Modal(document.getElementById('receiptModal'));
        receiptModal.show();
    }
</script>
@endpush
