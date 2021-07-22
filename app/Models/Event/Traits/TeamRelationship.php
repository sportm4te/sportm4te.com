<?php
/**
 * @copyright SportM4te 2021 - present
 */

namespace App\Models\Event\Traits;

use App\Models\Event\Score;
use App\Models\Event\TeamMember;
use Illuminate\Support\Collection;

/**
 * @property TeamMember[]|Collection|null $members
 * @property Score|null $score
 */
trait TeamRelationship
{

    public function members()
    {
        return $this->hasMany(TeamMember::class, 'team_id');
    }

    public function score()
    {
        return $this->hasOne(Score::class, 'team_id', 'id')->where('event_id', $this->event_id);
    }
}
