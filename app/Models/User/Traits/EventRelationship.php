<?php
/**
 * @copyright SportM4te 2021 - present
 */

namespace App\Models\User\Traits;

use App\Models\Management\Place;
use App\Models\Management\Sport;
use App\Models\Event\Team;
use App\Models\User;
use App\Models\User\Event;
use App\Models\User\EventRecurring;
use App\Models\User\EventRegistration;
use Illuminate\Support\Collection;

/**
 * @property User|null $owner
 * @property EventRecurring|null $recurring
 * @property Team[]|Collection|null $event
 * @property EventRegistration[]|Collection|null $registrations
 * @property Sport|null $category
 * @property Event|null $parent
 * @property Place|null $place
 */
trait EventRelationship
{
    public function recurring()
    {
        return $this->hasOne(EventRecurring::class, 'event_id');
    }

    public function owner()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function teams()
    {
        return $this->hasMany(Team::class, 'event_id');
    }

    public function registrations()
    {
        return $this->hasMany(EventRegistration::class, 'event_id');
    }

    public function category()
    {
        return $this->hasOne(Sport::class, 'id', 'category_id');
    }

    public function parent()
    {
        return $this->hasOne(Event::class, 'id', 'parent_id');
    }

    public function place()
    {
        return $this->hasOne(Place::class, 'id', 'place_id');
    }
}
