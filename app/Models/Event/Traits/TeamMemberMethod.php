<?php
/**
 * @copyright SportM4te 2021 - present
 */

namespace App\Models\Event\Traits;


trait TeamMemberMethod
{
    public function toArray()
    {
        return [
            'id'    => $this->id,
            'type'  => self::TEAM_MEMBER,
            'user'  => $this->user->toArray(),
        ];
    }
}
