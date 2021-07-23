<?php
/**
 * @copyright Sport M4te s.r.o. 2021 - present
 */

namespace App\Http\Controllers;


use App\Management\RegisterService;
use Illuminate\Http\Request;

class SportChooseController extends Controller
{
    private RegisterService $registerService;

    public function __construct(RegisterService $registerService)
    {
        $this->registerService = $registerService;
    }

    public function index(Request $request)
    {
        $sports = $this->registerService->getSports();
        $preferences = $request->user()->sports->pluck('priority', 'sport_id');

        return view('user.sport-choose', get_defined_vars());
    }
}
