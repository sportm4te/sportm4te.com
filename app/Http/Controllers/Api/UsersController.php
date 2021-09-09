<?php
/**
 * @copyright SportM4te 2021 - present
 */

namespace App\Http\Controllers\Api;

use App\Management\RegisterService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class UsersController extends Controller
{
    private RegisterService $registerService;

    public function __construct(RegisterService $registerService)
    {
        $this->registerService = $registerService;
    }

    public function search(Request $request)
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

        $users->where(function ($q) use ($text) {
            $q->where('username', 'like', $text . '%');
            $q->orWhere('username', 'like', '% ' . $text . ' %');
            $q->orWhere('username', 'like', '% ' . $text . '-%');
            $q->orWhere('username', 'like', '% ' . $text);
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

        return [
            'filters' => [
                'sports' => $sports,
            ],
            'users'   => $users->paginate(),
        ];
    }

    public function me(Request $request)
    {
        return $request->user()->toArray();
    }
}
