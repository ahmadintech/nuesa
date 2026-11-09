<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $departments = Department::all();

        return view('dashboard.profile', compact('user', 'departments'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'matric_number' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:50',
            'level' => 'nullable|string|max:50',
            'state_of_origin' => 'nullable|string|max:100',
            'department_id' => 'nullable|exists:departments,id',
            'avatar' => 'nullable|image|max:2048',
        ]);

        if ($user) {
            $data = [
                'name' => $validated['name'],
                'matric_number' => $validated['matric_number'] ?? $user->matric_number,
                'phone' => $validated['phone'] ?? $user->phone,
                'academic_class' => $validated['level'] ?? $user->academic_class ?? $user->level,
                'state_of_origin' => $validated['state_of_origin'] ?? $user->state_of_origin,
                'department_id' => $validated['department_id'] ?? $user->department_id,
            ];

            if ($request->hasFile('avatar')) {
                if ($user->profile_photo_path && Storage::disk('public')->exists($user->profile_photo_path)) {
                    Storage::disk('public')->delete($user->profile_photo_path);
                }
                $path = $request->file('avatar')->store('profile-photos', 'public');
                $data['profile_photo_path'] = $path;
            }

            $user->update($data);
        }

        return redirect()->route('student.profile')->with('success', 'Profile information updated successfully!');
    }
}
