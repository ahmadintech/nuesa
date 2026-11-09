<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Official Treasury Clearance Receipt - NUESA UNIMAID</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 8mm;
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            color: #0f172a;
            background-color: #ffffff;
            margin: 0;
            padding: 0;
            font-size: 11px;
        }
        .receipt-card {
            border: none;
            padding: 0;
            position: relative;
            background: #ffffff;
        }
        .watermark {
            position: absolute;
            top: 40%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-30deg);
            opacity: 0.05;
            width: 320px;
            z-index: 0;
        }
        .header-table {
            width: 100%;
            border-bottom: 2px solid #008751;
            padding-bottom: 10px;
            margin-bottom: 16px;
        }
        .logo-img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 50%;
        }
        .header-text {
            text-align: center;
        }
        .header-text .title-main {
            font-size: 12px;
            font-weight: bold;
            color: #000000;
            letter-spacing: 0.3px;
        }
        .header-text .title-sub {
            font-size: 11px;
            font-weight: bold;
            color: #008751;
            margin-top: 2px;
        }
        .header-text .title-faculty {
            font-size: 9.5px;
            font-weight: bold;
            color: #334155;
            margin-top: 2px;
        }
        .clearance-badge {
            background-color: #008751;
            color: #ffffff;
            font-weight: bold;
            padding: 4px 14px;
            border-radius: 15px;
            font-size: 9.5px;
            display: inline-block;
            margin-top: 6px;
            letter-spacing: 0.5px;
        }
        .meta-table {
            width: 100%;
            margin-bottom: 16px;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 12px;
        }
        .meta-table td {
            vertical-align: top;
            padding: 4px 0;
            font-size: 10.5px;
        }
        .meta-label {
            color: #64748b;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .meta-val {
            font-weight: bold;
            color: #0f172a;
            font-size: 11px;
        }
        .meta-val-green {
            font-weight: bold;
            color: #008751;
            font-size: 11px;
        }
        .item-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .item-table th, .item-table td {
            border: 1px solid #cbd5e1;
            padding: 8px 10px;
            font-size: 10.5px;
        }
        .item-table th {
            background-color: #f1f5f9;
            color: #334155;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 9.5px;
        }
        .total-row {
            background-color: #f0fdf4;
            font-weight: bold;
        }
        .total-row td {
            border-top: 2px solid #008751;
            color: #008751;
            font-size: 11.5px;
        }
        .footer-table {
            width: 100%;
            margin-top: 20px;
            border-top: 1px solid #e2e8f0;
            padding-top: 12px;
        }
        .qr-img {
            width: 55px;
            height: 55px;
            border: 1px solid #cbd5e1;
            padding: 2px;
            border-radius: 4px;
        }
        .sig-font {
            font-family: 'DejaVu Sans', sans-serif;
            font-style: italic;
            font-size: 14px;
            color: #008751;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="receipt-card">
    <!-- WATERMARK LOGO -->
    <img src="{{ public_path('img/logos/unimaid logo.jpeg') }}" class="watermark" alt="UNIMAID Seal">

    <!-- HEADER SECTION -->
    <table class="header-table">
        <tr>
            <td width="15%" align="left">
                <img src="{{ public_path('img/logos/unimaid logo.jpeg') }}" class="logo-img" alt="UNIMAID Crest">
            </td>
            <td width="70%" class="header-text">
                <div class="title-main">NATIONAL ASSOCIATION OF ENGINEERING STUDENTS (NUESA)</div>
                <div class="title-sub">NIGERIAN UNIVERSITIES ENGINEERING STUDENTS ASSOCIATION</div>
                <div class="title-faculty">UNIVERSITY OF MAIDUGURI CHAPTER • FACULTY OF ENGINEERING</div>
                <div>
                    <span class="clearance-badge">OFFICIAL E-RECEIPT & TREASURY CLEARANCE</span>
                </div>
            </td>
            <td width="15%" align="right">
                <img src="{{ public_path('img/logos/NUESA logo.jpeg') }}" class="logo-img" alt="NUESA Logo">
            </td>
        </tr>
    </table>

    <!-- PAYER & METADATA SECTION -->
    <table class="meta-table">
        <tr>
            <td width="50%">
                <div class="meta-label">RECEIPT NUMBER:</div>
                <div class="meta-val">{{ $payment->uuid ?? 'NUESA/REC/2026/00942' }}</div>
            </td>
            <td width="50%" align="right">
                <div class="meta-label">PAYMENT DATE:</div>
                <div class="meta-val">{{ $payment->paid_at ? $payment->paid_at->format('F d, Y • h:i A') : date('F d, Y') }}</div>
            </td>
        </tr>
        <tr>
            <td width="50%">
                <div class="meta-label">STUDENT NAME:</div>
                <div class="meta-val">{{ strtoupper($payment->user->name ?? 'COMR. ISMAIL ISAH YUSUF') }}</div>
                <div style="font-size: 9.5px; color: #64748b;">{{ $payment->user->email ?? 'ismail.yusuf@eng.unimaid.edu.ng' }}</div>
            </td>
            <td width="50%" align="right">
                <div class="meta-label">NUESA ID / MATRIC NO:</div>
                <div class="meta-val-green">NUESA/2026/{{ $payment->user->department->code ?? 'CIV' }}/0042</div>
                <div class="meta-val">{{ $payment->user->matric_number ?? '18/04/01/0101' }}</div>
            </td>
        </tr>
        <tr>
            <td width="50%">
                <div class="meta-label">DEPARTMENT & LEVEL:</div>
                <div class="meta-val">{{ $payment->user->department->name ?? 'Civil & Water Resources Engineering' }} ({{ $payment->user->academic_class ?? '500L' }})</div>
            </td>
            <td width="50%" align="right">
                <div class="meta-label">PAYMENT GATEWAY / CHANNEL:</div>
                <div class="meta-val">{{ $payment->payment_channel ?? 'Remita / Zainpay Online Gateway' }}</div>
            </td>
        </tr>
    </table>

    <!-- ITEMIZED TRANSACTION TABLE -->
    <table class="item-table">
        <thead>
            <tr>
                <th width="8%">S/N</th>
                <th width="52%">Description of Fee</th>
                <th width="20%">Academic Session</th>
                <th width="20%" align="right">Amount Paid</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td><strong>NUESA National & Chapter Annual Dues</strong></td>
                <td>{{ $payment->academic_session ?? '2025/2026' }}</td>
                <td align="right"><strong>&#8358;{{ number_format($payment->amount ?? 3500, 2) }}</strong></td>
            </tr>
            <tr>
                <td>2</td>
                <td style="color: #64748b;">Portal Processing & Verification Fee</td>
                <td>{{ $payment->academic_session ?? '2025/2026' }}</td>
                <td align="right" style="color: #64748b;">&#8358;0.00</td>
            </tr>
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="3" align="right">TOTAL VERIFIED AMOUNT PAID:</td>
                <td align="right">&#8358;{{ number_format($payment->amount ?? 3500, 2) }}</td>
            </tr>
        </tfoot>
    </table>

    <!-- FOOTER SIGNATURE & QR HOLOGRAM -->
    <table class="footer-table">
        <tr>
            <td width="60%">
                <table cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="padding-right: 10px; vertical-align: middle;">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=VERIFIED-UNIMAID-NUESA-RECEIPT-{{ $payment->uuid ?? 'NUESA-2026-98401' }}" class="qr-img" alt="QR Stamp">
                        </td>
                        <td style="vertical-align: middle;">
                            <div style="font-weight: bold; color: #008751; font-size: 10px;">VALIDATED DIGITAL STAMP</div>
                            <div style="font-size: 8.5px; color: #64748b;">Scan QR to verify UNIMAID Treasury Clearance</div>
                        </td>
                    </tr>
                </table>
            </td>
            <td width="40%" align="right" style="vertical-align: bottom;">
                <div style="height: 35px;"></div>
                <div style="border-top: 1px solid #cbd5e1; width: 160px; display: inline-block;"></div>
            </td>
        </tr>
    </table>
</div>

</body>
</html>
