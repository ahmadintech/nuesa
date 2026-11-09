<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'department_id' => 'nullable|exists:departments,id',
            'student_role' => 'nullable|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $imagePath = 'img/project-1.jpg';
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('gallery', $fileName, 'public');
            $imagePath = 'storage/gallery/' . $fileName;
        }

        GalleryItem::create([
            'title' => $validated['title'],
            'category' => strtolower($validated['category']),
            'department_id' => $validated['department_id'] ?? null,
            'student_role' => $validated['student_role'] ?? null,
            'image_path' => $imagePath,
            'verification_status' => 'verified',
        ]);

        return redirect()->back()->with('success', 'Photo added to gallery album successfully!');
    }

    public function destroy($id)
    {
        $item = GalleryItem::findOrFail($id);
        
        if ($item->image_path && str_contains($item->image_path, 'storage/gallery/')) {
            $relativePath = str_replace('storage/gallery/', 'gallery/', $item->image_path);
            Storage::disk('public')->delete($relativePath);
        }

        $item->delete();

        return redirect()->back()->with('success', 'Gallery item deleted successfully!');
    }
}
