<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_name' => 'required|string|max:255',
            'matric_number' => 'required|string|max:100',
            'category' => 'required|string|max:100',
            'amount' => 'required|numeric|min:0',
            'channel' => 'required|string|max:100',
        ]);

        $user = User::where('matric_number', $validated['matric_number'])->first();
        if (!$user) {
            $user = User::where('name', $validated['student_name'])->first();
        }

        $ref = 'NUESA-2025-' . rand(100, 999);

        Payment::create([
            'uuid' => $ref,
            'user_id' => $user ? $user->id : auth()->id(),
            'amount' => $validated['amount'],
            'academic_session' => '2025/2026',
            'payment_type' => $validated['category'],
            'payment_channel' => $validated['channel'],
            'reference' => $ref,
            'status' => 'successful',
            'paid_at' => now(),
        ]);

        if ($user) {
            $user->dues_status = 'paid';
            $user->save();
        }

        return redirect()->back()->with('success', "Manual payment record {$ref} recorded and verified successfully!");
    }

    public function approve($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->status = 'successful';
        $payment->paid_at = now();
        $payment->save();

        if ($payment->user) {
            $payment->user->dues_status = 'paid';
            $payment->user->save();
        }

        return redirect()->back()->with('success', "Transaction {$payment->reference} approved and verified successfully!");
    }

    public function destroy($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->delete();

        return redirect()->back()->with('success', 'Transaction record deleted successfully.');
    }
}
