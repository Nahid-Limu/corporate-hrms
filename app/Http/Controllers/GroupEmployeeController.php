<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Carbon\Carbon;
use Validator;
use App\Repositories\Settings;
use Illuminate\Http\Request;

class GroupEmployeeController extends Controller
{
    // TODO:  groupEmployee   

    protected $branche;
    public function __construct()
    {
        // create object of settings class
        $this->branche = new Settings();
    }


    // =====================================  Group List  ============================================
    
    public function group_employee_list()
    { 
        
       if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin')){

       
        $employeeName = DB::table('tb_employee')->select('id','emp_first_name','emp_lastName','employeeId')->where('emp_ot_status',1)->get();
        $group_name_table = DB::table('tb_groups')->select('id','group_name')->where('status',1)->get();
        $branch_list=$this->branche->all_branch();
        $branch_list2=$this->branche->branchname_loginemployee();
        $group_list = DB::table('tb_group_employee')->orderBy('id', 'desc')
        ->leftJoin('users','tb_group_employee.created_by','=','users.id')
        ->leftJoin('tb_employee','tb_group_employee.emp_id','=','tb_employee.id')
        ->leftJoin('tb_groups','tb_group_employee.group_id','=','tb_groups.id')
        ->select('tb_group_employee.id','users.name','tb_employee.emp_first_name','tb_employee.employeeId','tb_groups.group_name')
        ->get();
        //  dd($group_list);
        if(request()->ajax())
        {
            return datatables()->of($group_list)
                    ->addColumn('action', function($data){
                        $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-blue btn-xs" data-toggle="modal" data-target="#editEmployee_group" data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>';
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
                    ->addIndexColumn()
                    ->make(true);
        }

        return view('backend.group_employee.group_employee_list',compact('employeeName','group_name_table','branch_list','branch_list2'));
       }else{

        $branch_id=$this->branche->branchname_loginemployee();
        $branch_list2=$this->branche->branchname_loginemployee();
        $employeeName = DB::table('tb_employee')->select('id','emp_first_name','emp_lastName','employeeId')->where('emp_ot_status',1)->get();
        $group_name_table = DB::table('tb_groups')->select('id','group_name')->where('status',1)->get();
        $branch_list=$this->branche->all_branch();
        $group_list = DB::table('tb_group_employee')->orderBy('id', 'desc')
        ->leftJoin('users','tb_group_employee.created_by','=','users.id')
        ->leftJoin('tb_employee','tb_group_employee.emp_id','=','tb_employee.id')
        ->leftJoin('tb_groups','tb_group_employee.group_id','=','tb_groups.id')
        ->select('tb_group_employee.id','users.name','tb_employee.emp_first_name','tb_employee.employeeId','tb_groups.group_name')
        ->where('tb_employee.branch_id', $branch_id->id)
        ->get();
        //  dd($group_list);
        if(request()->ajax())
        {
            return datatables()->of($group_list)
                    ->addColumn('action', function($data){
                        $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-blue btn-xs" data-toggle="modal" data-target="#editEmployee_group" data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>';
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
                    ->addIndexColumn()
                    ->make(true);
        }

        return view('backend.group_employee.group_employee_list',compact('employeeName','group_name_table','branch_list','branch_list2'));
       }
    } 
    
    // ===================================== End Group List  ============================================



    // =====================================  Group Add  ============================================
    public function group_employee_add(Request $request)
    {   

         
       $rules = array(
            'group_id'=>'required|unique:tb_group_employee', 
        );

      
        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $group_create = DB::table('tb_group_employee')->insert([
            'group_id'=>$request->group_id ,
            'emp_id'=>$request->employee_id,
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

    public function group_employee_edit($id)
    {   
        

        
        $group_employee_edit = DB::table('tb_group_employee')->where('tb_group_employee.id',$id)
        ->leftJoin('tb_employee','tb_group_employee.emp_id','=','tb_employee.id')
         ->leftJoin('tb_branch','tb_employee.branch_id','=','tb_branch.id')
        ->select('tb_group_employee.id','tb_group_employee.emp_id','tb_group_employee.group_id','tb_branch.id as branch_id') 
         ->first();

        return response()->json($group_employee_edit);
    } 
    // ===================================== End Group Edit  ============================================


    // ===================================== Group Update  ============================================
    
    public function group_employee_update(Request $request)
    {

        // return response()->json(['falied' => 'Update Nothing.']);
     // TODO:  groupEmployee   update not working
        
        $group =  DB::table('tb_group_employee')
            ->where('group_id',$request->edit_group_id)
            ->first();
        if ($group) {
            $group_update =  DB::table('tb_group_employee')
            ->where('id', $request->id)
            ->update(
                [
                    'emp_id' =>$request->edit_employee_id
                ]
            );
            if ($group->emp_id != $request->edit_employee_id) {
                return response()->json(['success' => 'Employee Update only!!!']);
                //return "Department added Successfully";
            }else {
                return response()->json(['falied' => 'Update Nothing.']);
            }
        }else {
            $group_update =  DB::table('tb_group_employee')
            ->where('id',$request->id)
            ->update(
                [
                    'group_id' =>$request->edit_group_id,
                    'emp_id' =>$request->edit_employee_id,
                    
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


    
     public function employeeId($id){

       $employeeId=DB::table('tb_employee')->where('branch_id',$id)->select('tb_employee.id as emp_id','emp_first_name','emp_lastName','tb_employee.employeeId')->get();
       return response()->json($employeeId);
     }

}
