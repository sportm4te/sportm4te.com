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
            return $member->user->formatName();
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

    public function toArray()
    {
        return [
            'id'      => $this->id,
            'type'    => self::TEAM,
            'name'    => $this->name,
            'score'   => $this->score?->toArray(),
            'members' => $this->members->toArray(),
        ];
    }
}
