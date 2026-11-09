<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\StaffDirectory;

class TeamController extends Controller
{
    public function __invoke()
    {
        $staff = StaffDirectory::with('department')->where('is_active', true)->get();

        return view('team', compact('staff'));
    }
}
