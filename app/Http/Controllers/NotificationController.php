<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class NotificationController extends Controller
{
    public function read($notificationId)
    {
        $notification = Auth::user()->unreadNotifications()->findOrFail($notificationId);

        $notification->markAsRead();

        return redirect()->back();
    }

}
