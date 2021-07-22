<?php
/**
 * @copyright SportM4te 2021 - present
 */

namespace App\Models\User\Traits;

use App\Models\Event\Score;
use App\Models\User;
use App\Models\User\Event;

/**
 * @property Event|null $event
 * @property User|null $user
 * @property Score|null $score
 */
trait EventRegistrationRelationship
{

    public function event()
    {
        return $this->hasOne(Event::class, 'id', 'event_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function score()
    {
        return $this->hasOne(Score::class, 'user_id', 'user_id')->where('event_id', $this->event_id);
    }
}
