<?php
/**
 * @copyright Sport M4te s.r.o. 2021 - present
 */

namespace App\Http\Controllers\Api;

use App\Models\User\Event;
use App\Models\User\EventRegistration;
use App\Models\User\Friend;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class DashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        $user = $request->user();

        $stats = [
            'total'   => $user->hosting()->count(),
            'accept'  => $user->hosting()->whereHas('registrations')->count(),
            'waiting' => $user->hosting()->doesntHave('registrations')->count(),
        ];

        $upcomingEvent = $user->upcomingEvents;

        $eventRequests = EventRegistration::with(['event.place.timezone', 'event.category', 'user'])->whereHas('event', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->whereNull('approved')->get();

        $eventResponses = EventRegistration::with(['event.place.timezone', 'event.category', 'user'])->whereNull('seen')->whereHas('event', function ($q) use ($user) {
            $q->where('privacy', Event::PRIVACY_PRIVATE);
        })->where('user_id', $user->id)->whereNotNull('approved')->get();

        $friendRequests = Friend::with('requester')->where('friend_id', $user->id)->whereNull('confirmed')->get();

        return [
            'stats'   => $stats,
            'events'  => [
                'upcoming'  => $upcomingEvent,
                'requests'  => $eventRequests,
                'responses' => $eventResponses,
            ],
            'friends' => [
                'requests' => $friendRequests,
            ],
        ];
    }
}
