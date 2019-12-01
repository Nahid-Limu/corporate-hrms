<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Carbon\Carbon;
use Validator;
use App\Repositories\Settings;

use Illuminate\Http\Request;

class EmployeeAssets extends Controller
{
    protected $branche;
    public function __construct()
    {
        // create object of settings class
        $this->branche = new Settings();
    }
  

    // =====================================  Group List  ============================================
    
    public function employee_assets_list()
    {   

        if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin')){
             $group_leader = DB::table('tb_employee')->select('id','emp_first_name','emp_lastName','employeeId')->get();
                $branch_list=$this->branche->all_branch();
                $branch_list2=$this->branche->branchname_loginemployee();
                $employee_assets_list = DB::table('tb_employee_assets')->orderBy('id', 'desc')
                ->leftJoin('users','tb_employee_assets.created_by','=','users.id')
                ->leftJoin('tb_employee','tb_employee_assets.emp_id','=','tb_employee.id')
                ->select('tb_employee_assets.id','tb_employee_assets.assets_name','tb_employee_assets.assets_datetime','tb_employee_assets.status','users.name','tb_employee.emp_first_name','tb_employee.employeeId')

                ->get();
                //  dd($employee_assets_list);
                if(request()->ajax())
                {
                    return datatables()->of($employee_assets_list)
                            ->addColumn('action', function($data){
                                $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-blue btn-xs" data-toggle="modal" data-target="#editemployee_assets" data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>';
                                $button .= '&nbsp;&nbsp;';
                                
                                return $button;
                            })
                            ->editColumn('emp_first_name', function ($employee_assets_list) {
                                return ucwords($employee_assets_list->emp_first_name);
                            })
                            ->editColumn('assets_name', function ($employee_assets_list) {
                                return ucwords($employee_assets_list->assets_name);
                            })
                            ->rawColumns(['action'])
                            ->addIndexColumn()
                            ->make(true);
                }

                return view('backend.employee_assets.employee_assets_list',compact('group_leader','branch_list','branch_list2'));
        }else{

                $group_leader = DB::table('tb_employee')->select('id','emp_first_name','emp_lastName','employeeId')->get();
                $branch_list=$this->branche->all_branch();
                $branch_id=$this->branche->branchname_loginemployee();
                $branch_list2=$this->branche->branchname_loginemployee();
                // dd($branch_list);
                $employee_assets_list = DB::table('tb_employee_assets')->orderBy('id', 'desc')
                ->leftJoin('users','tb_employee_assets.created_by','=','users.id')
                ->leftJoin('tb_employee','tb_employee_assets.emp_id','=','tb_employee.id')
                ->select('tb_employee_assets.id','tb_employee_assets.assets_name','tb_employee_assets.assets_datetime','tb_employee_assets.status','users.name','tb_employee.emp_first_name','tb_employee.employeeId')
                ->where('tb_employee.branch_id', $branch_id->id)
                ->get();
                //  dd($employee_assets_list);
                if(request()->ajax())
                {
                    return datatables()->of($employee_assets_list)
                            ->addColumn('action', function($data){
                                $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-blue btn-xs" data-toggle="modal" data-target="#editemployee_assets" data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>';
                                $button .= '&nbsp;&nbsp;';
                                
                                return $button;
                            })
                            ->editColumn('emp_first_name', function ($employee_assets_list) {
                                return ucwords($employee_assets_list->emp_first_name);
                            })
                            ->editColumn('assets_name', function ($employee_assets_list) {
                                return ucwords($employee_assets_list->assets_name);
                            })
                            ->rawColumns(['action'])
                            ->addIndexColumn()
                            ->make(true);
                }

                return view('backend.employee_assets.employee_assets_list',compact('group_leader','branch_list','branch_list2'));
        }
        
       
    } 
    
    // ===================================== End EmployeeAssets List  ============================================



    // =====================================  EmployeeAssets Add  ============================================
    public function employee_assets_add(Request $request)
    {
       $rules = array(
            'assets_name'=>'required:tb_employee_assets', 
            'emp_id'=>'required:tb_employee_assets', 
        );

        //  return response()->json(['success' => 'Group Added successfully.']);
        
        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $employee_assets = DB::table('tb_employee_assets')->insert([
            'assets_name'=>$request->assets_name,
            'emp_id'=>$request->emp_id,
            'remarks'=>$request->remarks,
            'start_time'=>$request->start_time,
            'end_time'=>$request->end_time,
            'assets_datetime'=>$request->assets_date,
            'status'=>1,
            'created_by'=>Auth::user()->id,
            'created_at'=>Carbon::now()->toDateTimeString(),
            'updated_at'=>Carbon::now()->toDateTimeString()
        ]);

        if ($employee_assets) {
            return response()->json(['success' => 'Employee Assets has been successfully added.']);
         } else {
            return 0;
         }
    } 
    // ===================================== End Employee Assets Add  ============================================




    // ===================================== Employee Assets Edit  ============================================

    public function employee_assets_edit($id)
    {   
        



        // $group_edit = DB::table('tb_employee_assets')->where('id',$id)->first(['id','emp_id','assets_name','start_time','end_time','assets_datetime','status']);
        // return response()->json($group_edit);

        if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin')){

            $employee_assets_edit = DB::table('tb_employee_assets')
            ->leftJoin('tb_employee','tb_employee_assets.emp_id','=','tb_employee.id')
            ->leftJoin('tb_branch','tb_employee.branch_id','=','tb_branch.id')
            ->select('tb_employee_assets.id','tb_employee_assets.emp_id','tb_employee_assets.assets_name','tb_employee_assets.start_time','tb_employee_assets.end_time','tb_employee_assets.assets_datetime','tb_employee_assets.status','tb_employee_assets.remarks','tb_employee.emp_first_name',
            'tb_employee_assets.emp_id as bfit_emp_id','tb_branch.id as branch_id') 
            ->where('tb_employee_assets.id',$id)
            ->first();
            return response()->json($employee_assets_edit);
        }else{  
             $branch_id=$this->branche->branchname_loginemployee();
             $employee_assets_edit = DB::table('tb_employee_assets')
            ->leftJoin('tb_employee','tb_employee_assets.emp_id','=','tb_employee.id')
            ->leftJoin('tb_branch','tb_employee.branch_id','=','tb_branch.id')
            ->select('tb_employee_assets.id','tb_employee_assets.emp_id','tb_employee_assets.assets_name','tb_employee_assets.start_time','tb_employee_assets.end_time','tb_employee_assets.assets_datetime','tb_employee_assets.status','tb_employee_assets.remarks','tb_employee.emp_first_name',
            'tb_employee_assets.emp_id as bfit_emp_id','tb_branch.id as branch_id') 
            ->where('tb_employee_assets.id',$id)
            ->where('tb_employee.branch_id', $branch_id->id)
            ->first();
            return response()->json($employee_assets_edit);
        }

    
    } 
    // ===================================== End EmployeeAssets Edit  ============================================


    // ===================================== EmployeeAssets Update  ============================================
    
    public function employee_assets_update(Request $request)
    {







           $employee_assets_name_update =  DB::table('tb_employee_assets')
            ->where('id', $request->id)
            ->update(
                [
                    'assets_name'=>$request->edit_assets_name,
                    'emp_id'=>$request->edit_emp_id,
                    'remarks'=>$request->edit_remarks,
                    'start_time'=>$request->edit_start_time,
                    'end_time'=>$request->edit_end_time,
                    'assets_datetime'=>$request->edit_assets_date,
                    'status' =>$request->status
                    
                    
                ]
                 
            );

            if( $employee_assets_name_update){

                return response()->json(['success' => 'Update successfully !!!']);
            }else{
               return response()->json(['falied' => 'Update Nothing.']);
            }
          
    }

    // ===================================== End EmployeeAssets Update  ============================================



    /**
    * Get employee active grade.
    */
    public function get_employeegroup_assets()
    {  
        $employee = $this->branche->all_employee();
        return view('backend.ajax.get_employee',compact('employee'));
    }


    public function branchemployeeId($id){

       $employeeId=DB::table('tb_employee')->where('branch_id',$id)->select('tb_employee.id as emp_id','emp_first_name','emp_lastName','tb_employee.employeeId')->get();
       return response()->json($employeeId);
     }
}
