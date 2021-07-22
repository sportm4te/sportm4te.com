<?php
/**
 * @copyright Sport M4te s.r.o. 2021 - present
 */

namespace App\Http\Controllers\Api;

use App\Management\ApiResponse;
use App\Models\User;
use App\Models\User\Friend;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class FriendController extends Controller
{
    private ApiResponse $response;

    public function __construct(ApiResponse $apiResponse)
    {
        $this->response = $apiResponse;
    }

    public function requestFriend(User $user)
    {
        if (auth()->id() !== $user->id) {
            $friend = new Friend();
            $friend->user_id = auth()->id();
            $friend->friend_id = $user->id;
            $friend->save();
        }

        return $this->response->basicResponse([
            'friend' => $user->toArray(),
            'message' => 'Friend request has been sent!',
            'icon' => 'fa fa-user-clock',
        ]);
    }

    public function requestRespondFriend(User $user, Request $request)
    {
        switch ($request->get('action')) {
            case "remove":
                return $this->removeFriend($user);
            case "confirm":
                return $this->confirmFriend($user);
        }

        return $this->response->error('Invalid friend request action.');
    }

    private function findFriendship(User $friend)
    {
        return Friend::where(function ($q) use ($friend) {
            $q->where('friend_id', $friend->id);
            $q->where('user_id', auth()->id());
        })->orWhere(function ($q) use ($friend) {
            $q->where('user_id', $friend->id);
            $q->where('friend_id', auth()->id());
        })->first();
    }

    public function removeFriend(User $friend)
    {
        $friendship = $this->findFriendship($friend);

        if ($friendship) {
            $friendship->delete();
        }

        $message = 'Friend has been removed!';

        if ($friendship->user_id === auth()->id()) {
            $message = 'Friend request has been cancelled!';
        }

        return $this->response->basicResponse([
            'message' => $message
        ]);
    }

    public function confirmFriend(User $friend)
    {
        $friendship = $this->findFriendship($friend);

        if ($friendship && auth()->id() === $friendship->friend_id) {
            $friendship->confirmed = true;
            $friendship->save();
        }

        return $this->response->basicResponse([
            'message' => 'Friend request has been confirmed!',
        ]);
    }
}
