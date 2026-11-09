<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PortalNotification;
use App\Models\User;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = PortalNotification::with('user')->latest()->get();
        $users = User::orderBy('name')->get();

        return view('admin.notifications.index', compact('notifications', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'type' => 'required|string|in:info,success,warning,danger',
            'user_id' => 'nullable|exists:users,id',
        ]);

        $notification = PortalNotification::create([
            'title' => $request->title,
            'message' => $request->message,
            'type' => $request->type,
            'user_id' => $request->user_id,
            'is_read' => false,
        ]);

        return redirect()->route('admin.notifications.index')
            ->with('success', 'Portal notification broadcasted successfully!')
            ->with('broadcast_title', $notification->title)
            ->with('broadcast_message', $notification->message);
    }

    public function destroy($id)
    {
        $notification = PortalNotification::findOrFail($id);
        $notification->delete();

        return redirect()->route('admin.notifications.index')->with('success', 'Notification deleted successfully.');
    }
}

