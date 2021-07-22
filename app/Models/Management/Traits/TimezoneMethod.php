<?php
/**
 * @copyright Sport M4te s.r.o. 2021 - present
 */

namespace App\Models\Management\Traits;

trait TimezoneMethod
{
    public function toArray()
    {
        return [
            'id' => $this->id,
            'formatted' => $this->timezone,
        ];
    }
}
