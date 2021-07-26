<?php
/**
 * @copyright SportM4te 2021 - present
 */

namespace App\Http\Controllers\Api;

use App\Exceptions\RestrictedException;
use App\Http\Requests\ReviewRequest;
use App\Models\User;
use App\Models\User\Event;
use App\Models\User\Review;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class ProfileController extends Controller
{
    public function review(User $user, ReviewRequest $request)
    {
        if (!$user->canAddReview()) {
            throw new RestrictedException();
        }

        $review = Review::firstOrNew([
            'author_id' => $request->user()->id,
            'user_id'   => $user->id,
        ]);
        $review->stars = $request->get('rating');
        $review->review = $request->get('review');

        $user->reviews()->save($review);

        return new JsonResponse([
            'event'   => $review->toArray(),
            'message' => 'Review has been saved!',
            'redirect' => $user->link(),
        ]);
    }

    public function profile(string $username)
    {
        /**
         * @var User $user
         */
        $user = User::where('username', $username)->firstOrFail();

        $user->load(['sports.sport', 'reviews', 'reviews.author']);

        $friendState = $user->formatFriendState();
        $canAddReview = $user->canAddReview();
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
