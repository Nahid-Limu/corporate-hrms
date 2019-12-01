<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Carbon\Carbon;
use Validator;
use App\Repositories\Settings;

use Illuminate\Http\Request;

class SeverancePackageEmployeeController extends Controller
{
    protected $branche;
    public function __construct()
    {
        // create object of settings class
        $this->branche = new Settings();
    }


    // =====================================  Severance Package Employee List  ============================================
    
    public function severance_package_list()
    { 
        
        $employeeName = DB::table('tb_employee')->select('id','emp_first_name','emp_lastName','employeeId')->where('emp_ot_status',1)->get();
        $severancePackageNmae = DB::table('tb_severance_package')->select('id','package_name','package_type')->where('status',1)->get();
        $branch_list=$this->branche->all_branch();
        $group_list = DB::table('tb_severance_package_employee')->orderBy('id', 'desc')
        ->leftJoin('users','tb_severance_package_employee.created_by','=','users.id')
        ->leftJoin('tb_employee','tb_severance_package_employee.emp_id','=','tb_employee.id')
        ->leftJoin('tb_severance_package','tb_severance_package_employee.package_id','=','tb_severance_package.id')
        ->select('tb_severance_package_employee.id','users.name','tb_employee.emp_first_name','tb_employee.employeeId','tb_severance_package.package_name')

        ->get();
        //  dd($group_list);
        if(request()->ajax())
        {
            return datatables()->of($group_list)
                    ->addColumn('action', function($data){
                        $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-blue btn-xs" data-toggle="modal" data-target="#edit_severance_package_employee" data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>';
                        $button .= '&nbsp;&nbsp;';
                        
                        return $button;
                    })
                    ->editColumn('package_name', function ($group_list) {
                        return ucwords($group_list->package_name);
                    })
                    ->editColumn('emp_first_name', function ($group_list) {
                        return ucwords($group_list->emp_first_name);
                    })
                    ->rawColumns(['action'])
                    ->addIndexColumn()
                    ->make(true);
        }

        return view('backend.severance_package_employee.severance_package_employee_list',compact('employeeName','branch_list','severancePackageNmae'));
    } 
    
    // ===================================== End Severance Package Employee List  ============================================



    // =====================================  Severance Package Employee Add  ============================================
    public function severance_package_add (Request $request)
    {   

         
       $rules = array(
            'package_id'=>'required:tb_severance_package_employee', 
            'emp_id'=>'required:tb_severance_package_employee', 
        );
      
        
        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
         
      
        $group_create = DB::table('tb_severance_package_employee')->insert([
            'package_id'=>$request->package_id,
            'emp_id'=>$request->emp_id,
            'remarks'=>$request->remarks,
            'created_by'=>Auth::user()->id,
            'created_at'=>Carbon::now()->toDateTimeString(),
            'updated_at'=>Carbon::now()->toDateTimeString()
        ]);

        if ($group_create) {
            return response()->json(['success' => 'Severance Package has been successfully added.']);
         } else {
            return 0;
         }
    } 
    // ===================================== End Severance Package Employee Add  ============================================


    // ===================================== Severance Package Employee Edit  ============================================

    public function severance_package_edit($id)
    {   
      
        $group_employee_edit = DB::table('tb_group_employee')->where('id',$id)->first(['id','group_id','emp_id']);
        return response()->json($group_employee_edit);
    } 
    // ===================================== End Severance Package Employee  Edit  ============================================


    // ===================================== Severance Package Employee  Update  ============================================
    
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

    // ===================================== End Severance Package Employee Update  ============================================


    
     public function severanceemployeeId($id){

       $employeeId=DB::table('tb_employee')->where('branch_id',$id)->select('tb_employee.id as emp_id','emp_first_name','emp_lastName','tb_employee.employeeId')->get();
       return response()->json($employeeId);
     }
}
