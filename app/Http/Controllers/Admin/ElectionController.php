<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ElectionCandidate;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class ElectionController extends Controller
{
    public function index()
    {
        $candidates = ElectionCandidate::latest()->get();

        $settings = SiteSetting::whereIn('key', [
            'election_title',
            'election_session',
            'election_date',
            'election_officer',
            'election_start_time',
            'election_end_time',
            'election_status',
        ])->pluck('value', 'key');

        $electionParams = [
            'title' => $settings['election_title'] ?? 'NUESA UNIMAID General Elections 2025/2026',
            'session' => $settings['election_session'] ?? '2025/2026 Session',
            'date' => $settings['election_date'] ?? '2026-10-25',
            'officer' => $settings['election_officer'] ?? 'Engr. Dr. Mustapha Hassan',
            'start_time' => $settings['election_start_time'] ?? '08:00',
            'end_time' => $settings['election_end_time'] ?? '17:00',
            'status' => $settings['election_status'] ?? 'LIVE',
        ];

        return view('admin.elections', compact('candidates', 'electionParams'));
    }

    public function storeCandidate(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'office' => 'required|string|max:255',
            'matric_number' => 'nullable|string|max:100',
            'department' => 'required|string|max:255',
            'level' => 'required|string|max:50',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $photoPath = 'img/team-1.jpg';
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('candidates', $fileName, 'public');
            $photoPath = 'storage/candidates/' . $fileName;
        }

        ElectionCandidate::create([
            'name' => $validated['name'],
            'office' => $validated['office'],
            'matric_number' => $validated['matric_number'] ?? null,
            'department' => $validated['department'],
            'level' => $validated['level'],
            'photo' => $photoPath,
            'manifesto' => 'Fostering digital innovation, industrial internship placements, and enhanced student welfare.',
            'votes' => 0,
        ]);

        return redirect()->back()->with('success', 'Election candidate published successfully!');
    }

    public function updateCandidate(Request $request, $id)
    {
        $candidate = ElectionCandidate::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'office' => 'required|string|max:255',
            'matric_number' => 'nullable|string|max:100',
            'department' => 'required|string|max:255',
            'level' => 'required|string|max:50',
        ]);

        $candidate->update($validated);

        return redirect()->back()->with('success', 'Candidate profile updated successfully!');
    }

    public function destroyCandidate($id)
    {
        $candidate = ElectionCandidate::findOrFail($id);
        $candidate->delete();

        return redirect()->back()->with('success', 'Candidate removed from ballot successfully!');
    }

    public function updateParameters(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'session' => 'required|string|max:100',
            'date' => 'required|date',
            'officer' => 'required|string|max:255',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        SiteSetting::set('election_title', $validated['title']);
        SiteSetting::set('election_session', $validated['session']);
        SiteSetting::set('election_date', $validated['date']);
        SiteSetting::set('election_officer', $validated['officer']);
        SiteSetting::set('election_start_time', $validated['start_time']);
        SiteSetting::set('election_end_time', $validated['end_time']);

        return redirect()->back()->with('success', 'Election parameters updated successfully!');
    }

    public function resetVotes()
    {
        \Illuminate\Support\Facades\DB::transaction(function () {
            \App\Models\ElectionVote::query()->delete();
            \App\Models\ElectionBallot::query()->delete();
            ElectionCandidate::query()->update(['votes' => 0]);
        });
        return redirect()->back()->with('success', 'All votes and ballots have been cleared; voters may vote again.');
    }

    public function updateStatus(Request $request)
    {
        $validated = $request->validate([
            'status' => 'required|string|in:LIVE,PAUSED,CONCLUDED',
        ]);

        SiteSetting::set('election_status', $validated['status']);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'status' => $validated['status'],
                'message' => 'Voting status updated to ' . $validated['status'],
            ]);
        }

        return redirect()->back()->with('success', 'Election status updated to ' . $validated['status']);
    }
}
