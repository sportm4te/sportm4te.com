<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SportController extends Controller
{

    public static function index(Request $request)

    {
        $userIp = request()->header('X-Forwarded-For');;
        $locationData = \Location::get($userIp);

        $details = DB::connection('mysql2')->table('sport_centers')->get();
        $zipCode = $locationData->zipCode;

        $ec = DB::connection('mysql2')->table('sport_centers')->where('zip','=',"$zipCode")->count();
        if($ec > 0){
        $fetch = DB::connection('mysql2')->table('sport_centers')->join('images', 'sport_centers.id', '=', 'images.sport_center_id')->where('zip','=',"$zipCode")->distinct()->get(['sport_centers.*', 'images.name as imgName']);
        }else{
            $fetch = DB::connection('mysql2')->table('sport_centers')->join('images', 'sport_centers.id', '=', 'images.sport_center_id')->distinct()->get(['sport_centers.*', 'images.name as imgName']);
        }
        return View('code.search', [
            'detail' => $details,
            'fetch' => $fetch,
            'ip' => $zipCode,
            
          
        ]);
    }

    


   public static function details($id)
    {
        $center = DB::connection('mysql2')->table('sport_centers')->where("id", "=", "$id")->first();
      
        $images = DB::connection('mysql2')->table('images')->where("sport_center_id", "=", "$id")->get();
        return View('code.sport-details', [
            'center' => $center,
            'images' => $images,
            
          
        ]);

        $monday = $center->open_monday;
        $tuesday = $center->open_tuesday;
        $wednesday = $center->open_wednesday;
        $thursday = $center->open_thursday;
        $friday = $center->friday;
        $saturday = $center->saturday;
        $sunday = $center->sunday;


    }


}




  


