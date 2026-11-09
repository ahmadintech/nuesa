<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\User;

class DigitalIdController extends Controller
{
    public function __invoke()
    {
        $user = auth()->user()->load('department');

        return view('dashboard.digital-id', compact('user'));
    }
}
