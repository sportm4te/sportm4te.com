<?php
/**
 * @copyright Sport M4te s.r.o. 2021 - present
 */

namespace App\Http\Controllers\Api;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\StoreSettingsRequest;
use App\Management\ApiResponse;
use App\Models\Management\Place;
use App\Models\User;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{
    private ApiResponse $response;

    public function __construct(ApiResponse $apiResponse)
    {
        $this->response = $apiResponse;
    }

    public function settings(StoreSettingsRequest $request)
    {
        $user = $request->user();

        if ($request->hasFile('image')) {
            $request->file('image')
                ->move(storage_path(User::AVATARS_DIRECTORY), $user->getImageFileName());
        }

        // $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->bio = $request->get('bio');
        $user->unit = $request->get('unit');
        $user->place_id = $request->get('place_id');
        $user->gender = $request->get('gender');
        // $user->birthdate = Carbon::parse($request->get('birthdate'));
        $place = Place::find($user->place_id);
        if ($place && $request->filled('location')) {
            $place->saveMissingTimezone();
            $user->location = $place->gps;
            $user->timezone_id = $place->timezone_id;
        } else {
            $user->place_id = null;
            $user->location = null;
            $user->timezone_id = $request->get('timezone');
        }

        $user->save();

        return $this->response->success([
            'user' => $user->toArray(),
            'message' => 'Settings has been updated!',
        ]);
    }

    public function passwordChange(ChangePasswordRequest $request)
    {
        $user = $request->user();

        $user->password = Hash::make($request->get('password'));
        $user->save();


        return $this->response->success([
            'user' => $user->toArray(),
            'message' => 'Password has been changed!',
        ]);
    }
}
