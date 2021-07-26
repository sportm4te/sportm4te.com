<?php
/**
 * @copyright SportM4te 2021 - present
 */

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function profile(User $user)
    {
        $user->load(['sports.sport', 'reviews', 'reviews.author']);

        $canAddReview = $user->canAddReview();

        return view('user.profile', get_defined_vars());
    }
}
