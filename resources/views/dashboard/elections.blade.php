@extends('layouts.student')

@section('title', 'Elections & Voting - NUESA Student Portal')

@push('styles')
<style>
    .candidate-card {
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        transition: all 0.25s ease-in-out;
        background: #ffffff;
        overflow: hidden;
    }
    .candidate-option { cursor: pointer; }
    .candidate-option input:checked + .candidate-card { border-color: #008751; box-shadow: 0 0 0 3px rgba(0,135,81,.25); background: #f0fbf6; }
    .candidate-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.08);
        border-color: #008751;
    }
</style>
@endpush

@section('content')
<!-- ALERT MESSAGES -->
@if(session('success'))
    <div class="alert alert-success rounded-3 p-3 mb-4 shadow-sm">
        <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger rounded-3 p-3 mb-4 shadow-sm">
        <i class="fa fa-exclamation-triangle me-2"></i>{{ session('error') }}
    </div>
@endif

<!-- ELECTIONS HERO HEADER -->
<div class="dash-card p-4 p-lg-5 mb-4 position-relative overflow-hidden" style="background: linear-gradient(135deg, #004d2e 0%, #008751 100%); color: #fff; border-radius: 24px;">
    <div class="row align-items-center g-4">
        <div class="col-lg-8">
            <div class="d-inline-flex align-items-center bg-white text-dark px-3 py-1 rounded-pill mb-3 small fw-bold shadow-sm" style="letter-spacing: 0.3px;">
                <span class="material-symbols-outlined text-success me-2" style="font-size: 18px;">how_to_vote</span> {{ strtoupper($electionParams['title']) }}
            </div>
            <h2 class="display-6 text-white fw-bold mb-2">NUESA E-Voting Portal</h2>
            <p class="text-white-50 mb-3 fs-6">
                Exercise your right to vote for the leadership of the Faculty of Engineering. Session: <strong>{{ $electionParams['session'] }}</strong>.
            </p>
            <div class="d-flex flex-wrap gap-2 align-items-center">
                <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold">
                    <i class="fa fa-check-circle me-1"></i> Accredited Voter: {{ $user->name ?? 'Student' }} ({{ $user->academic_class ?? '' }} {{ strtoupper(substr($user->department->name ?? 'ENG', 0, 3)) }})
                </span>

                @if(strtoupper($electionParams['status']) === 'LIVE')
                    <span class="badge bg-success text-white px-3 py-2 rounded-pill fw-bold">
                        <i class="fa fa-dot-circle me-1"></i> POLLS LIVE
                    </span>
                @elseif(strtoupper($electionParams['status']) === 'PAUSED')
                    <span class="badge bg-danger text-white px-3 py-2 rounded-pill fw-bold">
                        <i class="fa fa-pause-circle me-1"></i> POLLS PAUSED
                    </span>
                @else
                    <span class="badge bg-secondary text-white px-3 py-2 rounded-pill fw-bold">
                        <i class="fa fa-flag-checkered me-1"></i> CONCLUDED
                    </span>
                @endif
            </div>
        </div>

        <div class="col-lg-4">
            <div class="p-4 rounded-4 backdrop-blur text-center border border-white border-opacity-25" style="background: rgba(255, 255, 255, 0.12); box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);">
                <div class="text-white-50 extra-small text-uppercase fw-bold mb-3 d-flex align-items-center justify-content-center" style="letter-spacing: 1px;">
                    <span class="material-symbols-outlined me-1 text-warning" style="font-size: 18px;">timer</span>
                    Voting Schedule
                </div>
                
                <div class="text-center mb-3">
                    <div class="fs-4 fw-bold text-white mb-1">{{ \Carbon\Carbon::parse($electionParams['date'])->format('M d, Y') }}</div>
                    <div class="extra-small text-warning fw-bold">{{ $electionParams['start_time'] }} - {{ $electionParams['end_time'] }}</div>
                </div>

                <div class="extra-small text-white-50 fw-semibold border-top border-white border-opacity-25 pt-2">
                    Electoral Officer: <strong>{{ $electionParams['officer'] }}</strong>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- TABS & NAVIGATION -->
@if($resultsVisible)
<ul class="nav nav-pills mb-4 gap-2 border-bottom pb-3" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active rounded-pill px-4 fw-bold" data-bs-toggle="tab" data-bs-target="#ballot" type="button" role="tab">
            <i class="fa fa-vote-yea me-2"></i>My Ballot
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link rounded-pill px-4 fw-bold bg-white text-dark border" data-bs-toggle="tab" data-bs-target="#results" type="button" role="tab">
            <i class="fa fa-chart-bar me-2"></i>Final Results
        </button>
    </li>
</ul>
@endif

@php
    $groupedCandidates = $candidates->groupBy('office');
    $isLive = $electionParams['status'] === 'LIVE';
@endphp

<div class="tab-content">
    <div class="tab-pane fade show active" id="ballot" role="tabpanel">

    @if($ballot)
        {{-- ALREADY VOTED: show the recorded choices --}}
        <div class="dash-card p-4 p-lg-5 mb-4 bg-white border">
            <div class="d-flex align-items-center mb-3">
                <span class="material-symbols-outlined text-success me-2 fs-2">task_alt</span>
                <div>
                    <h5 class="fw-bold text-dark mb-0">Your ballot has been submitted</h5>
                    <div class="text-muted extra-small">Submitted {{ $ballot->submitted_at->format('M d, Y \a\t h:i A') }}. Votes are final and cannot be changed.</div>
                </div>
            </div>
            <div class="row g-3">
                @foreach($myVotes as $vote)
                    @if($vote->candidate)
                    <div class="col-md-6 col-lg-4">
                        <div class="border rounded-4 p-3 d-flex align-items-center bg-light">
                            <img src="{{ asset($vote->candidate->photo) }}" class="rounded-circle me-3" style="width:56px;height:56px;object-fit:cover;" alt="">
                            <div>
                                <div class="extra-small text-muted text-uppercase fw-bold">{{ $vote->office }}</div>
                                <div class="fw-bold text-dark">{{ $vote->candidate->name }}</div>
                            </div>
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
            @unless($resultsVisible)
                <p class="extra-small text-muted mt-4 mb-0"><i class="fa fa-lock me-1"></i>Results will be published after the election has concluded.</p>
            @endunless
        </div>

    @elseif(!$isLive)
        <div class="alert alert-warning rounded-4 p-4 text-center mb-4">
            <i class="fa {{ $electionParams['status'] === 'CONCLUDED' ? 'fa-flag-checkered' : 'fa-pause-circle' }} fs-3 text-warning mb-2 d-block"></i>
            <h5 class="fw-bold text-dark">Voting is {{ $electionParams['status'] === 'CONCLUDED' ? 'Closed' : 'Currently Paused' }}</h5>
            <p class="text-muted mb-0 extra-small">
                @if($electionParams['status'] === 'CONCLUDED')
                    The election has ended. You did not submit a ballot.
                @else
                    Ballot submissions are temporarily closed by the Electoral Commission. Results will be published after the election ends.
                @endif
            </p>
        </div>

    @elseif($groupedCandidates->isEmpty())
        <div class="dash-card p-5 text-center bg-white border">
            <span class="material-symbols-outlined text-muted fs-1 mb-2">how_to_vote</span>
            <h5 class="fw-bold text-dark mb-1">No Accredited Candidates Found</h5>
            <p class="text-muted extra-small mb-0">Candidate profiles will appear here once published by the Electoral Commission admin.</p>
        </div>

    @else
        {{-- BALLOT FORM: pick one candidate per office, review, then submit once --}}
        <form action="{{ route('student.elections.vote') }}" method="POST" id="ballotForm">
            @csrf
            <div class="alert alert-info rounded-4 small mb-4">
                <i class="fa fa-info-circle me-1"></i>
                Select <strong>one candidate for every office</strong>, then click <strong>Review &amp; Submit</strong>. You can only submit your ballot once and results stay hidden until the election ends.
            </div>

            @foreach($groupedCandidates as $office => $officeCandidates)
                <div class="mb-5 office-block" data-office="{{ $office }}">
                    <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-2">
                        <h5 class="fw-bold text-dark mb-0">Office of the {{ $office }}</h5>
                        <span class="badge bg-light text-muted border px-3 py-1 rounded-pill extra-small">Select 1 Candidate</span>
                    </div>
                    <div class="row g-4">
                        @foreach($officeCandidates as $candidate)
                            <div class="col-md-6 col-lg-4">
                                <label class="candidate-option d-block h-100 w-100">
                                    <input type="radio" class="d-none candidate-radio" name="choices[{{ $office }}]" value="{{ $candidate->id }}"
                                           data-name="{{ $candidate->name }}" data-img="{{ asset($candidate->photo) }}"
                                           {{ (string) old('choices.' . $office) === (string) $candidate->id ? 'checked' : '' }}>
                                    <div class="candidate-card p-4 h-100 text-center">
                                        <img src="{{ asset($candidate->photo) }}" alt="{{ $candidate->name }}" class="rounded-circle shadow-sm border border-3 border-success mb-3" style="width:110px;height:110px;object-fit:cover;">
                                        <div><span class="badge bg-success-subtle text-success rounded-pill px-3 py-1 extra-small fw-bold mb-2">{{ strtoupper($candidate->department) }} • {{ $candidate->level }}</span></div>
                                        <h5 class="fw-bold text-dark mb-1">{{ $candidate->name }}</h5>
                                        @if($candidate->matric_number)
                                            <div class="small text-muted fw-semibold mb-2">Matric: {{ $candidate->matric_number }}</div>
                                        @endif
                                        <p class="extra-small text-muted mb-0 fst-italic">"{{ Str::limit($candidate->manifesto, 100) }}"</p>
                                    </div>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach

            <div class="text-center mb-5">
                <button type="button" id="reviewBtn" class="btn btn-success btn-lg rounded-pill px-5 fw-bold">
                    <i class="fa fa-clipboard-check me-2"></i>Review &amp; Submit Ballot
                </button>
                <div id="ballotError" class="text-danger small mt-2 d-none"></div>
            </div>

            <!-- REVIEW MODAL -->
            <div class="modal fade" id="reviewModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 rounded-4 shadow-lg overflow-hidden">
                        <div class="modal-header bg-dark text-white py-3 px-4">
                            <h5 class="modal-title text-white fw-bold mb-0"><i class="fa fa-vote-yea text-success me-2"></i>Review Your Choices</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-4">
                            <ul class="list-group list-group-flush mb-3" id="reviewList"></ul>
                            <div class="alert alert-warning py-2 extra-small rounded-3 mb-0">
                                <i class="fa fa-exclamation-triangle me-1"></i> Once submitted, your ballot is final and cannot be changed.
                            </div>
                        </div>
                        <div class="modal-footer bg-light border-top py-3 px-4">
                            <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Go Back &amp; Edit</button>
                            <button type="submit" id="submitBallot" class="btn btn-success rounded-pill px-4 fw-bold">
                                <i class="fa fa-check-circle me-2"></i>Confirm &amp; Submit
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @endif

    </div>

    @if($resultsVisible)
    <div class="tab-pane fade" id="results" role="tabpanel">
        <div class="dash-card p-4 p-lg-5 mb-4">
            <div class="mb-4 border-bottom pb-3">
                <h4 class="fw-bold text-dark mb-1">Final Election Results</h4>
                <p class="text-muted small mb-0">The election has concluded. These are the official tallies.</p>
            </div>
            @foreach($groupedCandidates as $office => $officeCandidates)
                @php $total = $officeCandidates->sum('votes'); $topVotes = $officeCandidates->max('votes'); @endphp
                <div class="p-4 bg-light rounded-4 border mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold text-dark mb-0"><i class="fa fa-trophy text-success me-2"></i>{{ $office }}</h5>
                        <span class="badge bg-success px-3 py-1 rounded-pill">Total Votes: {{ number_format($total) }}</span>
                    </div>
                    @foreach($officeCandidates->sortByDesc('votes') as $candidate)
                        @php $percent = $total > 0 ? round(($candidate->votes / $total) * 100, 1) : 0; @endphp
                        <div class="mb-3">
                            <div class="d-flex justify-content-between small fw-bold text-dark mb-1">
                                <span>{{ $candidate->name }} ({{ strtoupper($candidate->department) }})
                                    @if($total > 0 && $candidate->votes === $topVotes)<span class="badge bg-warning text-dark ms-1">Winner</span>@endif
                                </span>
                                <span>{{ number_format($candidate->votes) }} Votes ({{ $percent }}%)</span>
                            </div>
                            <div class="progress" style="height: 14px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: {{ $percent }}%;">{{ $percent }}%</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('ballotForm');
        if (!form) return;
        const err = document.getElementById('ballotError');

        document.getElementById('reviewBtn').addEventListener('click', function () {
            const list = document.getElementById('reviewList');
            list.innerHTML = '';
            const missing = [];

            form.querySelectorAll('.office-block').forEach(function (block) {
                const office = block.dataset.office;
                const checked = block.querySelector('.candidate-radio:checked');
                if (!checked) { missing.push(office); return; }
                const li = document.createElement('li');
                li.className = 'list-group-item d-flex align-items-center px-0';
                const img = document.createElement('img');
                img.src = checked.dataset.img;
                img.className = 'rounded-circle me-3';
                img.style.cssText = 'width:44px;height:44px;object-fit:cover';
                const box = document.createElement('div');
                const o = document.createElement('div');
                o.className = 'extra-small text-muted text-uppercase fw-bold';
                o.textContent = office;
                const n = document.createElement('div');
                n.className = 'fw-bold text-dark';
                n.textContent = checked.dataset.name;
                box.append(o, n);
                li.append(img, box);
                list.appendChild(li);
            });

            if (missing.length) {
                err.textContent = 'Please select a candidate for: ' + missing.join(', ');
                err.classList.remove('d-none');
                return;
            }
            err.classList.add('d-none');
            new bootstrap.Modal(document.getElementById('reviewModal')).show();
        });

        // Prevent double-clicks from submitting twice.
        form.addEventListener('submit', function () {
            const btn = document.getElementById('submitBallot');
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Submitting...';
        });
    });
</script>
@endpush
