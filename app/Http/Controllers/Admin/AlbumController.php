<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\StudentAlbum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AlbumController extends Controller
{
    public function index()
    {
        $albums = StudentAlbum::with('department')->latest()->get();
        $departments = Department::all();

        return view('admin.album', compact('albums', 'departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_name' => 'required|string|max:255',
            'student_id_number' => 'nullable|string|max:100',
            'department_id' => 'nullable|exists:departments,id',
            'academic_class' => 'required|string|max:255',
            'position_role' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'state_of_origin' => 'nullable|string|max:100',
            'joined_date' => 'nullable|string|max:100',
            'verification_status' => 'required|string|in:verified,to_be_verified',
            'filter_tag' => 'required|string|max:50',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $imagePath = $request->file('image')->store('albums', 'public');

        StudentAlbum::create([
            'student_name' => $request->student_name,
            'student_id_number' => $request->student_id_number,
            'department_id' => $request->department_id,
            'academic_class' => $request->academic_class,
            'position_role' => $request->position_role,
            'phone' => $request->phone,
            'email' => $request->email,
            'state_of_origin' => $request->state_of_origin,
            'joined_date' => $request->joined_date,
            'verification_status' => $request->verification_status,
            'filter_tag' => $request->filter_tag,
            'image_path' => 'storage/' . $imagePath,
        ]);

        return redirect()->back()->with('success', 'Student album profile added successfully!');
    }

    public function destroy($id)
    {
        $album = StudentAlbum::findOrFail($id);

        if ($album->image_path && !str_starts_with($album->image_path, 'img/')) {
            $relativePath = str_replace('storage/', '', $album->image_path);
            Storage::disk('public')->delete($relativePath);
        }

        $album->delete();

        return redirect()->back()->with('success', 'Student album profile removed successfully!');
    }
}
