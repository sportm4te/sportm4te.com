<?php
/**
 * @copyright Sport M4te s.r.o. 2021 - present
 */

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\StoreScoreRequest;
use App\Http\Requests\StoreTeamRequest;
use App\Management\ApiResponse;
use App\Models\Event\Score;
use App\Models\Event\Team;
use App\Models\Event\TeamMember;
use App\Models\Management\Place;
use App\Models\Management\Timezone;
use App\Models\User\Event;
use App\Models\User\EventRecurring;
use App\Models\User\EventRegistration;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EventController extends Controller
{
    private ApiResponse $response;

    public function __construct(ApiResponse $apiResponse)
    {
        $this->response = $apiResponse;
    }

    public function createEvent(StoreEventRequest $request)
    {
        $event = new Event();
        $event->name = $request->get('name');
        $event->category_id = $request->get('category');
        $event->location = $request->get('location');
        $event->level = $request->get('level');
        $event->description = $request->get('description');
        $event->privacy = $request->get('privacy');
        if ($request->filled('deadline')) {
            $event->deadline = Carbon::parse($request->get('deadline'));
        }
        $event->registration_limit = $request->get('registration_limit');

        $place = Place::find($request->get('place_id'));
        if ($place !== null) {
            $place->saveMissingTimezone();
            $event->place_id = $place->id;
            $event->timezone_id = $place->timezone_id;
        }

        $event->timezone_id ??= $request->user()->timezone_id;
        $timezone = Timezone::find($event->timezone_id)->timezone;

        $event->start = Carbon::parse($request->get('start') . ' ' . $request->get('start_at'), $timezone)->utc();
        $event->end = Carbon::parse($request->get('end') . ' ' . $request->get('end_at'), $timezone)->utc();

        $request->user()->hosting()->save($event);

        $registration = new EventRegistration();
        $registration->user_id = $request->user()->id;
        $registration->approved = true;
        $event->registrations()->save($registration);

        if ($request->has('recurring')) {
            $recurring = new EventRecurring();
            $recurring->monday = $request->input('recurring_day.monday');
            $recurring->tuesday = $request->input('recurring_day.tuesday');
            $recurring->wednesday = $request->input('recurring_day.wednesday');
            $recurring->thursday = $request->input('recurring_day.thursday');
            $recurring->friday = $request->input('recurring_day.friday');
            $recurring->saturday = $request->input('recurring_day.saturday');
            $recurring->sunday = $request->input('recurring_day.sunday');
            $recurring->start = $request->get('recurring_start');
            $recurring->end = $request->get('recurring_end');

            $event->recurring()->save($recurring);
        }

        return $this->response->basicResponse([
            'event' => $event->toArray(),
            'message' => 'Event has been created!',
        ]);
    }

    public function removeEvent(Event $event)
    {
        if (!$event->isOwner()) {
            throw new NotFoundHttpException();
        }

        $event->delete();

        return $this->response->basicResponse([
            'event' => $event->toArray(),
            'message' => 'Event has been removed!',
        ]);
    }

    public function updateEvent(Event $event, StoreEventRequest $request)
    {
        if (!$event->isOwner()) {
            throw new NotFoundHttpException();
        }

        if (!$event->passed()) {
            $event->name = $request->get('name');
            $event->category_id = $request->get('category');
            $event->location = $request->get('location');
            $event->level = $request->get('level');
            $event->description = $request->get('description');
            $event->privacy = $request->get('privacy');
            if ($request->filled('deadline')) {
                $event->deadline = Carbon::parse($request->get('deadline'));
            } else {
                $event->deadline = null;
            }
            $event->registration_limit = $request->get('registration_limit');

            $place = Place::find($request->get('place_id'));
            if ($place !== null) {
                $place->saveMissingTimezone();
                $event->place_id = $place->id;
                $event->timezone_id = $place->timezone_id;
            }

            $event->timezone_id ??= $request->user()->timezone_id;
            $timezone = Timezone::find($event->timezone_id)->timezone;

            $event->start = Carbon::parse($request->get('start') . ' ' . $request->get('start_at'), $timezone)->utc();
            $event->end = Carbon::parse($request->get('end') . ' ' . $request->get('end_at'), $timezone)->utc();
            $event->save();
        }

        if ($request->hasFile('image')) {
            $request->file('image')
                ->move(storage_path(Event::COVERS_DIRECTORY), $event->getImageFileName());
        }

        if ($request->has('recurring')) {
            $recurring = $event->parent->recurring ?? $event->recurring ?? new EventRecurring();
            $recurring->monday = $request->input('recurring_day.monday');
            $recurring->tuesday = $request->input('recurring_day.tuesday');
            $recurring->wednesday = $request->input('recurring_day.wednesday');
            $recurring->thursday = $request->input('recurring_day.thursday');
            $recurring->friday = $request->input('recurring_day.friday');
            $recurring->saturday = $request->input('recurring_day.saturday');
            $recurring->sunday = $request->input('recurring_day.sunday');
            $recurring->start = $request->get('recurring_start');
            $recurring->end = $request->get('recurring_end');

            $event->recurring()->save($recurring);
        }

        return $this->response->basicResponse([
            'event' => $event->toArray(),
            'message' => 'Event has been updated!',
        ]);
    }

    public function hideRequest(Request $request)
    {
        $eventRegistration = EventRegistration::find($request->get('id'));

        if (!$eventRegistration || $eventRegistration->user_id !== auth()->id()) {
            return $this->response->error('Invalid ID.');
        }

        $eventRegistration->seen = true;
        $eventRegistration->save();

        return $this->response->basicResponse([
            'message' => 'Saved.',
        ]);
    }

    public function saveJoinRequest(Event $event, Request $request)
    {
        $member = $event->member((int)$request->get('user_id'));

        if (!$event->isOwner() || !$member) {
            return $this->response->error();
        }

        $member->approved = $request->get('action') > 0;
        $member->save();

        $message = 'You have declined this member.';
        if ($member->isApproved()) {
            $message = 'You have accepted this member.';
        }

        return $this->response->basicResponse([
            'member' => $member->toArray(),
            'message' => $message,
        ]);
    }

    public function createTeam(Event $event, StoreTeamRequest $request)
    {
        $team = new Team();
        $team->name = $request->get('name');

        $event->teams()->save($team);

        foreach (array_keys($request->get('members')) as $memberId) {
            $member = new TeamMember();
            $member->user_id = $memberId;
            $team->members()->save($member);
        }

        return $this->response->basicResponse([
            'event' => $event->toArray(),
            'message' => 'Team has been created.',
        ]);
    }

    public function saveEventScore(Event $event, StoreScoreRequest $request)
    {
        if (!$event->isOwner()) {
            return $this->response->error();
        }

        if ($request->get('team_id') > 0) {
            $team = $event->teams()->where('id', $request->get('team_id'))->first();
            $score = $team->score ?? new Score();
            $score->score = $request->get('score');
            $score->event_id = $event->id;


            if ($team) {
                $team->score()->save($score);
            }
        } elseif ($request->get('user_id') > 0) {
            $member = $event->registrations()->where('user_id', $request->get('user_id'))->first();
            $score = $member->score ?? new Score();
            $score->score = $request->get('score');
            $score->event_id = $event->id;


            if ($member) {
                $member->score()->save($score);
            }
        }

        return $this->response->basicResponse([
            'event' => $event->toArray(),
            'message' => 'Score has been saved!',
        ]);
    }

    public function registerEvent(Event $event, Request $request)
    {
        if ($event->isOwner()) {
            return $this->response->error();
        }

        if (!$request->has('leave')) {
            if ($event->deadlineReached()) {
               return $this->response->error('Event deadline has been reached!');
            }

            if ($event->quotaReached()) {
               return $this->response->error('The number of registrations has been reached.');
            }
        }

        $userId = auth()->id();
        $eventRegistration = EventRegistration::firstOrNew([
            'user_id' => $userId,
            'event_id' => $event->id,
        ]);

        if ($request->has('leave')) {
            TeamMember::where('user_id', $userId)->whereHas('team', function ($q) use ($event) {
                $q->where('event_id', $event->id);
            })->delete();
            $eventRegistration->delete();

            $message = 'You have left the event.';
            $icon = 'fa fa-door-open';
        } else {
            $eventRegistration->approved = $event->isPublic() ? true : null;
            $event->registrations()->save($eventRegistration);

            $message = 'You have been registered.';
            $icon = 'fa fa-star';

            if (!$eventRegistration->isApproved()) {
                $message = 'Join request has been sent.';
                $icon = 'fa fa-clock';
            }
        }

        return $this->response->basicResponse([
            'event' => $event->toArray(),
            'message' => $message,
            'icon' => $icon,
        ]);
    }
}
