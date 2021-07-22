<?php
/**
 * @copyright Sport M4te s.r.o. 2021 - present
 */

namespace App\Models\User\Traits;

trait EventRegistrationMethod
{
    public function isApproved(): bool
    {
        return $this->approved === true;
    }

    public function isPending(): bool
    {
        return $this->approved === null;
    }

    public function registerStatusText()
    {
        if ($this->isPending()) {
            return 'Pending';
        }

        if ($this->isApproved()) {
            return 'Approved';
        }

        return 'Declined';
    }
}
