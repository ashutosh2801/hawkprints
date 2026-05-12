<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = AdminNotification::latest()->paginate(20);
        return view('admin.notifications.index', compact('notifications'));
    }

    public function unread()
    {
        $count = AdminNotification::unread()->count();
        $notifications = AdminNotification::unread()->latest()->take(5)->get();
        return response()->json(compact('count', 'notifications'));
    }

    public function markRead($id)
    {
        $notification = AdminNotification::findOrFail($id);
        $notification->markAsRead();
        return response()->json(['success' => true]);
    }

    public function markAllRead()
    {
        AdminNotification::unread()->update(['is_read' => true, 'read_at' => now()]);
        if (request()->expectsJson() || request()->ajax()) {
            return response()->json(['success' => true]);
        }
        return redirect()->back()->with('success', 'All notifications marked as read.');
    }

    public function destroy($id)
    {
        AdminNotification::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }
}
