<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function send_notification_to_user($data = [])
    {
        // dd($data);

        date_default_timezone_set("asia/karachi");

        $Notification_types = array('web_notification', 'app_notification');
        foreach ($Notification_types as $types) {

            $ch = curl_init();
            $carbon = Carbon::now();
            // echo $data['user_id'] . "\n" .Auth::id() . "    ";
            $data_json = '{"text": "' . $data['message'] . '","user_id": "' . $data['user_id'] . '" ,"url": "' . $data['url'] . '", "date": "' . $carbon->format('d-m-Y h:i A') . '"}';
            // dd($data);

            curl_setopt($ch, CURLOPT_URL, "https://sport-e3c0c-default-rtdb.firebaseio.com/user_id_" . $data['user_id'] . "/" . $types . "/" . $carbon->format('YmdGis') . ".json");
            // dd($data,$text,$link,$User_id,$notification_id,$lead_type);
            $server_key = 'AIzaSyDqxV_jk9KLPDN3zCoSmL6w3BpzU_WhMUI';
            $headers = array(
                'Content-Type:application/json',
                'Authorization:key=' . $server_key
            );
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
            $res = curl_exec($ch);
            $httpCode = curl_getinfo($ch);
            // dd($res);
            curl_close($ch);
        }

        //dd($res);

        return $res;
    }



    public function send_message_to_user($data = [])
    {
        //    dd($data);
        date_default_timezone_set("asia/karachi");
        $return_array = [];

        $Notification_types = array($data['id'] => Auth::id(), Auth::id() => $data['id']);
        foreach ($Notification_types as $firstkey => $secondKey) {
            $user = User::find($firstkey);
            $user_sec = User::find($secondKey);
            //  dd($user,$user_sec);

            $ch = curl_init();
            $carbon = Carbon::now();
            // echo $data['user_id'] . "\n" .Auth::id() . "    ";
            $data_json = '{"text": "' . $data['message'] . '","user_id":"' . Auth::user()->id . '" ,"link": "' . $data['link'] . '","username": "' . Auth::user()->name . '", "files": "' . $data['files'] . '","file_type":"' . $data['file_type'] . '", "date": "' . $carbon->format('d-m-Y h:i A') . '"}';
            // dd($data);
            array_push($return_array, [$secondKey => $data_json]);

            curl_setopt($ch, CURLOPT_URL, "https://sport-e3c0c-default-rtdb.firebaseio.com/user_id_" . $secondKey . "/messages/user_id_" . $firstkey . "/" . $carbon->format('YmdGis') . ".json");
            // dd($data,$text,$link,$User_id,$notification_id,$lead_type);
            $server_key = 'AIzaSyDqxV_jk9KLPDN3zCoSmL6w3BpzU_WhMUI';
            $headers = array(
                'Content-Type:application/json',
                'Authorization:key=' . $server_key
            );
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
            $res = curl_exec($ch);
            $httpCode = curl_getinfo($ch);
            // dd($res);
            curl_close($ch);
        }

        //dd($return_array);
        $user = User::find($data['id']);
        $this->send_notification_to_user(['user_id' => $data['id'], 'message' => Auth::user()->name . " Send You a message", 'url' => '/Conversation/' . $user_sec->id . '/' . $user_sec->name]);


        return $res;
    }

    public function block_user($data = [])
    {

        date_default_timezone_set("asia/karachi");

        $Notification_types = array('web_notification', 'app_notification');
        foreach ($Notification_types as $types) {

            $ch = curl_init();
            $carbon = Carbon::now();
            // echo $data['user_id'] . "\n" .Auth::id() . "    ";
            if ($data['req_fro'] == 'unblock') {
                $data_json = '{"block_from": "' . Auth::user()->id . '" ,"blocked": "1", "date": "' . $carbon->format('d-m-Y h:i A') . '"}';
                // dd($data);
            } elseif ($data['req_fro'] == 'kick_out') {

                $data_json = '{"removed_id": "' . $data['id'] . '","date": "' . $carbon->format('d-m-Y h:i A') . '"}';
            } else {
                $data_json = '{"unblock_from": "' . Auth::user()->id . '" ,"un_blocked": "1", "date": "' . $carbon->format('d-m-Y h:i A') . '"}';
            }
            curl_setopt($ch, CURLOPT_URL, "https://sport-e3c0c-default-rtdb.firebaseio.com/user_id_" . $data['id'] . "/" . $types . "/" . $carbon->format('YmdGis') . ".json");

            // dd($data,$text,$link,$User_id,$notification_id,$lead_type);
            $server_key = 'AIzaSyDqxV_jk9KLPDN3zCoSmL6w3BpzU_WhMUI';
            $headers = array(
                'Content-Type:application/json',
                'Authorization:key=' . $server_key
            );
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
            $res = curl_exec($ch);
            $httpCode = curl_getinfo($ch);
            // dd($res);
            curl_close($ch);
        }

        //dd($res);

        return $res;
    }



    // GROUP CHAT START
    public function send_group_message($data = [])
    {
        date_default_timezone_set("asia/karachi");
        $return_array = [];
        $Notification_types = array($data['group_id'] => Auth::id(), Auth::id() => $data['group_id']);
        //   foreach($Notification_types as $firstkey=>$secondKey){
        $user = User::find(Auth::id());
        $ch = curl_init();
        $carbon = Carbon::now();
        $data_json = '{"text": "' . $data['message'] . '","sender_name": "' . Auth::user()->username . '","sender_id":"' . Auth::user()->id . '","file_type": "' . $data['file_type'] . '" ,"files": "' . $data['files'] . '","date": "' . $carbon->format('d-m-Y h:i A') . '"}';
        // array_push($return_array, [$user_sec => $data_json]);
        curl_setopt($ch, CURLOPT_URL, "https://sport-e3c0c-default-rtdb.firebaseio.com/group_id_" . $data['group_id'] . "/group_messages/" . $carbon->format('YmdGis') . ".json");
        $server_key = 'AIzaSyDqxV_jk9KLPDN3zCoSmL6w3BpzU_WhMUI';
        $headers = array(
            'Content-Type:application/json',
            'Authorization:key=' . $server_key
        );
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
        $res = curl_exec($ch);
        $httpCode = curl_getinfo($ch);
        curl_close($ch);
        //    }
        $slug = str_replace(' ', "-", $data['group_name']);
        $this->send_notification_to_group(['group_notification' => $data['group_id'], 'message' => Auth::user()->name . " Send message in " . $data['group_name'] . " ", 'url' => '/Group/' . $data['group_id'] . '/' . $slug]);
        return $res;
    }
    // GROUP CHAT END


    // GROUP CHAT NOTIFICATION START
    public function send_notification_to_group($data = [])
    {

        date_default_timezone_set("asia/karachi");
        $Notification_types = array('web_notification', 'app_notification');
        foreach ($Notification_types as $types) {
            $ch = curl_init();
            $carbon = Carbon::now();
            $data_json = '{"text": "' . $data['message'] . '","group_notification ": "' . $data['group_notification'] . '" ,"url": "' . $data['url'] . '", "date": "' . $carbon->format('d-m-Y h:i A') . '"}';
            curl_setopt($ch, CURLOPT_URL, "https://sport-e3c0c-default-rtdb.firebaseio.com/group_id_" . $data['group_notification'] . "/" . $types . "/" . $carbon->format('YmdGis') . ".json");
            $server_key = 'AIzaSyDqxV_jk9KLPDN3zCoSmL6w3BpzU_WhMUI';
            $headers = array(
                'Content-Type:application/json',
                'Authorization:key=' . $server_key
            );
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
            $res = curl_exec($ch);
            $httpCode = curl_getinfo($ch);
            curl_close($ch);
        }
    }
    // GROUP CHAT NOTIFICATION END
}
