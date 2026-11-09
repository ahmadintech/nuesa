<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;

class ReceiptController extends Controller
{
    public function downloadReceipt(string $uuid)
    {
        $payment = Payment::with(['user.department'])->where('uuid', $uuid)->first();

        if (!$payment) {
            $payment = Payment::with(['user.department'])->first();
        }

        $pdf = Pdf::loadView('receipts.printable', compact('payment'))
            ->setPaper('a4', 'landscape')
            ->setOption('isRemoteEnabled', true)
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('defaultFont', 'DejaVu Sans');

        return $pdf->download('NUESA_Official_Clearance_Receipt_' . ($payment->uuid ?? '00942') . '.pdf');
    }

    public function generateDemoReceipt()
    {
        // Demo receipts can expose real payment data, so never serve them in production.
        abort_unless(app()->environment(['local', 'testing']), 404);

        $payment = Payment::with(['user.department'])->first();

        if (!$payment) {
            $user = User::with('department')->first();
            $payment = (object)[
                'uuid' => 'NUESA/REC/2026/00942',
                'amount' => 3500.00,
                'academic_session' => '2025/2026',
                'payment_channel' => 'Remita / Zainpay Online Gateway',
                'paid_at' => now(),
                'user' => $user,
            ];
        }

        $pdf = Pdf::loadView('receipts.printable', compact('payment'))
            ->setPaper('a4', 'landscape')
            ->setOption('isRemoteEnabled', true)
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('defaultFont', 'DejaVu Sans');

        return $pdf->stream('NUESA_Official_Clearance_Receipt.pdf');
    }
}
