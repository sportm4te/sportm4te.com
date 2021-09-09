<?php
/**
 * @copyright Sport M4te s.r.o. 2021 - present
 */

namespace App\Http\Controllers;

use App\Management\RegisterService;

class SettingsController extends Controller
{
    public function settings(RegisterService $registerService)
    {
        $user = auth()->user();

        $timezones = $registerService->getTimezones();
        $units = $registerService->getUnits();
        $genders = $registerService->getGenders(false);
        $blocked = $user->blocked;

        return view('user.settings', get_defined_vars());
    }
}
