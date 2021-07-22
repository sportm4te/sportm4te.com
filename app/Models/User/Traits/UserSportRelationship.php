<?php
/**
 * @copyright SportM4te 2021 - present
 */

namespace App\Models\User\Traits;

use App\Models\Management\Sport;

/**
 * @property Sport|null $sport
 */
trait UserSportRelationship
{
    public function sport()
    {
        return $this->hasOne(Sport::class, 'id', 'sport_id');
    }
}
