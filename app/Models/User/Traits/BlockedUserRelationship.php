<?php
/**
 * @copyright Sport M4te s.r.o. 2021 - present
 */

namespace App\Models\User\Traits;

use App\Models\User;

trait BlockedUserRelationship
{
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'blocked_id');
    }
}
