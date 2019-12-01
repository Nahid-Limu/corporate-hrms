<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Carbon\Carbon;
use Validator;
use App\Repositories\Settings;
use Illuminate\Http\Request;

class GroupController extends Controller
{    

    protected $branche;
    public function __construct()
    {
        // create object of settings class
        $this->branche = new Settings();
    }
  

    // =====================================  Group List  ============================================
    
    public function group_list()
    {   

        if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin')){
             $group_leader = DB::table('tb_employee')->select('id','emp_first_name','emp_lastName','employeeId')->get();
        $branch_list=$this->branche->all_branch();
        $branch_list2=$this->branche->branchname_loginemployee();
        $group_list = DB::table('tb_groups')->orderBy('id', 'desc')
        ->leftJoin('users','tb_groups.created_by','=','users.id')
        ->leftJoin('tb_employee','tb_groups.group_leader_id','=','tb_employee.id')
        ->select('tb_groups.id','tb_groups.group_name','tb_groups.status','users.name','tb_employee.emp_first_name','tb_employee.employeeId')

        ->get();
        //  dd($group_leader);
        if(request()->ajax())
        {
            return datatables()->of($group_list)
                    ->addColumn('action', function($data){
                        $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-blue btn-xs" data-toggle="modal" data-target="#editGroup" data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>';
                        $button .= '&nbsp;&nbsp;';
                        
                        return $button;
                    })
                    ->editColumn('group_name', function ($group_list) {
                        return ucwords($group_list->group_name);
                    })
                    ->editColumn('emp_first_name', function ($group_list) {
                        return ucwords($group_list->emp_first_name);
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('backend.group.group_list',compact('group_leader','branch_list','branch_list2'));
        }else{
         
        $branch_id=$this->branche->branchname_loginemployee();

        $group_leader = DB::table('tb_employee')->select('id','emp_first_name','emp_lastName','employeeId')->get();
        $branch_list=$this->branche->all_branch();
        $branch_list2=$this->branche->branchname_loginemployee();
        // dd( $branch_list);
        $group_list = DB::table('tb_groups')->orderBy('id', 'desc')
        ->leftJoin('users','tb_groups.created_by','=','users.id')
        ->leftJoin('tb_employee','tb_groups.group_leader_id','=','tb_employee.id')
        ->select('tb_groups.id','tb_groups.group_name','tb_groups.status','users.name','tb_employee.emp_first_name','tb_employee.employeeId')
         ->where('tb_employee.branch_id', $branch_id->id)
        ->get();
        //  dd($group_leader);
        if(request()->ajax())
        {
            return datatables()->of($group_list)
                    ->addColumn('action', function($data){
                        $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-blue btn-xs" data-toggle="modal" data-target="#editGroup" data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>';
                        $button .= '&nbsp;&nbsp;';
                        
                        return $button;
                    })
                    ->editColumn('group_name', function ($group_list) {
                        return ucwords($group_list->group_name);
                    })
                    ->editColumn('emp_first_name', function ($group_list) {
                        return ucwords($group_list->emp_first_name);
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('backend.group.group_list',compact('group_leader','branch_list','branch_list2'));
        }
        
       
    } 
    
    // ===================================== End Group List  ============================================



    // =====================================  Group Add  ============================================
    public function group_add(Request $request)
    {
       $rules = array(
            'group_name'=>'required|unique:tb_groups', 
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $group_create = DB::table('tb_groups')->insert([
            'group_name'=>$request->group_name,
            'group_leader_id'=>$request->group_leader_id,
            'remarks'=>$request->remarks,
            'status'=>1,
            'created_by'=>Auth::user()->id,
            'created_at'=>Carbon::now()->toDateTimeString(),
            'updated_at'=>Carbon::now()->toDateTimeString()
        ]);

        if ($group_create) {
            return response()->json(['success' => 'Group Added successfully.']);
         } else {
            return 0;
         }
    } 
    // ===================================== End Group Add  ============================================




    // ===================================== Group Edit  ============================================

    public function group_edit($id)
    {   
      
        $group_edit = DB::table('tb_groups')->where('id',$id)->first(['id','group_name','remarks','group_leader_id','status']);
        return response()->json($group_edit);
    } 
    // ===================================== End Group Edit  ============================================


    // ===================================== Group Update  ============================================
    
    public function group_update(Request $request)
    {


     

        $group =  DB::table('tb_groups')
            ->where('group_name',$request->edit_group_name)
            ->first();
        
        if ($group) {
            $group_update =  DB::table('tb_groups')
            ->where('id',$request->id)
            ->update(
                [
                    'group_leader_id' =>$request->edit_group_leader_id,
                    'remarks' =>$request->edit_remarks,
                    'status' =>$request->status
                    
                ]
            );
            if ($group->group_leader_id != $request->edit_group_leader_id) {
                return response()->json(['success' => 'Group Leader Type Update only!!!']);
                //return "Department added Successfully";
            }elseif ($group->remarks != $request->edit_remarks) {
                return response()->json(['success' => 'remarks Update only!!!']);
            }elseif ($group->status != $request->status) {
                return response()->json(['success' => 'Status Update only!!!']);
            }else {
                return response()->json(['falied' => 'Update Nothing.']);
            }
        }else {
            $group_update =  DB::table('tb_groups')
            ->where('id',$request->id)
            ->update(
                [
                    'group_name' =>$request->edit_group_name,
                    'group_leader_id' =>$request->edit_group_leader_id,
                    'remarks' =>$request->edit_remarks,
                    'status' =>$request->status
                    
                ]
            );
            if ($group_update) {
                return response()->json(['success' => 'Update successfully !!!']);
                //return "Department added Successfully";
            } else {
                return response()->json(['falied' => 'Update Nothing.']);
            }
        }
          
    }

    // ===================================== End Group Update  ============================================



    /**
    * Get employee active grade.
    */
    public function get_employeegroup()
    {  
        $employee = $this->branche->all_employee();
        return view('backend.ajax.get_employee',compact('employee'));
    }




      public function get_all_branch()
    {  
        $all_branch = $this->branche->all_branch();
        return view('backend.ajax.all_branch',compact('all_branch'));
    }


    public function branchemployeeId($id){

       $employeeId=DB::table('tb_employee')->where('branch_id',$id)->select('tb_employee.id as emp_id','emp_first_name','emp_lastName','tb_employee.employeeId')->get();
       return response()->json($employeeId);
     }


}
