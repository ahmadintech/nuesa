<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExcoMember;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ExcoController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'office_position' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'twitter_handle' => 'nullable|string|max:255',
            'linkedin_url' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
        ]);

        $photoPath = 'img/team-1.jpg';
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('excos', $fileName, 'public');
            $photoPath = 'storage/excos/' . $fileName;
        }

        // Determine default sort order based on position
        $pos = strtolower($validated['office_position']);
        $sortOrder = 99;
        if (str_contains($pos, 'president') && !str_contains($pos, 'vice')) {
            $sortOrder = 1;
        } elseif (str_contains($pos, 'vice president') || str_contains($pos, 'vice-president')) {
            $sortOrder = 2;
        } elseif (str_contains($pos, 'secretary general') || str_contains($pos, 'general secretary')) {
            $sortOrder = 3;
        } elseif (str_contains($pos, 'financial secretary')) {
            $sortOrder = 4;
        }

        $exco = ExcoMember::create([
            'name' => $validated['name'],
            'office_position' => $validated['office_position'],
            'department_id' => $validated['department_id'],
            'twitter_handle' => $validated['twitter_handle'] ?? null,
            'linkedin_url' => $validated['linkedin_url'] ?? null,
            'photo_path' => $photoPath,
            'sort_order' => $sortOrder,
            'academic_session' => '2025/2026',
        ]);

        // Sync with President Welcome Address if this is President
        if ($sortOrder === 1) {
            SiteSetting::set('about_president_name', $exco->name);
            SiteSetting::set('about_president_photo', $exco->photo_path);
        }

        return redirect()->back()->with('success', 'Executive officer profile created successfully!');
    }

    public function update(Request $request, $id)
    {
        $exco = ExcoMember::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'office_position' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'twitter_handle' => 'nullable|string|max:255',
            'linkedin_url' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
        ]);

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('excos', $fileName, 'public');
            $validated['photo_path'] = 'storage/excos/' . $fileName;
        }

        $exco->update($validated);

        // Sync with President Welcome Address if position is President
        $pos = strtolower($exco->office_position);
        if (str_contains($pos, 'president') && !str_contains($pos, 'vice')) {
            SiteSetting::set('about_president_name', $exco->name);
            if (isset($validated['photo_path'])) {
                SiteSetting::set('about_president_photo', $validated['photo_path']);
            }
        }

        return redirect()->back()->with('success', 'Executive officer profile updated successfully!');
    }

    public function destroy($id)
    {
        $exco = ExcoMember::findOrFail($id);

        if ($exco->photo_path && str_contains($exco->photo_path, 'storage/excos/')) {
            $storagePath = str_replace('storage/', '', $exco->photo_path);
            Storage::disk('public')->delete($storagePath);
        }

        $exco->delete();

        return redirect()->back()->with('success', 'Executive officer profile removed successfully!');
    }
}
