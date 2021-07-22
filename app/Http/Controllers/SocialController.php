<?php
/**
 * @copyright Sport M4te s.r.o. 2021 - present
 */

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Management\RegisterService;
use App\Models\Management\Timezone;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    private RegisterService $registerService;

    public function __construct(RegisterService $registerService)
    {
        $this->registerService = $registerService;
    }

    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function store(RegisterRequest $request)
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

        Auth::login($user);

        return [
            'message' => 'You have been registered.',
            'redirect' => route('sport-choose'),
        ];
    }

    public function callback($provider)
    {
        $userSocial = Socialite::driver($provider)->stateless()->user();
        $users = User::where(['email' => $userSocial->getEmail()])->first();
        $genders = $this->registerService->getGenders();

        if($users) {
            Auth::login($users);
            return redirect('/');
        }

        return view('auth.social-register', get_defined_vars());
    }
}
