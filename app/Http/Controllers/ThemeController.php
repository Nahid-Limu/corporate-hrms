<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Carbon\Carbon;
use Validator;
use App\Repositories\Settings;
use Illuminate\Support\Facades\Session;

class ThemeController extends Controller
{
    public function theme_list(){

        $this->checkuserRole(['admin','super-admin','branch-manager'],'');
        return view('backend.theme_style.theme_list');
    }
    public function changeStyle(Request $request){
        $user=Auth::user();

        $str=DB::table('users')->where(['id'=>$user->id])->update([
            'theme_style' => $request->themeStyle,
        ]);

        if($str>0)
        {
            Session::flash('message','Theme Style has been changed. Please refresh(press ctrl+f5 to refresh ) your browser if is it not rendering currectly. ');
        }else{
            Session::flash('failedMessage','Failed to change theme style. Try again later...');
        }
        // return $str;
        return redirect()->back();
    }



}
