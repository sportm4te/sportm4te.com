<?php
/**
 * @copyright Sport M4te s.r.o. 2021 - present
 */

namespace App\Http\Controllers\Api;

use App\Http\Requests\ProviderRegisterRequest;
use App\Management\RegisterService;
use App\Models\Management\Timezone;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class SocialController extends Controller
{
    private RegisterService $registerService;

    public function __construct(RegisterService $registerService)
    {
        $this->registerService = $registerService;
    }

    public function store(ProviderRegisterRequest $request)
    {
        $timezone = Timezone::where('timezone', $request->get('timezone'))->first()->id ?? null;

        $user = User::create([
            'username'    => $request->get('username'),
            'email'       => $request->get('email'),
            'birthdate'   => Carbon::parse($request->get('birthday')),
            'gender'      => $request->get('gender'),
            'timezone_id' => $timezone,
            'provider_id' => $request->get('provider_id'),
            'provider'    => $request->get('provider'),
            'avatar'      => $request->get('avatar'),
            'unit'        => User::MI_UNIT,
        ]);

        return new JsonResponse([
            'user'    => $user->toArray(),
            'token'   => getToken(),
            'message' => 'You have been registered.',
        ], 201);
    }
}
