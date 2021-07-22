<?php
/**
 * @copyright Sport M4te s.r.o. 2021 - present
 */

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Management\ApiResponse;
use App\Management\RegisterService;
use App\Models\Management\Timezone;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/sport-choose';

    private ApiResponse $response;

    private RegisterService $registerService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ApiResponse $apiResponse, RegisterService $registerService)
    {
        $this->middleware('guest');

        $this->response = $apiResponse;
        $this->registerService = $registerService;
    }

    public function showRegistrationForm()
    {
        $genders = $this->registerService->getGenders();

        return view('auth.register', get_defined_vars());
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $registerRequest = new RegisterRequest();

        return Validator::make($data, [
            'username' => ['required', 'string', 'min:5', 'max:20', 'check_username', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'birthdate' => ['required', 'date', 'check_age'],
            'gender' => ['required', Rule::in(array_keys(User::GENDERS))],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'terms' => ['required'],
        ], [
            'check_age' => 'You are not able to join.',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     */
    protected function create(array $data)
    {
        $timezone = Timezone::where('timezone', $data['timezone'])->first()->id ?? null;

        return User::create([
            'username' => $data['username'],
            'birthdate' => Carbon::parse($data['birthdate']),
            'gender'      => $data['gender'],
            'email' => $data['email'],
            'timezone_id' => $timezone,
            'unit' => User::MI_UNIT,
            'password' => Hash::make($data['password']),
        ]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        if ($response = $this->registered($request, $user)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([
                'message' => 'You have been registered.',
                'redirect' => $this->redirectPath(),
            ], 201)
            : redirect($this->redirectPath());
    }

}
