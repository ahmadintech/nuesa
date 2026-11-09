<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DuesController extends Controller
{
    public function index()
    {
        $user = Auth::user()->load('department');
        $payments = Payment::where('user_id', $user->id)->latest()->get();
        $latestPayment = $payments->first();

        return view('dashboard.dues', compact('user', 'payments', 'latestPayment'));
    }

    /**
     * Online dues payment is temporarily disabled. No payment record is created
     * and the student's dues/clearance status is left untouched.
     */
    public function payDues(Request $request)
    {
        return redirect()->route('student.dues')
            ->with('error', 'Payment is unavailable right now. Please try again later.');
    }
}
