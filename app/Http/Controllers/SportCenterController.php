<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class SportCenterController extends Controller
{
    //
 
    public static function index()
    {

        $details = DB::connection('mysql2')->table('sport_centers')->get();
      
      

        return View('search', [
            'detail' => $details,
            
          
        ]);
    }
}
