<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Carbon\Carbon;
use Validator;
use App\Repositories\Settings;
class TaskController extends Controller
{


    protected $settings;

    public function __construct()
    {
        // create object of settings class
        $this->settings = new Settings();
    }


    /**
     * Retive task from table and show in blade
     */
    public function task_list()
    
    {
          $this->checkuserRole(['admin','super-admin','branch-manager'],'');

        $task_list = DB::table('tb_task')->orderBy('id', 'desc')
        ->leftJoin('users','tb_task.created_by','=','users.id')
        ->select('tb_task.id','tb_task.title','tb_task.description','tb_task.attachment','tb_task.start_time','tb_task.end_time','tb_task.status','users.name')
        ->get();
        if(request()->ajax())
        {
            return datatables()->of($task_list)
                    ->addColumn('action', function($data){
                        $button = '<button type="button" name="view" id="'.$data->id.'" class="view btn btn-info btn-xs" data-toggle="modal" data-target="#deleteTask" data-placement="top" title="delete"><i class="fa fa-eye"></i></button>';
                        $button .= '&nbsp;&nbsp;';
                        $button1 = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-blue btn-xs" data-toggle="modal" data-target="#editTask" data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>';
                        $button1 .= '&nbsp;&nbsp;';
                        $button2 = '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-xs" data-toggle="modal" data-target="#deleteTask" data-placement="top" title="delete"><i class="fa fa-trash-o"></i></button>';
                        $button2 .= '&nbsp;&nbsp;';
                        $button.=$button1;
                        $button .=$button2;

                        
                        return $button;
                    })
                    ->addColumn('attachment', function($data){
                        if ($data->attachment != null) {
                            $asset = asset('task_attachment').'/'.$data->attachment ;
                            $button = '<a href="'.$asset.'" target="_blank"><span style="color:green">Open</span><i class="fa fa-download pull-right" aria-hidden="true"></i></a>';
                            $button .= '&nbsp;&nbsp;';
                        
                        return $button;
                        }else {
                            return '<span style="color:red">No Attachment</span>';
                        }
                        
                    })
                    ->editColumn('start_time', function ($task_list) {
                        return date('h:i A', strtotime($task_list->start_time));
                    })
                    ->editColumn('end_time', function ($task_list) {
                        return date('h:i A', strtotime($task_list->end_time));
                    })
                    ->rawColumns(['action','attachment'])
                    ->addIndexColumn()
                    ->make(true);
        }

        return view('backend.task.task_list');
    }

    /**
     * add new task
     */
    public function task_add(Request $request)
    {
        $rules = array(
            'title'=>'required|unique:tb_task'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        
           if($error->passes())
           {
            if($request->hasFile('attachment')) {
                
                    $attachment = $request->file('attachment');
                    $new_file = 'task'.'-'.time().'.'.$attachment->getClientOriginalExtension();
                    $attachment->move(public_path('task_attachment'), $new_file);
                    //$asset = asset('task_attachment').'/'.$new_file ;
                    $tb_task = DB::table('tb_task')->insert([
                                'title'=>$request->title,
                                'description'=>$request->description,
                                'attachment'=>$new_file,
                                'start_time'=>date("G:i", strtotime($request->start_time)),
                                'end_time'=>date("G:i", strtotime($request->end_time)),
                                'status'=>1,
                                'created_by'=>Auth::user()->id,
                                'created_at'=>Carbon::now()->toDateTimeString(),
                                'updated_at'=>Carbon::now()->toDateTimeString()
                            ]);

                            if ($tb_task) {
                                return response()->json(['success' => 'Task has been successfully added.']);
                                //return "Department added Successfully";
                            } else {
                                return 0;
                            }
                
                
            }else {
                
                   $tb_task = DB::table('tb_task')->insert([
                            'title'=>$request->title,
                            'description'=>$request->description,
                            'start_time'=>date("G:i", strtotime($request->start_time)),
                            'end_time'=>date("G:i", strtotime($request->end_time)),
                            'status'=>1,
                            'created_by'=>Auth::user()->id,
                            'created_at'=>Carbon::now()->toDateTimeString(),
                            'updated_at'=>Carbon::now()->toDateTimeString()
                        ]);
    
                        if ($tb_task) {
                            return response()->json(['success' => 'Task has been successfully added.']);
                            //return "Department added Successfully";
                        } else {
                            return 0;
                        }
            }
            
           }
           else
           {
            return response()->json(['errors' => $validation->errors()->all()]);
           }
           
        
    }

    /**
     * Edit TASK modal
     */
    public function task_edit($id)
    {
        $task = DB::table('tb_task')->where('id',$id)->first(['id','title','description','attachment','start_time','end_time','status']);
        return response()->json($task);
    }

    /**
     * Update task
     */
    public function task_update(Request $request)
    {
        $task_name =  DB::table('tb_task')
            ->where('title',$request->edit_title)
            ->first();

        if ($task_name) {
            //return response()->json(['success' => 'old']);
            if($request->hasFile('edit_attachment')) {

                //unlink existing file
                $task = DB::table('tb_task')->find($request->id);
                $file_path = public_path().'/task_attachment/'.$task->attachment;
                unlink($file_path);
                
                //update new file with other value
                $attachment = $request->file('edit_attachment');
                $new_file = 'task'.'-'.time().'.'.$attachment->getClientOriginalExtension();
                $attachment->move(public_path('task_attachment'), $new_file);
                //$asset = asset('task_attachment').'/'.$new_file ;
                $update_task = DB::table('tb_task')
                ->where('id',$request->id)
                ->update([
                            
                            'description'=>$request->edit_description,
                            'attachment'=>$new_file,
                            'start_time'=>date("G:i", strtotime($request->edit_start_time)),
                            'end_time'=>date("G:i", strtotime($request->edit_end_time)),
                            'status'=>$request->status
                            
                        ]);

                        if ($update_task) {
                            return response()->json(['success' => 'Task has been successfully updated.']);
                            //return "Department added Successfully";
                        } else {
                            return response()->json(['falied' => 'Update Nothing.']);
                        }
                
            } else {
                //update without file with other value
                $update_task = DB::table('tb_task')
                ->where('id',$request->id)
                ->update([

                            'description'=>$request->edit_description,
                            'start_time'=>date("G:i", strtotime($request->edit_start_time)),
                            'end_time'=>date("G:i", strtotime($request->edit_end_time)),
                            'status'=>$request->status
                            
                        ]);

                        if ($update_task) {
                            return response()->json(['success' => 'Task has been successfully updated.']);
                            //return "Department added Successfully";
                        } else {
                            return response()->json(['falied' => 'Update Nothing.']);
                        }
            }
        }else {
            //return response()->json(['success' => 'old']);
            if($request->hasFile('edit_attachment')) {

                //unlink existing file
                $task = DB::table('tb_task')->find($request->id);
                $file_path = public_path().'/task_attachment/'.$task->attachment;
                unlink($file_path);
                
                //update new file with other value
                $attachment = $request->file('edit_attachment');
                $new_file = 'task'.'-'.time().'.'.$attachment->getClientOriginalExtension();
                $attachment->move(public_path('task_attachment'), $new_file);
                //$asset = asset('Task_Attachment').'/'.$new_file ;
                $update_task = DB::table('tb_task')
                ->where('id',$request->id)
                ->update([
                            
                            'title'=>$request->edit_title,
                            'description'=>$request->edit_description,
                            'attachment'=>$new_file,
                            'start_time'=>date("G:i", strtotime($request->edit_start_time)),
                            'end_time'=>date("G:i", strtotime($request->edit_end_time)),
                            'status'=>$request->status
                            
                        ]);

                        if ($update_task) {
                            return response()->json(['success' => 'Task has been successfully updated.']);
                            //return "Department added Successfully";
                        } else {
                            return 0;
                        }
                
            } else {
                //update without file with other value
                $update_task = DB::table('tb_task')
                ->where('id',$request->id)
                ->update([
                    
                            'title'=>$request->edit_title,
                            'description'=>$request->edit_description,
                            'start_time'=>date("G:i", strtotime($request->edit_start_time)),
                            'end_time'=>date("G:i", strtotime($request->edit_end_time)),
                            'status'=>$request->status
                            
                        ]);

                        if ($update_task) {
                            return response()->json(['success' => 'Task has been successfully updated.']);
                            //return "Department added Successfully";
                        } else {
                            return 0;
                        }
            }
        }

            
          
    }

    /**
     * Delete task
     */

    public function task_delete($id){
        $delete_Task=DB::table('tb_task')->where('tb_task.id',$id)->delete();

        return response()->json(["success" =>"Task has been successfully deleted!"]);

    }
    /**
     * View task
     */
    public function task_view($id){
//        $get_name=DB::table('tb_task')
//            ->leftJoin('users','tb_task.created_by','=','users.id')
//            ->select('users.name')
//            ->get();
        $view_task=DB::table('tb_task')
            ->leftJoin('users','tb_task.created_by','=','users.id')
            ->where('tb_task.id','=',$id)
            ->first(['tb_task.*','users.name as userName']);
        return response()->json($view_task);
    }

    /**
     * assign task view
     */
    public function assign_task_view()
    {
          $this->checkuserRole(['admin','super-admin','branch-manager'],'');

        return view('backend.task.assign_task');
    }

    /**
     * Get assign_task_list
     */
    public function assign_task_list($id)
    {   


        if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin')){
               $assign_task_list = DB::table('tb_task_employee')
        ->leftJoin('tb_employee','tb_task_employee.emp_id','=','tb_employee.id')
        ->leftJoin('tb_task','tb_task_employee.task_id','=','tb_task.id')
        ->select('tb_task_employee.id','tb_task_employee.emp_id','tb_task.title','tb_task_employee.assign_date','tb_task_employee.status')
        ->where('tb_task_employee.emp_id', $id)
        ->get();
        
        if (count($assign_task_list) > 0) {
            //return response()->json($assign_task_list);
            return response()->json(['success' => $assign_task_list]);
        }else {
            return response()->json(['error' => 'No Task Assigned']);
        }
        }else{
         $branch_id=$this->settings->branchname_loginemployee();
         $assign_task_list = DB::table('tb_task_employee')
        ->leftJoin('tb_employee','tb_task_employee.emp_id','=','tb_employee.id')
        ->leftJoin('tb_task','tb_task_employee.task_id','=','tb_task.id')
        ->select('tb_task_employee.id','tb_task_employee.emp_id','tb_task.title','tb_task_employee.assign_date','tb_task_employee.status')
        ->where('tb_task_employee.emp_id', $id)
         ->where('tb_employee.branch_id', $branch_id->id)
        ->get();
        
        if (count($assign_task_list) > 0) {
            //return response()->json($assign_task_list);
            return response()->json(['success' => $assign_task_list]);
        }else {
            return response()->json(['error' => 'No Task Assigned']);
        }
        }
     
    }

    /**
     * Get all active task.
     */
    public function get_task()
    {  
        $task = $this->settings->all_task();
        return view('backend.ajax.get_task',compact('task'));
    }

    /**
     *task assinged to employee.
     */
    public function task_assigned(Request $request)
    {  
        foreach ($request->task_id as $key => $task) {
            $tb_task_employee[] = [
                    'emp_id' => $request->employee_id,
                    'task_id' => $task,
                    'status'=>1,
                    'assign_date'=>date('Y-m-d',strtotime($request->assign_date)),
                    'created_by'=>Auth::user()->id,
                    'created_at'=>Carbon::now()->toDateTimeString(),
                    'updated_at'=>Carbon::now()->toDateTimeString(),
            ];
        }

        $assign_task = DB::table('tb_task_employee')->insert($tb_task_employee);
        if ($assign_task) {
            return response()->json(['success' => 'Task has been successfully assigned.']);
        }else {
           return response()->json(['error' => 'Task Assigned error.']);
        }
    }

    public function employee_task_list(){
        $branchList=DB::table('tb_branch')->get();
        $departmentList=DB::table('tb_departments')->get(['id','department_name']);
        $designation=DB::table('tb_designations')->get(['id','designation_name']);

        return view('backend.task.employee_task_list',compact('branchList','departmentList','designation'));
    }
//    public function employee_get_view_list($id){
//        $employee=DB::table('tb_employee')
//            //->where('id','=',$id)
//                ->where('tb_employee.branch_id','=',$id)
//
//            //->leftJoin('tb_branch','tb_employee.branch_id','=','tb_branch.id')
//            //->leftJoin('tb_departments','tb_employee.emp_department_id','=','tb_departments.id')
//            ->select(DB::raw("CONCAT(tb_employee.emp_first_name,' ',tb_employee.emp_lastName) as full_name"),'tb_employee.id')
//            ->get();
//        //dd($employeList);
//
//        return view('backend.ajax.get_employee_fullname',compact('employee'));
//
//
//    }
//    public function employee_get_view_list($branch_id, $dept_id){
//        if($dept_id=='all'){
//            $employee=DB::table('tb_employee')
//                ->where('emp_account_status','=',1)
//                ->where('tb_employee.branch_id','=',$branch_id)
//                ->select(DB::raw("CONCAT(tb_employee.emp_first_name,' ',tb_employee.emp_lastName) as full_name"),'tb_employee.id','tb_employee.employeeId')
//                ->get();
//        }else{
//            $employee=DB::table('tb_employee')
//                ->where('emp_account_status','=',1)
//                ->where('tb_employee.branch_id','=',$branch_id)
//                ->where('tb_employee.emp_department_id','=',$dept_id)
//                ->select(DB::raw("CONCAT(tb_employee.emp_first_name,' ',tb_employee.emp_lastName) as full_name"),'tb_employee.id','tb_employee.employeeId')
//                ->get();
//        }
//
//
//        return view('backend.ajax.get_employee_fullname',compact('employee'));
//    }
    public function employee_task_show(Request $request){
        $start_date=$request->start_date;
        $end_date=$request->end_date;
        $status=$request->emp_task_status;
        $branch=$request->branch_id;
        $dept=$request->dept_id;
       $desig=$request->desig_id;
        $employee=$request->emp_id;

        if($request->search_type==1){
            if($_POST['branch_id']=='all'){
                //dd('all branch');
                $all_task=DB::table('tb_task_employee')
                    ->WhereBetween('tb_task_employee.assign_date',[$start_date, $end_date])
                    ->Where('tb_task_employee.status',$status)
                    ->leftJoin('tb_employee','tb_task_employee.emp_id','=','tb_employee.id')
                    ->leftJoin('tb_task','tb_task_employee.task_id','=','tb_task.id')
                    ->leftJoin('users','tb_task_employee.created_by','=','users.id')
                    ->leftJoin('tb_departments','tb_employee.emp_department_id','=','tb_departments.id')
                    ->leftJoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
                    ->leftJoin('tb_branch','tb_employee.branch_id','=','tb_branch.id')
                    ->select('tb_task_employee.assign_date','tb_task_employee.status as assign_status','tb_task_employee.remarks','tb_employee.employeeId','tb_employee.emp_first_name','tb_employee.emp_lastName','tb_task.title','tb_task.description','tb_task.attachment','tb_task.start_time','tb_task.end_time','tb_departments.department_name','tb_designations.designation_name','tb_branch.branch_name','users.name')
                    ->get();
                //dd($all_task);

            }else{
               // dd('specic branch');
                $all_task=DB::table('tb_task_employee')
                    ->WhereBetween('tb_task_employee.assign_date',[$start_date, $end_date])
                    ->Where('tb_task_employee.status',$status)
                    ->Where('tb_task_employee.emp_id',$employee)
                    ->leftJoin('tb_employee','tb_task_employee.emp_id','=','tb_employee.id')
                    ->leftJoin('tb_task','tb_task_employee.task_id','=','tb_task.id')
                    ->leftJoin('users','tb_task_employee.created_by','=','users.id')
                    ->leftJoin('tb_departments','tb_employee.emp_department_id','=','tb_departments.id')
                    ->leftJoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
                    ->leftJoin('tb_branch','tb_employee.branch_id','=','tb_branch.id')
                    ->select('tb_task_employee.assign_date','tb_task_employee.status as assign_status','tb_task_employee.remarks','tb_employee.employeeId','tb_employee.emp_first_name','tb_employee.emp_lastName','tb_task.title','tb_task.description','tb_task.attachment','tb_task.start_time','tb_task.end_time','tb_departments.department_name','tb_designations.designation_name','tb_branch.branch_name','users.name')
                    ->get();
                //dd($all_task);
            }
        }
        else if($request->search_type==2) {
            if ($_POST['dept_id'] == 'all') {
                 //dd('all dept');
                $all_task = DB::table('tb_task_employee')
                    ->WhereBetween('tb_task_employee.assign_date', [$start_date, $end_date])
                    ->Where('tb_task_employee.status', $status)
                    ->leftJoin('tb_employee', 'tb_task_employee.emp_id', '=', 'tb_employee.id')
                    ->leftJoin('tb_task', 'tb_task_employee.task_id', '=', 'tb_task.id')
                    ->leftJoin('users', 'tb_task_employee.created_by', '=', 'users.id')
                    ->leftJoin('tb_departments', 'tb_employee.emp_department_id', '=', 'tb_departments.id')
                    ->leftJoin('tb_designations', 'tb_employee.emp_designation_id', '=', 'tb_designations.id')
                    ->leftJoin('tb_branch', 'tb_employee.branch_id', '=', 'tb_branch.id')
                    ->select('tb_task_employee.assign_date', 'tb_task_employee.status as assign_status', 'tb_task_employee.remarks', 'tb_employee.employeeId', 'tb_employee.emp_first_name', 'tb_employee.emp_lastName', 'tb_task.title', 'tb_task.description', 'tb_task.attachment', 'tb_task.start_time', 'tb_task.end_time', 'tb_departments.department_name', 'tb_designations.designation_name', 'tb_branch.branch_name', 'users.name')
                    ->get();
                //dd($all_task);
            }else{
                 //dd('specic dept');
                $all_task=DB::table('tb_task_employee')
                    ->Where('tb_task_employee.emp_id',$employee)
                    ->Where('tb_employee.emp_department_id',$dept)
                    ->Where('tb_task_employee.status',$status)
                    ->WhereBetween('tb_task_employee.assign_date',[$start_date, $end_date])
                    ->leftJoin('tb_employee','tb_task_employee.emp_id','=','tb_employee.id')
                    ->leftJoin('tb_task','tb_task_employee.task_id','=','tb_task.id')
                    ->leftJoin('users','tb_task_employee.created_by','=','users.id')
                    ->leftJoin('tb_departments','tb_employee.emp_department_id','=','tb_departments.id')
                    ->leftJoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
                    ->leftJoin('tb_branch','tb_employee.branch_id','=','tb_branch.id')
                    ->select('tb_task_employee.assign_date','tb_task_employee.status as assign_status','tb_task_employee.remarks','tb_employee.employeeId','tb_employee.emp_first_name','tb_employee.emp_lastName','tb_task.title','tb_task.description','tb_task.attachment','tb_task.start_time','tb_task.end_time','tb_departments.department_name','tb_designations.designation_name','tb_branch.branch_name','users.name')
                    ->get();
                //dd($all_task);
            }
        }

        else if($request->search_type==3) {
            if ($_POST['desig_id'] == 'all') {
                //dd('all dept');
                $all_task = DB::table('tb_task_employee')
                    ->WhereBetween('tb_task_employee.assign_date', [$start_date, $end_date])
                    ->Where('tb_task_employee.status', $status)
                    ->leftJoin('tb_employee', 'tb_task_employee.emp_id', '=', 'tb_employee.id')
                    ->leftJoin('tb_task', 'tb_task_employee.task_id', '=', 'tb_task.id')
                    ->leftJoin('users', 'tb_task_employee.created_by', '=', 'users.id')
                    ->leftJoin('tb_departments', 'tb_employee.emp_department_id', '=', 'tb_departments.id')
                    ->leftJoin('tb_designations', 'tb_employee.emp_designation_id', '=', 'tb_designations.id')
                    ->leftJoin('tb_branch', 'tb_employee.branch_id', '=', 'tb_branch.id')
                    ->select('tb_task_employee.assign_date', 'tb_task_employee.status as assign_status', 'tb_task_employee.remarks', 'tb_employee.employeeId', 'tb_employee.emp_first_name', 'tb_employee.emp_lastName', 'tb_task.title', 'tb_task.description', 'tb_task.attachment', 'tb_task.start_time', 'tb_task.end_time', 'tb_departments.department_name', 'tb_designations.designation_name', 'tb_branch.branch_name', 'users.name')
                    ->get();
                //dd($all_task);
            }else{
                //dd('specic dept');
                $all_task=DB::table('tb_task_employee')
                    ->Where('tb_task_employee.emp_id',$employee)
                    ->Where('tb_employee.emp_designation_id',$desig)
                    ->Where('tb_task_employee.status',$status)
                    ->WhereBetween('tb_task_employee.assign_date',[$start_date, $end_date])
                    ->leftJoin('tb_employee','tb_task_employee.emp_id','=','tb_employee.id')
                    ->leftJoin('tb_task','tb_task_employee.task_id','=','tb_task.id')
                    ->leftJoin('users','tb_task_employee.created_by','=','users.id')
                    ->leftJoin('tb_departments','tb_employee.emp_department_id','=','tb_departments.id')
                    ->leftJoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
                    ->leftJoin('tb_branch','tb_employee.branch_id','=','tb_branch.id')
                    ->select('tb_task_employee.assign_date','tb_task_employee.status as assign_status','tb_task_employee.remarks','tb_employee.employeeId','tb_employee.emp_first_name','tb_employee.emp_lastName','tb_task.title','tb_task.description','tb_task.attachment','tb_task.start_time','tb_task.end_time','tb_departments.department_name','tb_designations.designation_name','tb_branch.branch_name',DB::raw("CONCAT(tb_employee.emp_first_name,' ',tb_employee.emp_lastName) as full_name"),'users.name')
                    ->get();
                //dd($all_task);
            }

        }

        return view('backend.task.employee_task_list_view',compact('all_task'));
    }


    public function employee_branch_wise($b_id){
        $employee=DB::table('tb_employee')
            ->where('tb_employee.branch_id','=',$b_id)
            ->select(DB::raw("CONCAT(tb_employee.emp_first_name,' ',tb_employee.emp_lastName) as full_name"),'tb_employee.id','tb_employee.employeeId')
            ->get();
        //dd($employee);
        return view('backend.ajax.get_employee_fullname',compact('employee'));
    }
    public function employee_department_wise($dept_id){
        $employee=DB::table('tb_employee')
            ->where('tb_employee.emp_account_status','=',1)
            ->where('tb_employee.emp_department_id','=',$dept_id)
            ->leftJoin('tb_task_employee','tb_employee.employeeId','=','tb_task_employee.id')
            ->select(DB::raw("CONCAT(tb_employee.emp_first_name,' ',tb_employee.emp_lastName) as full_name"),'tb_employee.id','tb_employee.employeeId')
            ->get();
        //dd($employee);
        return view('backend.ajax.get_employee_fullname',compact('employee'));
    }

    public function employee_designation_wise($desig_id){
        $employee=DB::table('tb_employee')
            ->where('tb_employee.emp_account_status','=',1)
            ->where('tb_employee.emp_designation_id','=',$desig_id)
            ->select(DB::raw("CONCAT(tb_employee.emp_first_name,' ',tb_employee.emp_lastName) as full_name"),'tb_employee.id','tb_employee.employeeId')
            ->get();
        //dd($employee);
        return view('backend.ajax.get_employee_fullname',compact('employee'));
    }
}
