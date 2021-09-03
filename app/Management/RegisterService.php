<?php
/**
 * @copyright Sport M4te s.r.o. 2021 - present
 */

namespace App\Management;

use App\Models\Management\Sport;
use App\Models\Management\Timezone;
use App\Models\User;
use MBarlow\Timezones\Timezones;

class RegisterService
{
    public function listSports()
    {
        return Sport::all()->pluck('name', 'id')->toArray();
    }

    public function getSports()
    {
        return Sport::all();
    }

    public function getUnits()
    {
        return User::LENGTH_UNITS;
    }

    public function getGenders(bool $autocomplete = true)
    {
        if ($autocomplete) {
            return [null => 'Gender'] + User::GENDERS;
        }

        return User::GENDERS;
    }

    public function getTimezones()
    {
        $timezones = new Timezones();
        $timezone = Timezone::all()->pluck('id', 'timezone');

        return collect($timezones->timezoneList())->map(function($value, $key) use ($timezone) {
            return [
                'value' => $value,
                'id'    => $timezone[$key],
            ];
        })->pluck('value', 'id')->map(function($label) {
            return str_replace('(UTC', '(GMT', $label);
        });
    }
}
