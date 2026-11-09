<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\ElectionBallot;
use App\Models\ElectionCandidate;
use App\Models\ElectionVote;
use App\Models\SiteSetting;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ElectionsController extends Controller
{
    private function electionParams(): array
    {
        $settings = SiteSetting::whereIn('key', [
            'election_title', 'election_session', 'election_date', 'election_officer',
            'election_start_time', 'election_end_time', 'election_status',
        ])->pluck('value', 'key');

        return [
            'title' => $settings['election_title'] ?? 'NUESA UNIMAID General Elections 2025/2026',
            'session' => $settings['election_session'] ?? '2025/2026 Session',
            'date' => $settings['election_date'] ?? '2026-10-25',
            'officer' => $settings['election_officer'] ?? 'Engr. Dr. Mustapha Hassan',
            'start_time' => $settings['election_start_time'] ?? '08:00',
            'end_time' => $settings['election_end_time'] ?? '17:00',
            'status' => strtoupper($settings['election_status'] ?? 'LIVE'),
        ];
    }

    public function index()
    {
        $user = Auth::user()->load('department');
        $electionParams = $this->electionParams();
        $candidates = ElectionCandidate::orderBy('id')->get();

        $ballot = ElectionBallot::where('user_id', $user->id)->first();
        $myVotes = $ballot
            ? ElectionVote::with('candidate')->where('user_id', $user->id)->get()
            : collect();

        // Results are only ever exposed once the election has concluded.
        $resultsVisible = $electionParams['status'] === 'CONCLUDED';

        return view('dashboard.elections', compact(
            'user', 'candidates', 'electionParams', 'ballot', 'myVotes', 'resultsVisible'
        ));
    }

    public function vote(Request $request)
    {
        $user = Auth::user();
        $back = redirect()->route('student.elections');

        $status = $this->electionParams()['status'];
        if ($status !== 'LIVE') {
            return $back->with('error', 'Voting is currently ' . strtolower($status) . ' by the Electoral Commission.');
        }

        if ($user->hasVoted()) {
            return $back->with('error', 'You have already submitted your ballot. Votes cannot be changed.');
        }

        $candidates = ElectionCandidate::all();
        $offices = $candidates->pluck('office')->unique()->values();

        if ($offices->isEmpty()) {
            return $back->with('error', 'There are no candidates on the ballot yet.');
        }

        $choices = (array) $request->input('choices', []);
        $selected = [];

        foreach ($offices as $office) {
            $candidateId = $choices[$office] ?? null;
            $candidate = $candidates->first(fn ($c) => (string) $c->id === (string) $candidateId && $c->office === $office);

            if (!$candidate) {
                return $back->withInput()->with('error', "Please select one candidate for the office of {$office} before submitting.");
            }
            $selected[$office] = $candidate;
        }

        try {
            DB::transaction(function () use ($user, $selected) {
                // Unique index on user_id makes a double submission fail atomically.
                ElectionBallot::create(['user_id' => $user->id, 'submitted_at' => now()]);

                foreach ($selected as $office => $candidate) {
                    ElectionVote::create([
                        'user_id' => $user->id,
                        'election_candidate_id' => $candidate->id,
                        'office' => $office,
                    ]);
                    $candidate->increment('votes');
                }
            });
        } catch (QueryException $e) {
            return $back->with('error', 'You have already submitted your ballot. Votes cannot be changed.');
        }

        return $back->with('success', 'Your ballot has been submitted and recorded successfully. Thank you for voting!');
    }
}
