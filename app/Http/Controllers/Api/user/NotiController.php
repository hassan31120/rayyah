<?php

namespace App\Http\Controllers\Api\user;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotiResource;
use App\Models\Client;
use App\Models\PushNotification;
use Carbon\Carbon;

class NotiController extends Controller
{
    public function index()
    {
        $user = Client::find(auth()->id());
        $notifications = PushNotification::where('client_id', $user->id)->get();
        return response()->json([
            'success' => true,
            'notifications' => NotiResource::collection($notifications),
        ], 200);
    }

    public function markNotificationAsRead($notificationId)
    {
        $notification = PushNotification::findOrFail($notificationId);

        $user = Client::find(auth()->id());

        if ($notification->client_id != $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'this is not your notification'
            ], 404);
        }
        // Check if the notification is already marked as read
        if ($notification->read_at === null) {
            $notification->read_at = Carbon::now();
            $notification->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'notification has been read successfully',
        ], 200);
    }

    public function markAllNotificationsAsRead()
    {
        $user = Client::find(auth()->id());

        if (!$user) {
            return response()->json([
                'success' => false,
                'mwssage' => 'there is no such user'
            ], 404);
        }

        // Get the unread notifications for the user
        $unreadNotifications = PushNotification::where('client_id', $user->id)
            ->whereNull('read_at')
            ->get();

        if ($unreadNotifications->isEmpty()) {
            return response()->json([
                'success' => true,
                'mwssage' => 'No unread notifications found'
            ], 200);
        }

        // Update the read_at timestamp for all unread notifications
        $unreadNotifications->each(function ($notification) {
            $notification->read_at = Carbon::now();
            $notification->save();
        });

        return response()->json([
            'success' => true,
            'mwssage' => 'All notifications marked as read'
        ], 200);
    }
}
