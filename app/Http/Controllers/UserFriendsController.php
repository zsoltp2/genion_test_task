<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserFriends;
use App\Notifications\AcceptedRequestNotification;
use App\Notifications\FriendRequestNotification;
use App\Notifications\RejectedRequestNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserFriendsController extends Controller
{
    public function friends(Request $request)
    {
        $authUser = auth()->user();

        $acceptedFriends = UserFriends::where(function ($query) use ($authUser) {
            $query->where('user_id', $authUser->id)
                ->orWhere('friend_id', $authUser->id);
        })->where('status', 'accepted')->get();

        $friendIds = $acceptedFriends->map(function ($friendship) use ($authUser) {
            return $friendship->user_id === $authUser->id
                ? $friendship->friend_id
                : $friendship->user_id;
        });

        $users = User::where('id', '!=', $authUser->id)
            ->whereNotIn('id', $friendIds)
            ->get();

        $friends = User::whereIn('id', $friendIds)->get();

        $incomingFriends = $authUser->receivedRequests()->with('user')->get();

        return view('friends', [
            'users' => $users,
            'friends' => $friends,
            'incomingRequests' => $incomingFriends,
        ]);
    }


    public function friendsRequests(User $user)
    {
        $sender_id = Auth::id();
        $receiver_id = $user->id;

        $receiver = User::find($receiver_id);

        if ($sender_id == $receiver_id) {
            return back()->with('error', 'You cannot send a friend request to yourself!');
        }
        $existingRequest = UserFriends::where(function($query) use ($sender_id, $receiver_id) {
            $query->where('user_id', $sender_id)
                ->where('friend_id', $receiver_id);
        })->orWhere(function($query) use ($sender_id, $receiver_id) {
            $query->where('user_id', $receiver_id)
                ->where('friend_id', $sender_id);
        })->where('status', '!=', 'rejected')->first();


        if ($existingRequest) {
            return back()->with('error', 'You have already sent a friend request or are already friends!');
        }
        UserFriends::create([
            'user_id' => $sender_id,
            'friend_id' => $receiver_id,
            'status' => 'sent',
        ]);

        return back()->with('success', 'Friend request sent!');
    }

    public function acceptFriendRequest(UserFriends $friendRequest)
    {
        if ($friendRequest->friend_id !== Auth::id()) {
            return back()->with('error', 'You are not the recipient of this request.');
        }

        $friendRequest->status = 'accepted';
        $friendRequest->save();

        $user = User::find($friendRequest->user_id);
        $requested_friend = User::find($friendRequest->friend_id);

        $user->notify(new AcceptedRequestNotification($requested_friend->name));

        return back()->with('success', 'Friend request accepted!');
    }

    public function rejectFriendRequest(UserFriends $friendRequest)
    {
        if ($friendRequest->friend_id !== Auth::id()) {
            return back()->with('error', 'You are not the recipient of this request.');
        }

        $friendRequest->status = 'rejected';
        $friendRequest->delete();

        $user = User::find($friendRequest->user_id);
        $requested_friend = User::find($friendRequest->friend_id);

        $user->notify(new RejectedRequestNotification($requested_friend->name));

        return back()->with('success', 'Friend request rejected.');
    }
}
