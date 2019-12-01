<?php

namespace App\Http\Controllers;

use Session;
use Carbon\Carbon;
use App\Permission;
use Illuminate\Http\Request;
use DB;



class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // ===================================== Permission  Index ====================================

    public function index()
    {   
        $this->checkuserRole(['admin','super-admin'],'');
        $paginate = 15;
        $permissions = Permission::orderBy('created_at', 'DESC')->paginate($paginate);
        return view('backend.manage.permission.permission-list', [
            'permissions' => $permissions
        ]);
    }

    // =====================================  End Permission  Index ====================================

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
  

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    // =====================================  Permission  Create ====================================

    public function create()
    {
//        $this->checkPermission('manage-permission');
        $this->checkuserRole(['admin','super-admin'],'');
        return view('backend.manage.permission.permission_create');
    }

    // =====================================  End Permission  Create ====================================


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    // ===================================== Permission  Store ====================================

    public function store(Request $request)
    {
         $request->validate([
            'display_name' => 'required|max:255',
            'name' => 'required|unique:permissions|max:255'
        ]);

        $permission = new Permission();

        $permission->name         = $request->input('name');
        $permission->display_name = $request->input('display_name');
        $permission->description  = $request->input('description');
        $permission->save();

        Session::flash('message', 'Successfully Created!');

        return redirect()->route('permissions.edit', $permission->id);
    } 

    // =====================================  End Permission  Store ====================================


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    // =====================================  Permission  Show ====================================
    
    public function show($id)
    {   
        $this->checkuserRole(['admin','super-admin'],'');

        $permission = Permission::findOrFail($id);
        
        return view('backend.pages.Permission-view', [
            'permission' => $permission
        ]);
        
    }
    // =====================================  End Permission  Show ====================================

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    // =====================================   Permission  Edit ====================================

    public function edit($id)
    {   

        // TODO: Session massage hide not working  edit page

        // $this->checkPermission('manage-permission'); 
        $this->checkuserRole(['admin','super-admin'],'');
        $permission = Permission::findOrFail($id);

        
        return view('backend.manage.permission.permission-edit', [
            'permission' => $permission
        ]);
        
    }

    // =====================================  End Permission  Edit ====================================



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    // =====================================  Permission  Update ====================================
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'display_name' => 'required|max:255',
            'name' => 'required|max:255|unique:permissions,id,'.$id
        ]);
        $permission = Permission::findOrFail($id);
        
        $permission->name         = $request->input('name');
        $permission->display_name = $request->input('display_name');
        $permission->description  = $request->input('description');
        $permission->save();

        Session::flash('message', 'Successfully Updated!');
        
        return redirect()->route('permissions.edit', $permission->id);
    }

    // =====================================  End Permission  Update ====================================

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {   
    //     $this->checkPermission('manage-permission');
    //     $permission = Permission::findOrFail($id);
    //     $permission->delete();
    // }
}
