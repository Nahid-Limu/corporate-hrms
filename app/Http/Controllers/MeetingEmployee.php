<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Carbon\Carbon;
use Validator;
use App\Repositories\Settings;

use Illuminate\Http\Request;

class MeetingEmployee extends Controller
{
  protected $branche;
    public function __construct()
    {
        // create object of settings class
        $this->branche = new Settings();
    }


    // =====================================  Group List  ============================================
    
    public function meeting_employee_list()
    { 
        
        if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin')){
            $employeeName = DB::table('tb_employee')->select('id','emp_first_name','emp_lastName','employeeId')->where('emp_ot_status',1)->get();
        $smeetingNmae = DB::table('tb_meetings')->select('id','meeting_subject')->get();
        $branch_list=$this->branche->all_branch();
        $branch_list2=$this->branche->branchname_loginemployee();
        $meeting_employee_list = DB::table('tb_meeting_employee')->orderBy('id', 'desc')
        ->leftJoin('users','tb_meeting_employee.created_by','=','users.id')
        ->leftJoin('tb_employee','tb_meeting_employee.emp_id','=','tb_employee.id')
        ->leftJoin('tb_meetings','tb_meeting_employee.meeting_id','=','tb_meetings.id')
        ->select('tb_meeting_employee.id','users.name','tb_employee.emp_first_name','tb_meetings.meeting_subject','tb_meeting_employee.status')

        ->get();
        //  dd($meeting_employee_list);
        if(request()->ajax())
        {
            return datatables()->of($meeting_employee_list)
                    ->addColumn('action', function($data){
                        $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-blue btn-xs" data-toggle="modal" data-target="#edit_meeting_employee" data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>';
                        $button .= '&nbsp;&nbsp;';
                        
                        return $button;
                    })
                    ->editColumn('meeting_subject', function ($meeting_employee_list) {
                        return ucwords($meeting_employee_list->meeting_subject);
                    })
                    ->editColumn('emp_first_name', function ($meeting_employee_list) {
                        return ucwords($meeting_employee_list->emp_first_name);
                    })
                    ->rawColumns(['action'])
                    ->addIndexColumn()
                    ->make(true);
        }

        return view('backend.meeting_employee.meeting_employee_list',compact('employeeName','branch_list','smeetingNmae','branch_list2'));
        }else{

        $employeeName = DB::table('tb_employee')->select('id','emp_first_name','emp_lastName','employeeId')->where('emp_ot_status',1)->get();
        $smeetingNmae = DB::table('tb_meetings')->select('id','meeting_subject')->get();
        $branch_list=$this->branche->all_branch();
        $branch_list2=$this->branche->branchname_loginemployee();
        $branch_emp_id=$this->branche->branchname_loginemployee();
        $meeting_employee_list = DB::table('tb_meeting_employee')->orderBy('id', 'desc')
        ->leftJoin('users','tb_meeting_employee.created_by','=','users.id')
        ->leftJoin('tb_employee','tb_meeting_employee.emp_id','=','tb_employee.id')
        ->leftJoin('tb_meetings','tb_meeting_employee.meeting_id','=','tb_meetings.id')
        ->select('tb_meeting_employee.id','users.name','tb_employee.emp_first_name','tb_meetings.meeting_subject','tb_meeting_employee.status')
        ->where('tb_meetings.branch_id', $branch_emp_id->id)
        ->get();
        //  dd($meeting_employee_list);
        if(request()->ajax())
        {
            return datatables()->of($meeting_employee_list)
                    ->addColumn('action', function($data){
                        $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-blue btn-xs" data-toggle="modal" data-target="#edit_meeting_employee" data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>';
                        $button .= '&nbsp;&nbsp;';
                        
                        return $button;
                    })
                    ->editColumn('meeting_subject', function ($meeting_employee_list) {
                        return ucwords($meeting_employee_list->meeting_subject);
                    })
                    ->editColumn('emp_first_name', function ($meeting_employee_list) {
                        return ucwords($meeting_employee_list->emp_first_name);
                    })
                    ->rawColumns(['action'])
                    ->addIndexColumn()
                    ->make(true);
        }

        return view('backend.meeting_employee.meeting_employee_list',compact('employeeName','branch_list','smeetingNmae','branch_list2'));
        }
        
    } 
    
    // ===================================== End Meeting Employee List  ============================================



    // =====================================  Meeting Employee Add  ============================================
    public function meeting_employee_add (Request $request)
    {   


        
         
       $rules = array(
            'meeting_id'=>'required:tb_meeting_employee', 
            'emp_id'=>'required:tb_meeting_employee', 
        );
      
        
        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        


        
        for($i=0;$i<count($request->emp_id);$i++){
            $meeting_employee = DB::table('tb_meeting_employee')->insert([
                'meeting_id'=>$request->meeting_id,
                'emp_id'=>$request->emp_id[$i],
                'created_by'=>Auth::user()->id,
                'status'=>1,
                'created_at'=>Carbon::now()->toDateTimeString(),
                'updated_at'=>Carbon::now()->toDateTimeString()
            ]);
        }

        if ($meeting_employee) {
            return response()->json(['success' => 'Meeting Employee Added successfully.']);
         } else {
            return 0;
         }
    } 
    // ===================================== End Meeting Employee Add  ============================================


    // ===================================== Meeting Employee Edit  ============================================

    public function meeting_employee_edit($id)
    {   
      
  

        
        $meeting_employee_edit = DB::table('tb_meeting_employee')
             ->leftJoin('tb_employee','tb_meeting_employee.emp_id','=','tb_employee.id')
             ->leftJoin('tb_branch','tb_employee.branch_id','=','tb_branch.id')
             ->select('tb_meeting_employee.id','tb_meeting_employee.meeting_id','tb_meeting_employee.emp_id','tb_meeting_employee.status','tb_branch.id as branch_id')
             ->where('tb_meeting_employee.id',$id)
             ->first();
         return response()->json($meeting_employee_edit);
    } 
    // ===================================== End  Meeting Employee Edit  ============================================


    // =====================================  Meeting Employee Update  ============================================
    
    public function meeting_employee_update(Request $request)
    {
      


             $meeting_employee_update =  DB::table('tb_meeting_employee')
            ->where('id', $request->id)
            ->update(
                [
                    'meeting_id'=>$request->edit_meeting_id,
                    'emp_id'=>$request->edit_emp_id,
                    'created_by'=>Auth::user()->id,
                    'status'=>$request->status,
                    'updated_at'=>Carbon::now()->toDateTimeString()
                    
                    
                ]
                 
            );

            if( $meeting_employee_update){

                return response()->json(['success' => 'Update successfully !!!']);
            }else{
               return response()->json(['falied' => 'Update Nothing.']);
            }
          
    }

    // ===================================== End  Meeting Employee Update  ============================================


      /**
    * Get employee active grade.
    */
    public function get_meeting_employeegroup()
    {  
        $employee = $this->branche->all_employee();
        return view('backend.ajax.get_employee',compact('employee'));
    }


    
     public function meetingemployeeId($id){

       $employeeId=DB::table('tb_employee')->where('branch_id',$id)->select('tb_employee.id as emp_id','emp_first_name','emp_lastName','tb_employee.employeeId')->get();
       return response()->json($employeeId);
     }
}
