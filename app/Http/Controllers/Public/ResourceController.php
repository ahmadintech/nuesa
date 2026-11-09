<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\AcademicResource;
use App\Models\Department;

class ResourceController extends Controller
{
    public function __invoke()
    {
        $resources = AcademicResource::with('department')->get();
        $departments = Department::all();

        return view('resources', compact('resources', 'departments'));
    }
}
