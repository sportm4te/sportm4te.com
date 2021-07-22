<?php
/**
 * @copyright Sport M4te s.r.o. 2021 - present
 */

namespace App\Models\User\Traits;

use Carbon\Carbon;
use Webpatser\Uuid\Uuid;

trait EventMethod
{
    public function toArray()
    {
        return [
            'id' => $this->id,
            'event' => $this->name,
            'description' => $this->description,
            'link' => $this->link(),
            'public' => $this->isPublic(),
            'location' => [
                'id' => $this->place->id,
                'lat' => $this->place->gps->getLat(),
                'lng' => $this->place->gps->getLng(),
                'formatted' => $this->location,
            ],
            'level' => [
                'id' => $this->level,
                'formatted' => $this->formatLevel(),
            ],
            'dates' => [
                'start' => $this->start,
                'end' => $this->end,
            ],
            'limits' => [
                'users' => $this->registration_limit,
                'deadline' => $this->deadline,
                'deadline_reached' => $this->deadlineReached(),
            ],
            'registrations' => [
                'limit' => $this->registrations()->count(),
                'reached' => $this->quotaReached(),
            ],
            'owner' => $this->user_id,
        ];
    }

    public function isPrivate()
    {
        return $this->privacy === self::PRIVACY_PRIVATE;
    }

    public function isPublic()
    {
        return $this->privacy === self::PRIVACY_PUBLIC
            || empty($this->privacy);
    }

    public function registerButtonText()
    {
        if ($this->isPublic()) {
            return 'Register';
        }
        return 'Request join';
    }

    public function link()
    {
        return route('events.detail', [$this->id]);
    }

    public function edit()
    {
        return route('events.edit', [$this->id]);
    }

    public function passed()
    {
        return $this->end->isBefore(Carbon::now());
    }

    public function deadlineTz()
    {
        return $this->deadline->clone()->shiftTimezone($this->place->timezone->timezone);
    }

    public function formatDeadline()
    {
        $user = Carbon::now()->tz(auth()->user()->timezone->timezone);

        return $this->deadline->format('jS F Y') . ' (' . $user->diffForHumans($this->deadlineTz()) . ' end)';
    }

    public function startTz()
    {
        return $this->start->clone()->shiftTimezone($this->place->timezone->timezone);
    }

    public function start()
    {
        return $this->start->clone()->setTimezone($this->place->timezone->timezone);
    }

    public function endTz()
    {
        return $this->end->clone()->shiftTimezone($this->place->timezone->timezone);
    }

    public function end()
    {
        return $this->end->clone()->setTimezone($this->place->timezone->timezone);
    }

    public function formatStartIn()
    {
        $user = Carbon::now()->tz(auth()->user()->timezone->timezone);

        return $user->diffForHumans($this->startTz());
    }

    public function formatLocation()
    {
        $location = $this->location;
        $distance = $this->calculateDistance();
        $unit = auth()->user()->formatUnit();

        if ($distance > 0.0 && $distance <= 18) {
            return sprintf('%s (%.2f %s from you)', $location, $distance, $unit);
        }

        return $location;
    }

    public function formatLevel()
    {
        if (!empty($this->level) && array_key_exists($this->level, self::LEVELS)) {
            return self::LEVELS[$this->level];
        }

        return null;
    }

    public function formatRegistrations()
    {
        $registrations = $this->registrations->count();

        if ($registrations > 0) {
            if ($registrations === 1) {
                return $registrations . ' registered member';
            }

            return $registrations . ' registered members';
        }

        return 'No members yet';
    }

    public function image()
    {
        if ($this->parent_id !== null) {
            return $this->parent->image();
        }

        if ($this->hasImage()) {
            return url(self::PUBLIC_COVERS_DIRECTORY . $this->getImageFileName()) . '?h=' . filemtime($this->path());
        }

        return $this->category->image();
    }

    public function register()
    {
        return route('api.events.register', [$this->id]);
    }

    public function membersWithoutTeam()
    {
        $this->loadMissing('teams.members');
        $teams = $this->teams;
        $registrations = $this->registrations->keyBy('user_id');
        $members = [];

        foreach ($registrations->pluck('user_id')->diff($teams->pluck('members.*.user_id', 'id')->flatten()) as $memberId) {
            $members[$memberId] = $registrations[$memberId];
        }

        return $members;
    }

    public function members()
    {
        $this->loadMissing(['teams.members.user', 'teams.score']);
        $teams = $this->teams->keyBy('id')->map(function ($team) {
            $team->setRelation('members', $team->members->keyBy('user_id'));
            return $team;
        });
        $_teams = [];
        $_members = $this->membersWithoutTeam();

        foreach ($teams as $teamId => $team) {
            $_teams[$teamId] = $team;
        }

        return array_merge($_teams, $_members);
    }

    public function path()
    {
        return storage_path(self::COVERS_DIRECTORY . $this->getImageFileName());
    }

    public function map()
    {
        return 'https://maps.google.com/maps?q=' . urlencode($this->location) . '&z=15&ie=UTF8&iwloc=&output=embed';
    }

    public function hasImage()
    {
        return file_exists($this->path());
    }

    public function getImageFileName()
    {
        return Uuid::generate(5, 'sm:' . $this->id, Uuid::NS_DNS) . '.jpg';
    }

    public function member(?int $userId = null)
    {
        return $this->registrations->where('user_id', $userId ?? auth()->id())->first();
    }

    public function calculateDistance(): ?float
    {
        $gps = $this->place->gps;

        if (empty(auth()->user()->place)) {
            return null;
        }

        $unit = auth()->user()->formatUnit();
        $user = auth()->user()->place->gps;

        return geoDistance($gps->getLat(), $gps->getLng(), $user->getLat(), $user->getLng(), $unit);
    }

    public function registered(): bool
    {
        return $this->member() !== null;
    }

    public function deadlineReached(): bool
    {
        if (empty($this->deadline)) {
            return false;
        }

        $now = Carbon::now()->tz($this->place->timezone->timezone);

        return $this->deadlineTz()->isBefore($now);
    }

    public function quotaReached(): bool
    {
        if ($this->registration_limit === null) {
            return false;
        }

        return $this->registrations->count() >= $this->registration_limit;
    }

    public function formatStart(): string
    {
        $timezone = $this->place->timezone->timezone;
        $date = $this->start->clone()->setTimezone($timezone)->format('l, jS F Y \a\t h:i a (\G\M\TP)');

        return str_replace(' ' . Carbon::now()->year, '', $date);
    }

    public function formatDate(): string
    {
        $timezone = $this->place->timezone->timezone;
        $start = $this->start->clone()->setTimezone($timezone);
        $end = $this->end->clone()->setTimezone($timezone);

        $date = $start->format('jS F Y \a\t h:i a') . ' - ' . $end->format('jS F Y \a\t h:i a (\G\M\TP)');

        if ($start->isSameDay($end)) {
            $date = $start->format('jS F Y \a\t h:i a') . ' - ' . $end->format('h:i a (\G\M\TP)');
        }

        return str_replace(' ' . Carbon::now()->year, '', $date);
    }

    public function isOwner(): bool
    {
        return $this->user_id === auth()->id();
    }
}
