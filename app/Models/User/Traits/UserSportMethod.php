<?php
/**
 * @copyright SportM4te 2021 - present
 */

namespace App\Models\User\Traits;


trait UserSportMethod
{
    public function toArray()
    {
        return [
            'id' => $this->id,
            'priority' => $this->priority,
            'sport' => $this->sport->toArray(),
        ];
    }
}
