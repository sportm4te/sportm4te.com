<?php
/**
 * @copyright SportM4te 2021 - present
 */

namespace App\Models\User\Traits;


use App\Models\User;

/**
 * @property User|null $requester
 * @property User|null $user
 */
trait FriendRelationship
{
    public function requester()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'friend_id');
    }
}
