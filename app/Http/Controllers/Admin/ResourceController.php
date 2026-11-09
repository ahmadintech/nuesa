<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ResourceController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'course_code' => 'required|string|max:100',
            'category' => 'required|string|max:100',
            'department_id' => 'required|exists:departments,id',
            'document' => 'required|file|mimes:pdf,doc,docx|max:15360',
        ]);

        $filePath = '#';
        $fileSize = '0 MB';
        if ($request->hasFile('document')) {
            $file = $request->file('document');
            $sizeBytes = $file->getSize();
            $fileSize = round($sizeBytes / 1048576, 2) . ' MB';
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('resources', $fileName, 'public');
            $filePath = 'storage/resources/' . $fileName;
        }

        AcademicResource::create([
            'title' => $validated['title'],
            'course_code' => strtoupper($validated['course_code']),
            'category' => $validated['category'],
            'department_id' => $validated['department_id'],
            'file_path' => $filePath,
            'file_size' => $fileSize,
        ]);

        return redirect()->back()->with('success', 'PDF resource uploaded to course vault successfully!');
    }

    public function destroy($id)
    {
        $res = AcademicResource::findOrFail($id);
        
        if ($res->file_path && str_contains($res->file_path, 'storage/resources/')) {
            $relativePath = str_replace('storage/resources/', 'resources/', $res->file_path);
            Storage::disk('public')->delete($relativePath);
        }

        $res->delete();

        return redirect()->back()->with('success', 'Course resource deleted successfully!');
    }
}
