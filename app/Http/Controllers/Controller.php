<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
        // this function will check the user have permission to do the work
    protected function checkPermission($permission, $massge=null) {
          abort_if(!Auth::user()->hasPermission($permission), 403, $massge);
    } 

    // login user role fiend
    protected function checksuperadmin($role){
         return  Auth::user()->hasRole($role);
    }


    // login user hasRole check 

    protected function checkuserRole($role ,$massge=null ){
        $massge = $massge?$massge: "You have not right to Access" ;
           abort_if(!Auth::user()->hasRole($role), 403, $massge);
    }
    // use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    //     // this function will check the user have permission to do the work
    // protected function canUser($permission, $massge=null) {
    //       abort_if(!Auth::user()->can($permission), 403, $massge);
          
           
    // } 
}
