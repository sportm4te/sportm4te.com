<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TutorialController extends Controller
{
    function index(){

        return view('tutorial.index');
    }
    function add(Request $request){
        $user = Auth::id();
       $query = DB::table('tutorial')->insert([
           'user_id'=>$user,
           'tutorial'=>$request->input('tutorial'),
       ]);
       return redirect('/');
    }
}


