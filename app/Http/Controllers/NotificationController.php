<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        abort_unless(auth()->user()->hasAnyRole(['Admin', 'Manager', 'Driver']), 403);

        $notifications = Notification::where('user_id', auth()->id())->orWhereNull('user_id')->latest()->paginate(20);
        $unreadCount = Notification::where(fn ($q) => $q->where('user_id', auth()->id())->orWhereNull('user_id'))->where('is_read', false)->count();
        return view('notifications.index', compact('notifications', 'unreadCount'));
    }

    public function show(Notification $notification)
    {
        abort_unless(auth()->user()->hasAnyRole(['Admin', 'Manager', 'Driver']), 403);
        abort_unless($notification->user_id === null || $notification->user_id === auth()->id(), 403);
        $notification->update(['is_read' => true]);
        return view('notifications.show', compact('notification'));
    }

    public function update(Request $request, Notification $notification)
    {
        abort_unless(auth()->user()->hasAnyRole(['Admin', 'Manager', 'Driver']), 403);
        abort_unless($notification->user_id === null || $notification->user_id === auth()->id(), 403);
        $notification->update(['is_read' => true]);
        return back()->with('success', 'تم تحديد الإشعار كمقروء.');
    }

    public function markAllRead()
    {
        abort_unless(auth()->user()->hasAnyRole(['Admin', 'Manager', 'Driver']), 403);
        Notification::where(fn ($q) => $q->where('user_id', auth()->id())->orWhereNull('user_id'))->update(['is_read' => true]);
        return back()->with('success', 'تم تعليم جميع الإشعارات كمقروءة.');
    }
}
