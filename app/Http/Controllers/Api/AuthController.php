<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\User; 
use App\Role;
use Illuminate\Support\Facades\Auth; 
use Validator;

class AuthController extends Controller
{
    public $successStatus = 200;
  
 public function register(Request $request) {    
 $validator = Validator::make($request->all(), [ 
              'name' => 'required',
              'email' => 'required|email',
              'password' => 'required',  
              'c_password' => 'required|same:password', 
    ]);   
 if ($validator->fails()) {          
       return response()->json(['error'=>$validator->errors()], 401);                        }    
 $input = $request->all();  
 $input['password'] = bcrypt($input['password']);
 $user = User::create($input); 
 $success['token'] =  $user->createToken('AppName')->accessToken;
 return response()->json(['success'=>$success], $this->successStatus); 
}
  
   
public function login(){ 
if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
   $user = Auth::user(); 

      $role=  DB::table('roles')
         ->join('role_user','roles.id','=','role_user.role_id')
         ->where('role_user.user_id',auth()->user()->id)
         ->select('roles.name')->first();
    
     $profile = DB::table('tb_employee')
        ->leftjoin('tb_departments','tb_employee.emp_department_id','=','tb_departments.id')
        ->leftjoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
        ->leftjoin('tb_branch','tb_employee.branch_id','=','tb_branch.id')
        ->select('tb_employee.id','tb_employee.emp_first_name','tb_employee.emp_lastName','tb_employee.emp_account_status','tb_employee.emp_card_number','tb_departments.department_name','tb_designations.designation_name','tb_employee.employeeId','tb_branch.branch_name','tb_employee.emp_photo')
         ->where('tb_employee.id',$user->id)
        ->orderBy('tb_employee.id', 'desc')
        ->first();
    
    if ($profile) {
        $success['token'] =  $user->createToken('AppName')->accessToken; 
        $success['role'] =    $role->name; 
        $success['id'] =    $profile->id; 
        $success['full_name'] =    $profile->emp_first_name .' '. $profile->emp_lastName;
        $path= asset('employee_image/'); 
        $success['emp_photo'] =   $path . '/'.$profile->emp_photo;
        return response()->json(['success' => $success], $this->successStatus); 
    }
        $profile = $profile?$profile:'null';
       
        $success['token'] =  $user->createToken('AppName')->accessToken; 
        $success['role'] =    $role->name; 
        $success['id'] =    $user->id; 
        $success['full_name'] =   $user->name; 
        $success['emp_photo'] =   asset('images/profile_2.png');


    return response()->json(['success' => $success], $this->successStatus); 
  } else{ 
   return response()->json(['error'=>'Unauthorised'], 401); 
   } 
} 


public function logout() {
        $accessToken = Auth::user()->token();
        DB::table('oauth_refresh_tokens')
            ->where('access_token_id', $accessToken->id)
            ->update([
                'revoked' => true
            ]);

        $accessToken->revoke();
        return response()->json(['success' => 'successfully logged out'], 204);
    }
  
public function getUser() {
 $user = Auth::user();
 return response()->json(['success' => $user], $this->successStatus); 
 }
}
