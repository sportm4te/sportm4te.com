<?php
/**
 * @copyright SportM4te 2021 - present
 */

namespace App\Models\Event\Traits;

use App\Models\Event\Team;
use App\Models\User;

trait TeamMemberRelationship
{

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }
}
