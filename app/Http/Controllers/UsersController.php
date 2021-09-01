<?php
/**
 * @copyright SportM4te 2021 - present
 */

namespace App\Http\Controllers;

use App\Management\RegisterService;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    private RegisterService $registerService;

    public function __construct(RegisterService $registerService) {
        $this->registerService = $registerService;
    }

    public function list(Request $request)
    {
        $sports = $this->registerService->getSports();
        $text = $request->get('q');

        $users = User::with([
            'going',
            'hosting',
            'myFriends',
            'friendsOf',
            'reviews',
            'sports.sport',
        ])->whereDoesntHave('blocked', function ($q) {
            $q->where('blocked_id', auth()->id());
        });

        $users->whereNotIn('id', auth()->user()->blocked->pluck('blocked_id')->toArray());

        $users->where(function($q) use ($text) {
            $q->where('username', 'like', $text.'%');
            $q->orWhere('username', 'like', '% '.$text.' %');
            $q->orWhere('username', 'like', '% '.$text.'-%');
            $q->orWhere('username', 'like', '% '.$text);
        });

        $searchedSports = (array)$request->get('sports', []);

        if ($searchedSports) {
            $users->whereHas('sports', function ($q) use ($searchedSports) {
                $q->whereIn('sport_id', $searchedSports);
            });
        }

        if ($request->filled('place_id')) {
            $users->where('place_id', $request->get('place_id'));
        }

        $users = $users->paginate();

        return view('user.search', get_defined_vars());
    }
}
