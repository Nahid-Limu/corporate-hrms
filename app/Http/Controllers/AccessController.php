<?php

namespace App\Http\Controllers;

use File;
use Illuminate\Http\Request;

class AccessController extends Controller
{
    public static function ipAccess(){
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP'])){
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        }
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else if(isset($_SERVER['HTTP_X_FORWARDED'])){
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        }
        else if(isset($_SERVER['HTTP_FORWARDED_FOR'])){
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        }
        else if(isset($_SERVER['HTTP_FORWARDED'])){
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        }
        else if(isset($_SERVER['REMOTE_ADDR'])){
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        }
        else{
            $ipaddress = 'UNKNOWN';
        }

        $cont=File::get(storage_path('hidden/doordie.txt'));
        $con=explode(";",$cont);
        $addr=base64_encode($ipaddress);
        if (in_array($addr, $con)) {
            return true;
        }else{
            return true;// Should be false in production
        }
    }

    public function AccessDenied(){
        return view('access_denied');
    }
}
