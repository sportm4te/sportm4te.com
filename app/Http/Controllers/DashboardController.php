<?php
/**
 * @copyright Sport M4te s.r.o. 2021 - present
 */

namespace App\Http\Controllers;

use App\Models\User\Event;
use App\Models\User\EventRegistration;
use App\Models\User\Friend;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard(Request $request) {
        $stats = [
            'total' => auth()->user()->hosting()->count(),
            'accept' => auth()->user()->hosting()->whereHas('registrations')->count(),
            'waiting' => auth()->user()->hosting()->doesntHave('registrations')->count(),
        ];

        $user = $request->user();

        $upcomingEvent = auth()->user()->upcomingEvents;

        $eventRequests = EventRegistration::with(['event.place.timezone', 'event.category', 'user'])->whereHas('event', function($q) use ($user) {
            $q->where('user_id', $user->id);
        })->whereNull('approved')->get();

        $eventResponses = EventRegistration::with(['event.place.timezone', 'event.category', 'user'])->whereNull('seen')->whereHas('event', function($q) use ($user) {
            $q->where('privacy', Event::PRIVACY_PRIVATE);
        })->where('user_id', $user->id)->whereNotNull('approved')->get();

        $friendRequests = Friend::with('requester')->where('friend_id', $user->id)->whereNull('confirmed')->get();

        $name = $request->user()->formatName();

        return view('user.dashboard', get_defined_vars());
    }
}
