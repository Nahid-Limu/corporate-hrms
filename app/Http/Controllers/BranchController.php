<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Carbon\Carbon;
use Validator;
use App\Repositories\Settings;
class BranchController extends Controller
{
    protected $settings;

    public function __construct()
    {
        // create object of settings class
        $this->settings = new Settings();
    }

    /**
     * Retive branch from table and show in blade
     */
    public function branch_list()
    {   
         $this->checkuserRole(['admin','super-admin','branch-manager'],'');
        $branch_list = DB::table('tb_branch')->orderBy('id', 'desc')
        ->leftJoin('users','tb_branch.created_by','=','users.id')
        ->select('tb_branch.id','tb_branch.branch_name','tb_branch.address','tb_branch.status','users.name')
        ->get();
        if(request()->ajax())
        {
            return datatables()->of($branch_list)
                    ->addColumn('action', function($data){
                        $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-blue btn-xs" data-toggle="modal" data-target="#editBranch" data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>';
                        $button .= '&nbsp;&nbsp;';
                         if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin')){
                        return $button;
                         }
                    })
                    ->rawColumns(['action'])
                    ->addIndexColumn()
                    ->make(true);
        }

        return view('backend.branch.branch_list');
    }

    /**
     * add new Branch
     */
    public function branch_add(Request $request)
    {
       $rules = array(
            'branch_name'=>'required|unique:tb_branch', 
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $branch_create = DB::table('tb_branch')->insert([
            'branch_name'=>$request->branch_name,
            'address'=>$request->address,
            'status'=>1,
            'created_by'=>Auth::user()->id,
            'created_at'=>Carbon::now()->toDateTimeString(),
            'updated_at'=>Carbon::now()->toDateTimeString()
        ]);

        if ($branch_create) {
            return response()->json(['success' => 'Branch successfully added.']);
            //return "Department added Successfully";
         } else {
            return 0;
         }
    }

    /**
     * Edit branch modal
     */
    public function branch_edit($id)
    {
        $branch = DB::table('tb_branch')->where('id',$id)->first(['id','branch_name','address','status']);
        return response()->json($branch);
    }

    /**
     * Update branch
     */
    public function branch_update(Request $request)
    {
        $rules = array(
            'edit_branch_name'=>'required', 
        );
        $error = Validator::make($request->all(), $rules);
        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $branch =  DB::table('tb_branch')
            ->where('branch_name',$request->edit_branch_name)
            ->first();
        
        if ($branch) {
            $branch_update =  DB::table('tb_branch')
            ->where('id',$request->id)
            ->update(
                [
                    
                    'address' =>$request->edit_address,
                    'status' =>$request->status
                    
                ]
            );
            if ($branch->address != $request->edit_address) {
                return response()->json(['success' => 'Branch Name Exist !!! Other Information has been successfully updated']);
                //return "Department added Successfully";
            }elseif ($branch->status != $request->status) {
                return response()->json(['success' => 'Branch Name Exist !!! Other Information has been successfully updated']);
            }else {
                return response()->json(['falied' => 'Update Nothing.']);
            }
        }else {
            $branch_update =  DB::table('tb_branch')
            ->where('id',$request->id)
            ->update(
                [
                    'branch_name' =>$request->edit_branch_name,
                    'address' =>$request->edit_address,
                    'status' =>$request->status
                    
                ]
            );
            if ($branch_update) {
                return response()->json(['success' => 'Information has been successfully updated.']);
                //return "Department added Successfully";
            } else {
                return response()->json(['falied' => 'Update Nothing.']);
            }
        }
          
    }


    /**
     * Get all active branch.
     */
    public function get_branch()
    {  

        if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin')){

             $branch = $this->settings->all_branch();
            return view('backend.ajax.get_branch',compact('branch'));
        }else{
             $branch=$this->settings->branchname_loginemployee();
            //  $branch = $this->settings->all_branch();
            return view('backend.ajax.get_login_user_branch',compact('branch'));
        }
       
    }

}
