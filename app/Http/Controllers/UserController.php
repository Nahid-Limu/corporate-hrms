<?php

namespace App\Http\Controllers;

use Session;
use DB;
use App\User;
use App\Role;
use App\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Settings;

use Illuminate\Foundation\Auth\RegistersUsers;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    protected $branche;
    public function __construct()
    {
        // create object of settings class
        $this->branche = new Settings();
    }


    public function index()
    {   


        
        $this->checkPermission('manage_users','You have not right to Access');  
      
        

        $haserole = $this->checksuperadmin(['admin','super-admin']);
        
        
        
        if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin')){ 

             
        $paginate = config('app.pagenation_count', 10);
      
        
        $users = User::with('roles')->orderBy('created_at', 'DESC')->paginate($paginate);

        
    
      
        return view('backend.manage.user.user-list', [
            'users' => $users,
            'haserole' => $haserole
        ]); 
        }
        
        if(auth()->user()->hasRole('branch-manager')){


            
       
            $paginate = config('app.pagenation_count', 10);
            
            $branch_id=$this->branche->branchname_loginemployee();
            // dd( $branch_id);
        $users = User::with('roles')->whereNotIn('id', [1, 2,])->where('users.emp_branch_id', $branch_id->id)->orderBy('created_at', 'DESC')->paginate($paginate);
        

        
    
        return view('backend.manage.user.user-list', [
            'users' => $users,
            'haserole' => $haserole
        ]); 
        }
        else{
            
           
            $paginate = config('app.pagenation_count', 10);
        
            
            $users = User::with('roles')->orderBy('created_at', 'DESC')->paginate($paginate);
            
        
            return view('backend.manage.user.user-list', [
                'users' => $users,
                'haserole' => $haserole
            ]); 
        }

        

    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        // $this->checkPermission('manage-users');
        // $roles = Role::get();
        // $roles = Role::get();

          $this->checkuserRole(['admin','super-admin'],'');
        $userrole = auth()->user();
        $userroleadmin = auth()->user();
        $admin_role_id = $userroleadmin->roles[0]->id;
        if($admin_role_id === 1 ||  $admin_role_id===2){
            $roles = Role::get();
            return view('backend.manage.user.user-create', [
            'roles' => $roles,
         
        ]); 
        }
        $user_role_id = $userrole->roles[0]->id;
        
        $roles = DB::table('roles')
                    ->whereNotBetween('id', [1 ,$user_role_id])->get();

        // dd($roles);

 
        return view('backend.manage.user.user-create', [
            'roles' => $roles,
           
        ]); 
    }

   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        
         $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|unique:users|max:255',
            'password' => 'required|string|min:8|confirmed',
            
        ]);

        
        $user = new User();
        $status = $request->input('user-status') ? $request->input('user-status') : 1;
        $user->status       = $status;
        $user->name             = $request->input('name');
        $user->email  = $request->input('email');

        $password = $request->input('password');
        $user->password  = Hash::make($password) ;

        //'password' => Hash::make($data['password']),

        
        
        $user->save();
        Session::flash('message', 'Successfully Created!');
        

        $user->roles()->sync([$request->input('role')]);

        
      
      
        // for($i=0;$i<count($request->permissions);$i++){
        //     $permission_user=DB::table('permission_user')->insert([
        //         'permission_id' =>$request->permissions[$i],
        //         'user_id' =>$user->id,
        //         'role_id' =>$request->role,
        //     ]);
        // }
        
        return redirect()->route('users.edit', $user->id); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show($id)
    // {

    //     $this->checkPermission('manage-users');
    //     $user = User::findOrFail($id);
    //     $roles = Role::get();

        
    //     return view('backend.pages.user-view', [
    //         'user' => $user,
    //         'roles' => $roles
    //     ]);
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    // =====================================   User Edit====================================
    public function edit($id)
    {   

         
          
        $this->checkPermission('manage_users');



        if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin')){


        $user = User::findOrFail($id);
      

        $userrole = auth()->user();
        $userroleadmin = auth()->user();
        $admin_role_id = $userroleadmin->roles[0]->id;
        if($admin_role_id === 1 ||  $admin_role_id===2){
             $userrole = auth()->user();
            $roles = Role::get();
            return view('backend.manage.user.user-edit', [
                'user' => $user,
                'roles' => $roles,
               
            ]); 
        }
        $user_role_id = $userrole->roles[0]->id;
        
        $roles = DB::table('roles')
                    ->whereNotBetween('id', [1 ,$user_role_id])->get();

        // dd($roles);

 
         return view('backend.manage.user.user-edit', [
            'user' => $user,
            'roles' => $roles,
            
        ]); 

        }elseif(auth()->user()->hasRole('branch-manager')){


            $idcheck_id2 = $id;

            if($idcheck_id2==1){
                // return "You have not right to Access";
                abort(403,'You have not right to Access');

            }elseif($idcheck_id2==2){
                // return "You have not right to Access"; 
                abort(403,'You have not right to Access');

            }else{
                 $idcheck_id = $idcheck_id2;
            }

            $user = User::findOrFail($idcheck_id);
      



        $userrole = auth()->user();
        $userroleadmin = auth()->user();
        $admin_role_id = $userroleadmin->roles[0]->id;
        if($admin_role_id === 1 ||  $admin_role_id===2){
             $userrole = auth()->user();
            $roles = Role::get();
           
            return view('backend.manage.user.user-edit', [
                'user' => $user,
                'roles' => $roles,
               
            ]); 

            //  dd($roles);
        }
        $user_role_id = $userrole->roles[0]->id;
        //  dd($user_role_id);
        
        $roles = DB::table('roles')
                    ->whereNotBetween('id', [1 ,$user_role_id])->get();

       

        
         return view('backend.manage.user.user-edit', [
            'user' => $user,
            'roles' => $roles,
            
        ]); 

        }

        
       
    }
    
    // =====================================  End User Edit===================================


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     // =====================================   User Update====================================
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|max:255|unique:users,id,'.$id,
        ]);

        
       
        $user =  User::findOrFail($id);
        
        $status = $request->input('user-status') ? $request->input('user-status') : 1;
        $user->status       = $status;
        $user->name         = $request->input('name');
        $user->email  = $request->input('email');

        $password = $request->input('password');
        
        // IF has password in input field than if condition is working  and then password  change
        if ( $password )
        {
           $user->password  = Hash::make($password) ;
        }
        // IF password in input field is empty then else condtion is working  (password not change)
        else {
            $user->password  = $user->password;
        }
      

        
        
        $user->save();
        Session::flash('message', 'Successfully Updated!');
        
        // user and role one tow many relationship  
        $user->roles()->sync([$request->input('role')]);


        
        return redirect()->route('users.edit', $user->id);
    }

     // =====================================   end User Update====================================

    // public function profile()
    // {
    //     $id = Auth::user()->id;
    //     $user = User::findOrFail($id);
      
    //     $roles = Role::get();
    //     return view('backend.pages.profile-edit', [
    //         'user' => $user,
    //         'roles' => $roles
    //     ]);
    
    // } 



    //  public function destroy($id)
    // {
    //     // delete
    //     $nerd = Nerd::find($id);
    //     $nerd->delete();

    //     // redirect
    //     Session::flash('message', 'Successfully deleted the nerd!');
    //     return Redirect::to('nerds');
    // } 


    // public function destroy($id)
    // {   

    //     // return 'ok';
    //     $User = User::findOrFail($id);
    //     $User->delete();

    //     Session::flash('message', 'Successfully Deleted!');
        
    // }


    public function users_delete($id){
        $tb_metting_del=DB::table('tb_meetings')->where('tb_meetings.id',$id)->delete();
        if ($tb_metting_del) {
            return response()->json(['success' => 'Meeting has successfully  Deleted!']);

        } else {
            return 0;
        }
    }



}
