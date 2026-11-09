@extends('layouts.admin')

@section('title', 'Broadcast Portal Notifications - NUESA Admin')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1"><i class="fa fa-bullhorn text-success me-2"></i>Send Student Portal Notification</h3>
            <p class="text-muted small mb-0">Broadcast real-time system alerts, election notices, and clearance updates to student dashboards.</p>
        </div>
    </div>



    <div class="row g-4">
        <!-- SEND NOTIFICATION FORM CARD -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-dark text-white p-3 border-0">
                    <h6 class="mb-0 fw-bold text-white"><i class="fa fa-paper-plane me-2 text-warning"></i>Broadcast New Alert</h6>
                </div>
                <div class="card-body p-4 bg-white">
                    <form action="{{ route('admin.notifications.send') }}" method="POST" id="broadcastForm">
                        @csrf
                        <div class="mb-4">
                            <label for="notifTitle" class="form-label fw-semibold text-dark small d-flex align-items-center mb-2">
                                <span class="material-symbols-outlined text-primary me-2" style="font-size: 20px;">title</span>
                                Notification Title
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted px-3 py-3" style="border-top-left-radius: 16px; border-bottom-left-radius: 16px;">
                                    <span class="material-symbols-outlined" style="font-size: 20px;">notifications_active</span>
                                </span>
                                <input type="text" name="title" id="notifTitle" class="form-control bg-light border-start-0 py-3 fs-6" style="border-top-right-radius: 16px; border-bottom-right-radius: 16px;" placeholder="e.g. NUESA Elections Live" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="notifMessage" class="form-label fw-semibold text-dark small d-flex align-items-center mb-2">
                                <span class="material-symbols-outlined text-primary me-2" style="font-size: 20px;">chat</span>
                                Alert Message / Content
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted px-3 py-3" style="border-top-left-radius: 16px; border-bottom-left-radius: 16px;">
                                    <span class="material-symbols-outlined" style="font-size: 20px;">description</span>
                                </span>
                                <textarea name="message" id="notifMessage" rows="3" class="form-control bg-light border-start-0 py-3 fs-6" style="border-top-right-radius: 16px; border-bottom-right-radius: 16px;" placeholder="e.g. Voting poll is open for 2025/2026 Executive Council." required></textarea>
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="notifType" class="form-label fw-semibold text-dark small d-flex align-items-center mb-2">
                                    <span class="material-symbols-outlined text-primary me-2" style="font-size: 20px;">palette</span>
                                    Alert Type
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted px-3 py-3" style="border-top-left-radius: 16px; border-bottom-left-radius: 16px;">
                                        <span class="material-symbols-outlined" style="font-size: 20px;">style</span>
                                    </span>
                                    <select name="type" id="notifType" class="form-select bg-light border-start-0 py-3 fs-6" style="border-top-right-radius: 16px; border-bottom-right-radius: 16px;">
                                        <option value="info">Info (Blue)</option>
                                        <option value="success">Success (Green)</option>
                                        <option value="warning">Warning (Yellow)</option>
                                        <option value="danger">Danger (Red)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="notifTarget" class="form-label fw-semibold text-dark small d-flex align-items-center mb-2">
                                    <span class="material-symbols-outlined text-primary me-2" style="font-size: 20px;">person_search</span>
                                    Target Student
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted px-3 py-3" style="border-top-left-radius: 16px; border-bottom-left-radius: 16px;">
                                        <span class="material-symbols-outlined" style="font-size: 20px;">groups</span>
                                    </span>
                                    <select name="user_id" id="notifTarget" class="form-select bg-light border-start-0 py-3 fs-6" style="border-top-right-radius: 16px; border-bottom-right-radius: 16px;">
                                        <option value="">All Students (Global)</option>
                                        @foreach($users as $u)
                                            <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->matric_number ?? 'Student' }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary px-4 py-3 fw-bold shadow-sm d-inline-flex align-items-center justify-content-center w-100 fs-6" style="border-radius: 50px; background: linear-gradient(135deg, #008751 0%, #006038 100%); border: none;">
                            <span class="material-symbols-outlined me-2" style="font-size: 22px;">campaign</span>
                            Send Broadcast Alert
                        </button>
                    </form>
                </div>
            </div>
        </div>


        <!-- SENT NOTIFICATIONS HISTORY TABLE -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-white p-3 border-bottom d-flex align-items-center justify-content-between">
                    <h6 class="mb-0 fw-bold text-dark"><i class="fa fa-history me-2 text-primary"></i>Sent Broadcast History</h6>
                    <span class="badge bg-primary rounded-pill">{{ count($notifications) }} Total Sent</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Title</th>
                                    <th>Message</th>
                                    <th>Target</th>
                                    <th>Type</th>
                                    <th>Sent Time</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($notifications as $notif)
                                    <tr>
                                        <td class="fw-bold text-dark">{{ $notif->title }}</td>
                                        <td class="small text-muted" style="max-width: 200px;">{{ $notif->message }}</td>
                                        <td>
                                            @if($notif->user)
                                                <span class="badge bg-secondary-subtle text-dark">{{ $notif->user->name }}</span>
                                            @else
                                                <span class="badge bg-success-subtle text-success">All Students</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $notif->type == 'info' ? 'primary' : ($notif->type == 'success' ? 'success' : ($notif->type == 'warning' ? 'warning text-dark' : 'danger')) }} rounded-pill">
                                                {{ strtoupper($notif->type) }}
                                            </span>
                                        </td>
                                        <td class="small text-muted">{{ $notif->created_at ? $notif->created_at->diffForHumans() : 'Now' }}</td>
                                        <td class="text-end">
                                            <form action="{{ route('admin.notifications.destroy', $notif->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this notification broadcast?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-light btn-sm rounded-circle text-danger" title="Delete Notification">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted">No notifications sent yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Request Browser Notification Permission on page load
    document.addEventListener('DOMContentLoaded', function() {
        if ("Notification" in window && Notification.permission !== "granted" && Notification.permission !== "denied") {
            Notification.requestPermission();
        }
    });

    // Play Sound Chime using Web Audio API
    function playNotificationChime() {
        try {
            const ctx = new (window.AudioContext || window.webkitAudioContext)();
            const osc = ctx.createOscillator();
            const gain = ctx.createGain();
            osc.type = 'sine';
            osc.frequency.setValueAtTime(523.25, ctx.currentTime); // C5
            osc.frequency.exponentialRampToValueAtTime(880, ctx.currentTime + 0.15); // A5
            gain.gain.setValueAtTime(0.4, ctx.currentTime);
            gain.gain.exponentialRampToValueAtTime(0.01, ctx.currentTime + 0.4);
            osc.connect(gain);
            gain.connect(ctx.destination);
            osc.start();
            osc.stop(ctx.currentTime + 0.4);
        } catch(e) {
            console.log('Audio chime error:', e);
        }
    }

    // Trigger Browser Desktop Notification
    function showBrowserDesktopNotification(title, body) {
        playNotificationChime();
        if ("Notification" in window && Notification.permission === "granted") {
            new Notification("NUESA Portal Alert: " + title, {
                body: body,
                icon: "{{ asset('img/logos/NUESA logo.jpeg') }}"
            });
        }
    }

    @if(session('broadcast_title'))
        showBrowserDesktopNotification("{{ session('broadcast_title') }}", "{{ session('broadcast_message') }}");
    @endif
</script>
@endpush
@endsection
