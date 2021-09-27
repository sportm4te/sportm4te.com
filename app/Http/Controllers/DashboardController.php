<?php
/**
 * @copyright Sport M4te s.r.o. 2021 - present
 */

namespace App\Http\Controllers;

use App\Models\User\Event;
use App\Models\User\EventRegistration;
use App\Models\User\Friend;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard(Request $request) {
        $id = Auth::id();

        $tutorial_status = DB::table('tutorial')->get()->where('user_id','=',"$id")->count();
        if($tutorial_status == null) {
            return redirect('/tutorial');
        }
        else{

        $my_sports = DB::table('user_sport')->get()->where('user_id','=',"$id")->count();
        if($my_sports == null) {
            return redirect('https://app.sportm4te.com/sport-choose');
        }
        else{

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
}
}
