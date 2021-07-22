<?php
/**
 * @copyright SportM4te 2021 - present
 */

namespace App\Models\Management\Traits;

use App\Models\Management\Timezone;

/**
 * @property Timezone|null $timezone
 */
trait PlaceRelationship
{

    public function timezone()
    {
        return $this->hasOne(Timezone::class, 'id', 'timezone_id');
    }
}
