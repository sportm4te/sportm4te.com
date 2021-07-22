<?php
/**
 * @copyright SportM4te 2021 - present
 */

namespace App\Models\User\Traits;

use App\Models\User;

/**
 * @property User|null $author
 */
trait ReviewRelationship
{

    public function author()
    {
        return $this->hasOne(User::class, 'id', 'author_id');
    }
}
