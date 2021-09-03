<?php
/**
 * @copyright Sport M4te s.r.o. 2021 - present
 */

namespace App\Models\User\Traits;

use App\Models\Management\Place;
use App\Models\Management\Timezone;
use App\Models\User;
use App\Models\User\Event;
use App\Models\User\EventRegistration;
use App\Models\User\Friend;
use App\Models\User\Review;
use App\Models\User\UserSport;
use Carbon\Carbon;
use Illuminate\Support\Collection;

/**
 * @property Place|null $place
 * @property Timezone|null $timezone
 * @property Event[]|Collection|null $hosting
 * @property Event[]|Collection|null $hosted
 * @property Review[]|Collection|null $reviews
 * @property EventRegistration[]|Collection|null $upcoming
 * @property EventRegistration[]|Collection|null $upcomingEvents
 * @property EventRegistration[]|Collection|null $going
 * @property EventRegistration[]|Collection|null $pastEvents
 * @property UserSport[]|Collection|null $sports
 * @property User[]|Collection|null $myFriends
 * @property User[]|Collection|null $friendsOf
 */
trait UserRelationship
{
    public function place()
    {
        return $this->hasOne(Place::class, 'id', 'place_id');
    }

    public function timezone()
    {
        return $this->hasOne(Timezone::class, 'id', 'timezone_id');
    }

    public function hosting()
    {
        $now = Carbon::now();

        return $this->hasMany(Event::class, 'user_id')->with(['place.timezone', 'recurring', 'category'])->where('end', '>', $now->toDateTimeString())->orderBy('start');
    }

    public function hosted()
    {
        $now = Carbon::now();

        return $this->hasMany(Event::class, 'user_id')->with(['place.timezone', 'recurring', 'category'])->where('end', '<=', $now->toDateTimeString())->orderByDesc('end');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'user_id');
    }

    public function upcoming()
    {
        $today = Carbon::now();
        $afterWeek = Carbon::now()->addWeek();

        return $this->hasMany(EventRegistration::class, 'user_id')->whereHas('event', function ($q) use ($today, $afterWeek) {
            $q->whereBetween('start', [$today->toDateTimeString(), $afterWeek->toDateTimeString()]);
        })->with(['event.place.timezone', 'event.recurring', 'event.category']);
    }

    public function upcomingEvents()
    {
        $after2hours = Carbon::now()->addHours(2);
        $after24hours = $after2hours->clone()->addDay();

        return $this->hasMany(EventRegistration::class, 'user_id')->whereHas('event', function ($q) use ($after2hours, $after24hours) {
            $q->whereBetween('start', [$after2hours->toDateTimeString(), $after24hours->toDateTimeString()]);
        })->with(['event.place.timezone']);
    }

    public function going()
    {
        return $this->hasMany(EventRegistration::class, 'user_id')->whereHas('event')->where('approved', 1)->with(['event.place.timezone', 'event.recurring']);
    }

    public function pastEvents()
    {
        $today = Carbon::now();

        return $this->hasMany(EventRegistration::class, 'user_id')->whereHas('event', function ($q) use ($today) {
            $q->where('start', '<', $today->toDateTimeString());
        })->with(['event.place.timezone', 'event.recurring', 'event.category']);
    }

    public function sports()
    {
        return $this->hasMany(UserSport::class, 'user_id')->orderBy('priority');
    }

    public function myFriends()
    {
        return $this->belongsToMany(User::class, 'friend', 'friend_id')->where('confirmed', 1);
    }

    public function friendsOf()
    {
        return $this->belongsToMany(User::class, 'friend', 'user_id', 'friend_id')->where('confirmed', 1);
    }
}
