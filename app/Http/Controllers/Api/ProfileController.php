<?php
/**
 * @copyright SportM4te 2021 - present
 */

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\User\Event;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class ProfileController extends Controller
{
    public function profile(string $username)
    {
        /**
         * @var User $user
         */
        $user = User::where('username', $username)->firstOrFail();

        $user->load(['sports.sport', 'reviews.stars', 'reviews.author']);

        $friendState = $user->formatFriendState();
        $canAddReview = $user->hosting()->whereHas('registrations', function ($q) {
                $q->where('user_id', auth()->id());
            })->exists()
            || auth()->user()->hosting()->whereHas('registrations', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })->exists();
        $friends = collect([]);
        $privateEvents = [];

        if ($user->isOwner() || $friendState === User\Friend::ARE_FRIENDS) {
            $privateEvents = $user->hosting->where('privacy', Event::PRIVACY_PRIVATE);
            $friends = $user->friends();
        }

        return new JsonResponse([
            'user'        => $user->toArray(),
            'permissions' => [
                'review' => $canAddReview,
            ],
            'friends'     => [
                'state' => $friendState,
                'list'  => $friends,
            ],
            'reviews'     => [
                'received' => $user->reviews->toArray(),
            ],
            'events'      => [
                'public'  => $user->hosting->where('privacy', Event::PRIVACY_PUBLIC)->toArray(),
                'private' => $privateEvents,
            ],
        ]);
    }
}
