<?php
/**
 * @copyright Sport M4te s.r.o. 2021 - present
 */

namespace App\Models\Event\Traits;

trait ScoreMethod
{
    public function formatScore()
    {
        return $this->score . ' points';
    }
}
