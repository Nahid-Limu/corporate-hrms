<?php

namespace App\Http\Controllers;
use DB;
use Auth;
use Carbon\Carbon;
use Validator;
use App\Repositories\Settings;

use Illuminate\Http\Request;

class FestivalLeave extends Controller
{
       protected $branche;
    public function __construct()
    {
        // create object of settings class
        $this->branche = new Settings();
    }
  

    // =====================================  Group List  ============================================
    
    public function festival_leave_list()
    { 
          $this->checkuserRole(['admin','super-admin','branch-manager'],'');

        
        // $group_leader = DB::table('tb_employee')->select('id','emp_first_name','emp_lastName','employeeId')->get();
        // $branch_list=$this->branche->all_branch();
        $festival_leave_list = DB::table('tb_festival_leave')->orderBy('id', 'desc')
        ->select('tb_festival_leave.id','tb_festival_leave.title','tb_festival_leave.start_date','tb_festival_leave.end_date','tb_festival_leave.remarks')

        ->get();
        //  dd($festival_leave_list);
        if(request()->ajax())
        {
            return datatables()->of($festival_leave_list)
                    ->addColumn('action', function($data){
                        $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-blue btn-xs" data-toggle="modal" data-target="#edit_festival_leave" data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>';
                        $button .= '&nbsp;&nbsp;';
                     if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin')){
                        return $button;
                    }
                    })
                    // ->editColumn('title', function ($festival_leave_list) {
                    //     return ucwords($festival_leave_list->title);
                    // })
                    // ->editColumn('assets_name', function ($festival_leave_list) {
                    //     return ucwords($festival_leave_list->assets_name);
                    // })
                    ->rawColumns(['action'])
                    ->addIndexColumn()
                    ->make(true);
        }

        return view('backend.festival_leave.festival_leave_list');
    } 
    public function festival_leave_list_listemployee()
    { 
        
        $festival_leave_list = DB::table('tb_festival_leave')->orderBy('id', 'desc')
        
        ->select('tb_festival_leave.id','tb_festival_leave.title','tb_festival_leave.start_date','tb_festival_leave.end_date','tb_festival_leave.remarks')

        ->get();
        if(request()->ajax())
        {
            return datatables()->of($festival_leave_list)
                    ->addColumn('action', function($data){
                        $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-blue btn-xs" data-toggle="modal" data-target="#edit_festival_leave" data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>';
                        $button .= '&nbsp;&nbsp;';
                     if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin')){
                        return $button;
                    }
                    })
                    // ->editColumn('title', function ($festival_leave_list) {
                    //     return ucwords($festival_leave_list->title);
                    // })
                    // ->editColumn('assets_name', function ($festival_leave_list) {
                    //     return ucwords($festival_leave_list->assets_name);
                    // })
                    ->rawColumns(['action'])
                    ->addIndexColumn()
                    ->make(true);
        }

        return view('backend.festival_leave.festival_leave_list_employee');
    } 
    
    // ===================================== End Group List  ============================================



    // =====================================  Group Add  ============================================
    public function festival_leave_add(Request $request)
    {
       $rules = array(
            'title'=>'required:tb_festival_leave', 
            'start_date'=>'required:tb_festival_leave', 
            'end_date'=>'required:tb_festival_leave', 
        );


        //  return response()->json(['success' => 'Group Added successfully.']);
        
        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        // $earlier = new DateTime("2010-07-06");
        // $later = new DateTime("2010-07-09");

        // $diff = $later->diff($earlier)->format("%a");

        

        $employee_assets = DB::table('tb_festival_leave')->insert([
            'title'=>$request->title,
            // 'remarks'=>$request->remarks,
            'remarks'=>$request->remarks,
            'start_date'=>$request->start_date,
            'end_date'=>$request->end_date,
            'created_at'=>Carbon::now()->toDateTimeString(),
            'updated_at'=>Carbon::now()->toDateTimeString()
        ]);

        if ($employee_assets) {
            return response()->json(['success' => 'Festival Leave Added successfully.']);
         } else {
            return 0;
         }
    } 
    // ===================================== End Group Add  ============================================




    // ===================================== Group Edit  ============================================

    public function festival_leave_edit($id)
    {   
        



        $group_edit = DB::table('tb_festival_leave')->where('id',$id)->first(['id','title','remarks','start_date','end_date']);
        return response()->json($group_edit);


    } 
    // ===================================== End Group Edit  ============================================


    // ===================================== Group Update  ============================================
    
    public function festival_leave_update(Request $request)
    {
            $festival_leave_update =  DB::table('tb_festival_leave')
            ->where('id',$request->id)
            ->update(
                [
                    'title' =>$request->edit_title,
                    'start_date' =>$request->edit_start_date,
                    'end_date' =>$request->edit_end_date,
                    'remarks' =>$request->edit_remarks,
                    'updated_at'=>Carbon::now()->toDateTimeString()
                    
                    
                ]
            );

            if( $festival_leave_update){

                return response()->json(['success' => 'Update successfully !!!']);
            }else{
               return response()->json(['falied' => 'Update Nothing.']);
            }
        
          
    }

    // ===================================== End Group Update  ============================================



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
