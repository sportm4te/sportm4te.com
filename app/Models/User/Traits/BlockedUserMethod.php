<?php
/**
 * @copyright Sport M4te s.r.o. 2021 - present
 */

namespace App\Models\User\Traits;

use App\Models\User;

/**
 * @property User|null $user
 */

trait BlockedUserMethod
{
    public function toArray()
    {
        return [
            'user' => $this->user->toArray(),
        ];
    }
}
