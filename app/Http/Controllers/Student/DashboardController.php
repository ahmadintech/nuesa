<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\AcademicResource;
use App\Models\NewsPost;
use App\Models\Payment;
use App\Models\User;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $user = auth()->user()->load('department');
        $recentPayments = Payment::where('user_id', $user->id)->latest()->take(3)->get();
        $recentNews = NewsPost::where('is_published', true)->latest('published_at')->take(2)->get();
        $resourcesCount = AcademicResource::count();

        return view('dashboard.index', compact('user', 'recentPayments', 'recentNews', 'resourcesCount'));
    }
}
