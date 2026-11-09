<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StaffDirectory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StaffController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'office_number' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'department_id' => 'nullable|exists:departments,id',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
        ]);

        $photoPath = 'img/team-1.jpg';
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('staff', $fileName, 'public');
            $photoPath = 'storage/staff/' . $fileName;
        }

        StaffDirectory::create([
            'name' => $validated['name'],
            'designation' => $validated['designation'],
            'office_number' => $validated['office_number'],
            'email' => $validated['email'],
            'department_id' => $validated['department_id'] ?? null,
            'photo_path' => $photoPath,
        ]);

        return redirect()->back()->with('success', 'Academic/Admin staff member profile saved successfully!');
    }

    public function destroy($id)
    {
        $staff = StaffDirectory::findOrFail($id);
        
        if ($staff->photo_path && str_contains($staff->photo_path, 'storage/staff/')) {
            $relativePath = str_replace('storage/staff/', 'staff/', $staff->photo_path);
            Storage::disk('public')->delete($relativePath);
        }

        $staff->delete();

        return redirect()->back()->with('success', 'Staff profile deleted successfully!');
    }
}
