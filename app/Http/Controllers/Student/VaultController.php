<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\AcademicResource;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VaultController extends Controller
{
    public function index()
    {
        $resources = AcademicResource::with('department')->latest()->get();
        $departments = Department::all();

        return view('dashboard.vault', compact('resources', 'departments'));
    }
}
