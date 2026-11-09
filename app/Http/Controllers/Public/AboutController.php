<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\ExcoMember;
use App\Models\SiteSetting;

class AboutController extends Controller
{
    public function __invoke()
    {
        $excos = ExcoMember::with('department')->ordered()->get();
        $departments = Department::all();
        $settings = SiteSetting::all()->pluck('value', 'key');
        $president = $excos->first(function ($e) {
            $pos = strtolower($e->office_position);
            return str_contains($pos, 'president') && !str_contains($pos, 'vice');
        }) ?? $excos->first();

        return view('about', compact('excos', 'departments', 'settings', 'president'));
    }
}
