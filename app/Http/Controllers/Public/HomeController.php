<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\AcademicResource;
use App\Models\Department;
use App\Models\ExcoMember;
use App\Models\NewsPost;

class HomeController extends Controller
{
    public function __invoke()
    {
        $excos = ExcoMember::with('department')->orderBy('sort_order')->take(4)->get();
        $news = NewsPost::where('is_published', true)->latest('published_at')->take(3)->get();
        $stats = [
            'total_students' => 3450,
            'departments_count' => Department::count(),
            'active_excos' => ExcoMember::count(),
            'resources_count' => AcademicResource::count(),
        ];

        return view('index', compact('excos', 'news', 'stats'));
    }
}
