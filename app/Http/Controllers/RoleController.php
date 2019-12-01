<?php

namespace App\Http\Controllers;

use Session;
use App\Role;
use App\Permission;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * 
     */

     // =====================================  Role  index====================================

    public function index()
    {   
         $this->checkuserRole(['admin','super-admin'],''); 

        //  $this->canUser('manage-users');
        $paginate = config('app.pagenation_count', 10);

        $roles = Role::orderBy('created_at', 'DESC')->paginate($paginate);
        
        return view('backend.manage.role.role-list', [
            'roles' => $roles
        ]); 
    }

     // =====================================  End Role  index ====================================

 

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response 
     * 
     */
    // =====================================   Role  Create ====================================

    public function create()
    {
         $this->checkuserRole(['admin','super-admin'],''); 
        $permissions = Permission::get();

        return view('backend.manage.role.role-create', [
            'permissions' => $permissions
        ]);

    }

     // =====================================  End Role  Create ====================================

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    // ===================================== Role Store ====================================
    public function store(Request $request)
    {
        
        $request->validate([
        'display_name' => 'required|max:255',
        'name' => 'required|unique:roles|max:255'
    ]);
    
        $role = new Role();

        $role->name         = $request->input('name');
        $role->display_name = $request->input('display_name');
        $role->description  = $request->input('description');
        $role->save();

        Session::flash('message', 'Successfully Created!');

        $role->permissions()->sync($request->input('permissions'));


        return redirect()->route('roles.edit', $role->id);

    }

    // =====================================  End Role  Store ====================================


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    // =====================================  Role  Show ====================================

    public function show($id)
    {   

        $this->checkuserRole(['admin','super-admin'],'');
        $role = Role::with('permissions')->findOrFail($id);

        return view('backend.pages.role-view', [
            'role' => $role
        ]);
    }

    // =====================================  End Role  Show ====================================


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // ===================================== Role  Edit ====================================

    public function edit($id)
    {   

        // TODO: Session massage hide not working  edit page

        $this->checkuserRole(['admin','super-admin'],'');
        $role = Role::findOrFail($id); 

        $permissions = Permission::get();
        
        return view('backend.manage.role.role-edit', [
            'role' => $role,
            'permissions' => $permissions
        ]);
    } 

    // =====================================  End Role  Edit ====================================


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    // =====================================  End Role  Update ====================================

    public function update(Request $request, $id)
    {
        $request->validate([
            'display_name' => 'required|max:255',
            // 'name' => 'required|max:255|unique:roles,id,'.$id
        ]);

        $role = Role::findOrFail($id);
        
        // $role->name         = $request->input('name');
        $role->display_name = $request->input('display_name');
        $role->description  = $request->input('description');
        $role->save();

        Session::flash('message', 'Successfully Updated!');
        
        // role and permissions  role one to many relationship permission
        $role->permissions()->sync($request->input('permissions'));

        return redirect()->route('roles.edit', $role->id);
    }

    // =====================================  End Role  Update ====================================


    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {
    //     $this->checkPermission('manage-role');
    //     $role = Role::findOrFail($id);
    //     $role->delete();

    //     Session::flash('message', 'Successfully Deleted!');
        
    // }
}
