<?php
/**
 * @copyright Sport M4te s.r.o. 2021 - present
 */

namespace App\Models\Event\Traits;

trait TeamMethod
{
    public function formatMembers()
    {
        return $this->members->map(function ($member) {
            return '<a href="' . $member->user->link() . '">' . $member->user->formatName() . '</a>';
        })->implode(', ');
    }

    public function formatTotalMembers()
    {
        $count = $this->members->count();

        $members = 'members';
        if ($count === 1) {
            $members = 'member';
        }

        return $count . ' ' . $members;
    }
}
