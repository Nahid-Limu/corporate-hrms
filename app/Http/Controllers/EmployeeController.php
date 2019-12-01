<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;
use Validator;
use App\Repositories\Settings;
use Session;
use Hash;
use Carbon\Carbon;
use PDF;

class EmployeeController extends Controller
{

    protected $settings;

    public function __construct()
    {
        // create object of settings class
        $this->settings = new Settings();
    }

    /**
     * Display all employee list with pagination.
     */
    public function employee_list(){

        if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin')){

        $employee_list = DB::table('tb_employee')
        ->leftjoin('tb_departments','tb_employee.emp_department_id','=','tb_departments.id')
        ->leftjoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
        ->leftjoin('tb_branch','tb_employee.branch_id','=','tb_branch.id')
        ->select('tb_employee.id','tb_employee.emp_first_name','tb_employee.emp_lastName','tb_employee.emp_account_status','tb_employee.emp_card_number','tb_departments.department_name','tb_designations.designation_name','tb_employee.employeeId','tb_branch.branch_name')
        ->orderBy('tb_employee.employeeId', 'desc')->get();
        if(request()->ajax())
        {
            $start=0;
            return datatables()->of($employee_list)
                ->addColumn('emp_first_name', function($row){
                    return $row->emp_first_name." ".$row->emp_lastName;
                })
                ->addColumn('action', function($data){
                    return '<a target="_blank" class="profile btn btn-blue btn-xs" title="View Profile" href="'.route('employee.profile', base64_encode($data->id)).'"><i class="fa fa-eye"></i></a>';
                })
              ->rawColumns(['action'])
              ->addIndexColumn()
                ->make(true);
        }
       return view('backend.employee.employee_list');
        }else{
        $branch_id=$this->settings->branchname_loginemployee();
        $employee_list = DB::table('tb_employee')
        ->leftjoin('tb_departments','tb_employee.emp_department_id','=','tb_departments.id')
        ->leftjoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
        ->leftjoin('tb_branch','tb_employee.branch_id','=','tb_branch.id')
        ->select('tb_employee.id','tb_employee.emp_first_name','tb_employee.emp_lastName','tb_employee.emp_account_status','tb_employee.emp_card_number','tb_departments.department_name','tb_designations.designation_name','tb_employee.employeeId','tb_branch.branch_name')
        ->orderBy('tb_employee.id', 'ASC')
        ->where('tb_employee.branch_id', $branch_id->id)
        ->get();
        if(request()->ajax())
        {
            $start=0;
            return datatables()->of($employee_list)
                ->addColumn('emp_first_name', function($row){
                    return $row->emp_first_name." ".$row->emp_lastName;
                })
                ->addColumn('action', function($data){
                    return '<a target="_blank" class="profile btn btn-blue btn-xs" title="View Profile" href="'.route('employee.profile', base64_encode($data->id)).'"><i class="fa fa-eye"></i></a>';
                    
                })
              ->rawColumns(['action'])
              ->addIndexColumn()
                ->make(true);
        }

       return view('backend.employee.employee_list');
        }

    }



    /**
     * Create Employee view.
     */
    public function create_employee(){
        if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin')){
            $branch=$this->settings->all_branch();
            $department=$this->settings->all_department();
            $designation=$this->settings->all_designation();
            $shift=$this->settings->all_shift();
        return view('backend.employee.create',compact('branch','department','designation','shift'));
        }else{
            $branch=$this->settings->branchname_loginemployee();
            $department=$this->settings->all_department();
            $designation=$this->settings->all_designation();
            $shift=$this->settings->all_shift();
            return view('backend.employee.create',compact('branch','department','designation','shift'));
        }

    }


    /**
     * Employee data store in database.
     */
    public function employee_store(Request $request){

        //Validate Form Request Data
        $validatedData = $request->validate([
            'employeeId' => 'required|unique:tb_employee',
            'first_name' => 'required',
            'last_name' => 'required',
            'branch' => 'required',
            'department' => 'required',
            'designation' => 'required',
            'gender' => 'required',
            'shift' => 'required',
            'emp_card_number' => 'unique:tb_employee',
            'marital_status' => 'required',
            'religion' => 'required',
            'email' => 'required|unique:users',
            'password' => ['required', 'string', 'min:6'],
            'date_of_birth' => 'required',
            'joining_date' => 'required',
            'current_address' => 'required',
            'permanent_address' => 'required',

        ]);

        //Store Employee Data After Validation
        $employee_create = DB::table('tb_employee')->insert([
            'employeeId'=>$request->employeeId,
            'emp_first_name'=>$request->first_name,
            'emp_lastName'=>$request->last_name,
            'branch_id'=>$request->branch,
            'emp_department_id'=>$request->department,
            'emp_designation_id'=>$request->designation,
            'emp_gender_id'=>$request->gender,
            'emp_shift_id'=>$request->shift,
            'emp_email'=>$request->email,
            'emp_dob'=>date('Y-m-d',strtotime($request->date_of_birth)),
            'emp_joining_date'=>date('Y-m-d',strtotime($request->joining_date)),
            'emp_religion'=>$request->religion,
            'emp_blood_group'=>$request->blood_group,
            'emp_card_number'=>$request->emp_card_number,
            'emp_ot_status'=>$request->emp_ot_status,
            'emp_parmanent_address'=>$request->permanent_address,
            'emp_current_address'=>$request->current_address,
            'emp_account_status'=>1,
            'created_at'=>Carbon::now()->toDateTimeString(),
            'updated_at'=>Carbon::now()->toDateTimeString()
        ]);


        $id=DB::getPdo()->lastInsertId();
        $userData=DB::table('users')->insert([
            'name' =>$request->first_name,
            'email' =>$request->email,
            'emp_branch_id'=>$request->branch,
            'password' =>Hash::make($request['password']),
            'emp_id' =>$id,
            'created_at'  =>Carbon::now()->toDateTimeString(),
            'updated_at'  =>Carbon::now()->toDateTimeString(),
        ]);

        $selectUser=DB::table('users')->where('emp_id',$id)->select('id')->first();

        $role_user=DB::table('role_user')->insert([
            'role_id' =>5,
            'user_id' =>$selectUser->id,
        ]);


        Session::flash('success','Employee Information has been successfully saved.');
        return redirect()->back();
    }

    /**
     * Employee data show from database.
     */
    public function employee_edit($id){
        $employee = DB::table('tb_employee')->where('id',$id)->first(['id','emp_first_name']);
        return response()->json($employee);
    }


    /**
     * Employee data update from database.
     */
    public function employee_update(Request $request){

        $employee_update = DB::table('tb_employee')->where('id',$request->emp_id)->update([
            'employeeId'=>$request->employeeId,
            'emp_first_name'=>$request->first_name,
            'emp_lastName'=>$request->last_name,
            'branch_id'=>$request->branch,
            'emp_department_id'=>$request->department,
            'emp_designation_id'=>$request->designation,
            'emp_gender_id'=>$request->gender,
            'emp_shift_id'=>$request->shift,
            'emp_father_name'=>$request->emp_father_name,
            'emp_mother_name'=>$request->emp_mother_name,
            'emp_email'=>$request->email,
            'emp_phone'=>$request->employeeId,
            'emp_dob'=>date('Y-m-d',strtotime($request->date_of_birth)),
            'emp_joining_date'=>date('Y-m-d',strtotime($request->joining_date)),
            'emp_probation_period'=>$request->emp_probation_period,
            'emp_religion'=>$request->religion,
            'emp_marital_status'=>$request->marital_status,
            'emp_blood_group'=>$request->blood_group,
            'emp_bank_account'=>$request->emp_bank_account,
            'emp_bank_info'=>$request->emp_bank_info,
            'emp_card_number'=>$request->emp_card_number,
            'emp_nid'=>$request->emp_nid,
            'emp_nationality'=>$request->emp_nationality,
            'emp_ot_status'=>$request->emp_ot_status,
            'emp_parmanent_address'=>$request->permanent_address,
            'emp_current_address'=>$request->current_address,
            'emp_emergency_phone'=>$request->emp_emergency_phone,
            'emp_emergency_address'=>$request->emp_emergency_address,
            'emp_account_status'=>$request->emp_account_status,
            'created_at'=>Carbon::now()->toDateTimeString(),
            'updated_at'=>Carbon::now()->toDateTimeString()
        ]);

        $userData=DB::table('users')->where('emp_id',$request->emp_id)->update([
            'name' =>$request->first_name,
            'email' =>$request->email,
            'emp_branch_id'=>$request->branch,
            'created_at'  =>Carbon::now()->toDateTimeString(),
            'updated_at'  =>Carbon::now()->toDateTimeString(),
        ]);

        Session::flash('success','Employee Information has been update successfully');
        return redirect()->back();

    }


    /**
     * Employee profile.
     */
    public function employee_profile($id){
      if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin')){
            $id = base64_decode($id);
        $branch_list2=$this->settings->branchname_loginemployee();
        $branch=$this->settings->all_branch();
        $department=$this->settings->all_department();
        $designation=$this->settings->all_designation();
        $shift=$this->settings->all_shift();
        $employee_profile = DB::table('tb_employee')
            ->leftjoin('tb_departments','tb_employee.emp_department_id','=','tb_departments.id')
            ->leftjoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
            ->leftjoin('tb_branch','tb_employee.branch_id','=','tb_branch.id')
            ->leftjoin('tb_shift','tb_employee.emp_shift_id','=','tb_shift.id')
            ->select('tb_employee.id as emp_id','tb_employee.*','tb_departments.department_name','tb_designations.designation_name','tb_branch.branch_name','tb_shift.shift_name','tb_shift.entry_time','tb_shift.exit_time')
            ->where('tb_employee.id',$id)
            ->first();
        $employee_education=DB::table('tb_employee_education_info')->where('emp_id',$id)->select('id as edu_id','emp_exam_title','emp_Institution_name','emp_result','emp_scale','emp_passing_year','emp_attachment')->orderBy('id','DESC')->get();
        $task_list=DB::table('tb_task_employee')
        ->where('tb_task_employee.emp_id',$id)
        ->whereYear('tb_task_employee.assign_date', '=', date('Y'))
        ->whereMonth('tb_task_employee.assign_date', '=', date('m'))
        ->leftjoin('tb_task','tb_task_employee.task_id','=','tb_task.id')
        ->select('tb_task.title','tb_task.start_time','tb_task.end_time','tb_task_employee.assign_date','tb_task_employee.status as task_assign_status')
        ->orderBy('tb_task_employee.id','DESC')
        ->get();

        $start=Carbon::now()->startOfMonth()->toDateString();
        $month= Carbon::now()->format('F');
        $present=DB::table('tb_attendance')->where('emp_id','=',$id)->whereBetween('attendance_date',[$start,Carbon::now()->toDateString()])->count();
        $now=Carbon::now()->toDateString();
        $leave=DB::select("select SUM(actual_days) as total_leave from `tb_leave_application` where `emp_id` = $id and `status` = 1 and (`leave_starting_date` between '$start' and '$now'  or `leave_ending_date` between '$start' and '$now') group by `emp_id`");
        if(isset($leave[0]->total_leave)){
            $leave_total=$leave[0]->total_leave;
        }
        else{
            $leave_total=0;
        }
        $total=$this->settings->dayCalculator($start,Carbon::now()->toDateString());
        $attendace = (object) [
            'month' => $month,
            'present' => $present,
            'leave' => $leave_total,
            'working_days'=>$total,
        ];

        $current_salary=DB::table('tb_payroll_salary')
        ->where('tb_payroll_salary.emp_id',$id)
        ->leftjoin('tb_employee','tb_payroll_salary.emp_id','=','tb_employee.id')
        ->leftjoin('tb_salary_grade','tb_payroll_salary.grade_id','=','tb_salary_grade.id')
        ->select('tb_payroll_salary.*','tb_salary_grade.grade_name')
        ->get();


        return view('backend.employee.employee_profile',compact('employee_profile','branch','department','designation','shift','employee_education','task_list','attendace','current_salary','branch_list2'));
      }else{

          $id = base64_decode($id);
          $branch_list2=$this->settings->branchname_loginemployee();
        $branch=$this->settings->all_branch();
        $department=$this->settings->all_department();
        $designation=$this->settings->all_designation();
        $shift=$this->settings->all_shift();
        $employee_profile = DB::table('tb_employee')
            ->leftjoin('tb_departments','tb_employee.emp_department_id','=','tb_departments.id')
            ->leftjoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
            ->leftjoin('tb_branch','tb_employee.branch_id','=','tb_branch.id')
            ->leftjoin('tb_shift','tb_employee.emp_shift_id','=','tb_shift.id')
            ->select('tb_employee.id as emp_id','tb_employee.*','tb_departments.department_name','tb_designations.designation_name','tb_branch.branch_name','tb_shift.shift_name','tb_shift.entry_time','tb_shift.exit_time')
            ->where('tb_employee.id',$id)
            ->first();
        $employee_education=DB::table('tb_employee_education_info')->where('emp_id',$id)->select('id as edu_id','emp_exam_title','emp_Institution_name','emp_result','emp_scale','emp_passing_year','emp_attachment')->orderBy('id','DESC')->get();
        $task_list=DB::table('tb_task_employee')
        ->where('tb_task_employee.emp_id',$id)
        ->whereYear('tb_task_employee.assign_date', '=', date('Y'))
        ->whereMonth('tb_task_employee.assign_date', '=', date('m'))
        ->leftjoin('tb_task','tb_task_employee.task_id','=','tb_task.id')
        ->select('tb_task.title','tb_task.start_time','tb_task.end_time','tb_task_employee.assign_date','tb_task_employee.status as task_assign_status')
        ->orderBy('tb_task_employee.id','DESC')
        ->get();

        $start=Carbon::now()->startOfMonth()->toDateString();
        $month= Carbon::now()->format('F');
        $present=DB::table('tb_attendance')->where('emp_id','=',$id)->whereBetween('attendance_date',[$start,Carbon::now()->toDateString()])->count();
        $now=Carbon::now()->toDateString();
        $leave=DB::select("select SUM(actual_days) as total_leave from `tb_leave_application` where `emp_id` = $id and `status` = 1 and (`leave_starting_date` between '$start' and '$now'  or `leave_ending_date` between '$start' and '$now') group by `emp_id`");
        if(isset($leave[0]->total_leave)){
            $leave_total=$leave[0]->total_leave;
        }
        else{
            $leave_total=0;
        }
        $total=$this->settings->dayCalculator($start,Carbon::now()->toDateString());
        $attendace = (object) [
            'month' => $month,
            'present' => $present,
            'leave' => $leave_total,
            'working_days'=>$total,
        ];

        $current_salary=DB::table('tb_payroll_salary')
        ->where('tb_payroll_salary.emp_id',$id)
        ->leftjoin('tb_employee','tb_payroll_salary.emp_id','=','tb_employee.id')
        ->leftjoin('tb_salary_grade','tb_payroll_salary.grade_id','=','tb_salary_grade.id')
        ->select('tb_payroll_salary.*','tb_salary_grade.grade_name')
        ->get();


        return view('backend.employee.employee_profile',compact('employee_profile','branch','department','designation','shift','employee_education','task_list','attendace','current_salary','branch_list2'));
      }
    }


    /**
     * Employee password update. 
     */
    public function employee_password(Request $request)
    {
        $updatePassword = DB::table('users')->where('emp_id',$request->emp_id)->update([
            'password' => Hash::make($request['password']),
            'created_at'=>Carbon::now()->toDateTimeString(),
            'updated_at'=>Carbon::now()->toDateTimeString()
        ]);

        Session::flash('success','Password has been update successfully');
        return redirect()->back();
    }

    /**
     * Employee image update.
     */
    public function employee_image(Request $request){

        $photoName = time().'.'.$request->emp_photo->getClientOriginalExtension();
        $request->emp_photo->move(('employee_image'), $photoName);
        $updateImage=DB::table('tb_employee')->where('id',$request->emp_id)->update([
           'emp_photo' =>$photoName
        ]);

        Session::flash('success','Image has been update successfully');
        return redirect()->back();
    }

    /**
     * Employee educational info store.
     */
    public function employee_education(Request $request){

        $photoName='';
        if ($request->hasFile('emp_attachment')) {
            $photoName = time().'.'.$request->emp_attachment->getClientOriginalExtension();
            $request->emp_attachment->move(('employee_education_attachment'), $photoName);
        }
        $insertEducation=DB::table('tb_employee_education_info')->insert([
            'emp_id' =>$request->emp_id,
            'emp_exam_title' =>$request->emp_exam_title,
            'emp_Institution_name' =>$request->emp_Institution_name,
            'emp_result' =>$request->emp_result,
            'emp_scale' =>$request->emp_scale,
            'emp_passing_year' =>$request->emp_passing_year,
            'emp_attachment' =>$photoName,
            'created_at'=>Carbon::now()->toDateTimeString(),
            'updated_at'=>Carbon::now()->toDateTimeString()
        ]);
        Session::flash('success','Educational Information has been save successfully');
        return redirect()->back();
    }

    /**
     * Employee educational info update.
     */
    public function employee_education_update(Request $request){
        $photoName='';
        if ($request->hasFile('emp_attachment')) {
            $photoName = time().'.'.$request->emp_attachment->getClientOriginalExtension();
            $request->emp_attachment->move(('employee_education_attachment'), $photoName);
        }
        $updateEducation=DB::table('tb_employee_education_info')->where('id',$request->edu_id)->update([
            'emp_exam_title' =>$request->emp_exam_title,
            'emp_Institution_name' =>$request->emp_Institution_name,
            'emp_result' =>$request->emp_result,
            'emp_scale' =>$request->emp_scale,
            'emp_passing_year' =>$request->emp_passing_year,
            'emp_attachment' =>$photoName,
            'created_at'=>Carbon::now()->toDateTimeString(),
            'updated_at'=>Carbon::now()->toDateTimeString()
        ]);
        Session::flash('success','Educational Information has been update successfully');
        return redirect()->back();
    }


    /**
     * Employee educational info delete.
     */
     public function employee_education_delete($id){
        $deleteEducation=DB::table('tb_employee_education_info')->where('id',$id)->delete();

        Session::flash('delete','Educational Information has been deleted successfully');
        return redirect()->back();
     }

    /**
     * Download id card.
     */
     public function download_id_card($id){
         $employee_data=DB::table('tb_employee')->where('id',$id)->first();
         $pdf = \PDF::loadView('backend.employee.download.id.card', compact('employee_data'));
         return $pdf->download('id_card.pdf');
     }

    /**
     * Download job application letter.
     */
     public function download_job_application_letter($id){

         $employee_data=DB::table('tb_employee')->where('id',$id)->first();
         $pdf = \PDF::loadView('backend.employee.download.job_application.letter', compact('employee_data'));
         return $pdf->download('job_application_letter.pdf');
     }


    /**
     * Download appointment letter.
     */
    public function download_appointment_letter($id){

        $employee_data=DB::table('tb_employee')->where('id',$id)->first();
        $pdf = \PDF::loadView('backend.employee.download.appointment.letter', compact('employee_data'));
        return $pdf->download('appointment_letter.pdf');
    }

    /**
     * Download resignation letter.
     */
    public function download_resignation_letter($id){

        $employee_data=DB::table('tb_employee')->where('id',$id)->first();
        $pdf = \PDF::loadView('backend.employee.download.resignation.letter', compact('employee_data'));
        return $pdf->download('resignation_letter.pdf');
    }


    /**
     * Get Employee.
     */
    public function get_employee($id){
        $employee =  DB::table('tb_employee')
        ->select(DB::raw("tb_employee.id, tb_employee.employeeId, CONCAT(tb_employee.emp_first_name,' ',tb_employee.emp_lastName) as name"))
        ->where('emp_account_status','=',1)
        ->where('branch_id','=',$id)
        ->get();

        return view('backend.ajax.get_employee',compact('employee'));
    }

    /**
     * Get Employee For Report
     */

    public function get_employee_for_report($id){
        $employee =  DB::table('tb_employee')
        ->select(DB::raw("tb_employee.id, tb_employee.employeeId, CONCAT(tb_employee.emp_first_name,' ',tb_employee.emp_lastName) as name"))
        ->where('emp_account_status','=',1)
        ->where('branch_id','=',$id)
        ->get();

        return view('backend.ajax.get_employee_for_report',compact('employee'));
    }


    /**
     * Employee Rating View.
     */
    public function employeeRating(){
       return view('backend.employee.rating.employee_rating');
    }


    /**
     *Login Employee profile view.
     */

     public function employeeProfileForEmployeePanel(){


        $branch_list2=$this->settings->branchname_loginemployee();
        $branch=$this->settings->employeeBranch();
        $department=$this->settings->employeeDepartment();
        $designation=$this->settings->employeeDesignation();
        $shift=$this->settings->employeeShift();
        $training_list=DB::table('tb_assign_training')->where('tb_assign_training.emp_id',auth()->user()->emp_id)
        ->leftjoin('tb_training','tb_assign_training.training_id','=','tb_training.id')
        ->leftjoin('users','tb_assign_training.assigned_by','=','users.id')
        ->select('tb_training.*','tb_assign_training.status as assign_status','users.name as assigned_by')
        ->orderBY('tb_assign_training.id','DESC')
        ->groupBy('tb_assign_training.training_id')
        ->get();

        $employee_profile = DB::table('tb_employee')
            ->leftjoin('tb_departments','tb_employee.emp_department_id','=','tb_departments.id')
            ->leftjoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
            ->leftjoin('tb_branch','tb_employee.branch_id','=','tb_branch.id')
            ->leftjoin('tb_shift','tb_employee.emp_shift_id','=','tb_shift.id')
            ->select('tb_employee.id as emp_id','tb_employee.*','tb_departments.department_name','tb_designations.designation_name','tb_branch.branch_name','tb_shift.shift_name','tb_shift.shift_name','tb_shift.entry_time','tb_shift.exit_time')
            ->where('tb_employee.id',auth()->user()->emp_id)
            ->first();

        $employee_education=DB::table('tb_employee_education_info')->where('emp_id',auth()->user()->emp_id)->select('id as edu_id','emp_exam_title','emp_Institution_name','emp_result','emp_scale','emp_passing_year','emp_attachment')->orderBy('id','DESC')->get();

        $task_list=DB::table('tb_task_employee')
        ->where('tb_task_employee.emp_id',auth()->user()->emp_id)
        ->whereYear('tb_task_employee.assign_date', '=', date('Y'))
        ->whereMonth('tb_task_employee.assign_date', '=', date('m'))
        ->leftjoin('tb_task','tb_task_employee.task_id','=','tb_task.id')
        ->select('tb_task.title','tb_task.start_time','tb_task.end_time','tb_task_employee.assign_date','tb_task_employee.status as task_assign_status')
        ->orderBy('tb_task_employee.id','DESC')
        ->get();


        $start=Carbon::now()->startOfMonth()->toDateString();
        $month= Carbon::now()->format('F');
        $present=DB::table('tb_attendance')->where('emp_id','=',auth()->user()->emp_id)->whereBetween('attendance_date',[$start,Carbon::now()->toDateString()])->count();

        $id=auth()->user()->emp_id;

        $now=Carbon::now()->toDateString();
        $leave=DB::select("select SUM(actual_days) as total_leave from `tb_leave_application` where `emp_id` = $id and `status` = 1 and (`leave_starting_date` between '$start' and '$now'  or `leave_ending_date` between '$start' and '$now') group by `emp_id`");
        if(isset($leave[0]->total_leave)){
            $leave_total=$leave[0]->total_leave;
        }
        else{
            $leave_total=0;
        }
        $total=$this->settings->dayCalculator($start,Carbon::now()->toDateString());
        $attendace = (object) [
            'month' => $month,
            'present' => $present,
            'leave' => $leave_total,
            'working_days'=>$total,
        ];

        $current_salary=DB::table('tb_payroll_salary')
        ->where('tb_payroll_salary.emp_id',auth()->user()->emp_id)
        ->leftjoin('tb_employee','tb_payroll_salary.emp_id','=','tb_employee.id')
        ->leftjoin('tb_salary_grade','tb_payroll_salary.grade_id','=','tb_salary_grade.id')
        ->select('tb_payroll_salary.*','tb_salary_grade.grade_name')
        ->get();
        return view('backend.employee.employee_profile_for_employee_panel',compact('employee_profile','branch','department','designation','shift','employee_education','task_list','attendace','current_salary','training_list','branch_list2'));
     }


    /**
     *Login Employee task list.
     */
     public function employeeTaskList(){
        $task_list=DB::table('tb_task_employee')->where('tb_task_employee.emp_id',auth()->user()->emp_id)
        ->leftjoin('tb_task','tb_task_employee.task_id','=','tb_task.id')
        ->leftjoin('users','tb_task_employee.created_by','=','users.id')
        ->select('tb_task.*','tb_task_employee.assign_date','tb_task_employee.status as assign_status','users.name as assigned_by')
        ->orderBY('tb_task_employee.id','DESC')
        ->get();

        if(request()->ajax())
        {
            return datatables()->of($task_list)
                    ->addColumn('action', function($data){
                        $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit edit_view btn btn-blue btn-xs"  data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>';
                        $button .= '&nbsp;&nbsp;';

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
                    ->editColumn('assign_date', function ($task_list) {
                        return date('F-d-Y', strtotime($task_list->assign_date));
                    })
                    ->rawColumns(['action','attachment'])
                    ->addIndexColumn()
                    ->make(true);
        }
       return view('backend.employee.employee_panel.assigned_task_list');

     }

    /**
     *  Employee task edit.
     */
//    public function employeeTaskedit($id){
//
//        $edit_task_data=DB::table('tb_task_employee')
//            ->where('tb_task_employee.id','=',$id)
//
//            ->first();
//
//        return response()->json($edit_task_data);
//
//    }

    public function employeeTaskViewEdit($id){
        $edit_view_data=DB::table('tb_task_employee')
            ->where('tb_task_employee.id','=',$id)
            ->leftJoin('tb_task','tb_task_employee.task_id','=','tb_task.id')
            ->first(['tb_task_employee.*','tb_task.title']);

        return response()->json($edit_view_data);
    }


    /**
     *update view task employee
     */

    public function employeeTaskViewupdate(Request $request){

        $rules=array(
            'status'=>'required',
            'remarks'=>'required',
        );

        $error=Validator::make($request->all(),$rules);
        if($error->fails()){
            return Response()->json(['errors'=>$error->errors()->all()]);
        }
        $update_view_data=DB::table('tb_task_employee')->where('id',$request->id)->update([
            'status'=>$request->status,
            'remarks'=>$request->remarks,
        ]);
        if($update_view_data){
            return response()->json(["success"=>"Successfully Updated!"]);
        }else{
            return response()->json(["failed"=>"Update Nothing.!"]);
        }

    }



    /**
     *Login Employee training list.
     */
    public function employeeTrainingList(){
        $training_list=DB::table('tb_assign_training')->where('tb_assign_training.emp_id',auth()->user()->emp_id)
        ->leftjoin('tb_training','tb_assign_training.training_id','=','tb_training.id')
        ->leftjoin('users','tb_assign_training.assigned_by','=','users.id')
        ->select('tb_training.*','tb_assign_training.status as assign_status','users.name as assigned_by')
        ->orderBY('tb_assign_training.id','DESC')
        ->groupBy('tb_assign_training.training_id')
        ->get();

        if(request()->ajax())
        {
            return datatables()->of($training_list)
                    ->addColumn('action', function($data){
                        $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-blue btn-xs" data-toggle="modal" data-target="#editTask" data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>';
                        $button .= '&nbsp;&nbsp;';

                        return $button;
                    })
                    ->addColumn('training_attachment', function($data){
                        if ($data->training_attachment!= null) {
                            $asset = asset('training_attachment').'/'.$data->training_attachment;
                            $button = '<a href="'.$asset.'" target="_blank"><span style="color:green">Open</span><i class="fa fa-download pull-right" aria-hidden="true"></i></a>';
                            $button .= '&nbsp;&nbsp;';
                        return $button;
                        }else {
                            return '<span style="color:red">No Attachment</span>';
                        }

                    })
                    ->editColumn('training_start', function ($training_list) {
                        return date('F-d-Y', strtotime($training_list->training_start));
                    })
                    ->editColumn('training_end', function ($training_list) {
                        return date('F-d-Y', strtotime($training_list->training_end));
                    })
                    ->editColumn('training_month', function ($training_list) {
                        return date('F-Y', strtotime($training_list->training_month));
                    })
                    ->rawColumns(['action','training_attachment'])
                    ->addIndexColumn()
                    ->make(true);
        }
       return view('backend.employee.employee_panel.assigned_training_list');
    }


    /**
     *Login Employee file shareing list.
     */
     public function employeeFilesheringList(){
         $employee=DB::table('tb_employee')->where('id',auth()->user()->emp_id)->first();
         $share_list=DB::table('tb_file_sharing')
         ->where('tb_file_sharing.emp_id',$employee->id)
         ->orwhere('tb_file_sharing.branch_id',$employee->branch_id)
         ->orwhere('tb_file_sharing.department_id',$employee->emp_department_id)
         ->orwhere('tb_file_sharing.designation_id',$employee->emp_designation_id)
         ->orwhere('tb_file_sharing.shared_by',auth()->user()->id)
         ->leftjoin('users','tb_file_sharing.shared_by','=','users.id')
         ->leftjoin('tb_employee','tb_file_sharing.emp_id','=','tb_employee.id')
         ->leftjoin('tb_branch','tb_file_sharing.branch_id','=','tb_branch.id')
         ->leftjoin('tb_departments','tb_file_sharing.department_id','=','tb_departments.id')
         ->leftjoin('tb_designations','tb_file_sharing.designation_id','=','tb_designations.id')
         ->select('tb_file_sharing.attachment','tb_file_sharing.shared_date','tb_file_sharing.shared_by','users.name as shared_by','tb_file_sharing.shared_by as share_id','tb_file_sharing.referenceId','tb_branch.branch_name','tb_departments.department_name','tb_designations.designation_name','tb_employee.emp_first_name','tb_file_sharing.emp_id as em_id')
         ->orderBy('tb_file_sharing.id','DESC')
         ->get();
         if(request()->ajax())
         {
             return datatables()->of($share_list)
                     ->addColumn('attachment', function($data){
                         if ($data->attachment!= null) {
                             $asset = asset('share_file').'/'.$data->attachment;
                             $button = '<a href="'.$asset.'" target="_blank"><span style="color:green">Open</span><i class="fa fa-download pull-right" aria-hidden="true"></i></a>';
                             $button .= '&nbsp;&nbsp;';
                         return $button;
                         }else {
                             return '<span style="color:red">No Attachment</span>';
                         }

                     })
                     ->editColumn('shared_date', function ($share_list) {
                         return date('F-d-Y', strtotime($share_list->shared_date));
                     })
                     ->editColumn('file_share_to', function ($share_list) {

                        if($share_list->em_id==auth()->user()->emp_id){
                            $share_user='You';
                            return  $share_user;
                        }

                         $share_user=$share_list->branch_name.$share_list->department_name.$share_list->designation_name.$share_list->emp_first_name;
                         return  $share_user;
                    })
                     ->rawColumns(['action','attachment'])
                     ->addIndexColumn()
                     ->make(true);
         }
         return view('backend.employee.employee_panel.file_share_list');
     }


     /**
     *Login Employee meeting list.
     */
     public function employeemeetingList(){
        $meeting=DB::table('tb_meeting_employee')->where('emp_id',auth()->user()->emp_id)
        ->leftjoin('tb_meetings','tb_meeting_employee.meeting_id','=','tb_meetings.id')
        ->select('tb_meetings.*')
        ->orderBy('tb_meeting_employee.id','DESC')
        ->get();

        if(request()->ajax())
          {
           return datatables()->of($meeting)
                   ->editColumn('start_time', function ($meeting) {
                       return date('H:i:a', strtotime($meeting->start_time));
                   })
                   ->editColumn('end_time', function ($meeting) {
                    return date('H:i:a', strtotime($meeting->end_time));
                   })
                   ->editColumn('meeting_date', function ($meeting) {
                    return date('F-d-Y', strtotime($meeting->meeting_date));
                   })
                   ->addIndexColumn()
                   ->make(true);
           }
           return view('backend.employee.employee_panel.meeting_list');

     }

     /**
     *Login Employee leave request.
     */
       public function employeeLeaveRequest(){
         return view('backend.employee.leave.leave_request');
       }


      /**   My profile  */

      public function myProfile(){
          $id=auth()->id();

          $user=DB::table('users')
              ->leftJoin('tb_employee','users.emp_id','=','tb_employee.id')
              ->leftjoin('tb_departments','tb_employee.emp_department_id','=','tb_departments.id')
              ->leftjoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
              ->leftjoin('tb_branch','tb_employee.branch_id','=','tb_branch.id')
              ->leftjoin('tb_shift','tb_employee.emp_shift_id','=','tb_shift.id')
              ->where('users.id','=',$id)
              ->select('users.name','users.email','tb_employee.*','tb_departments.department_name','tb_designations.designation_name','tb_branch.branch_name','tb_shift.shift_name','tb_shift.shift_name','tb_shift.entry_time','tb_shift.exit_time')
              ->first();
              // dd($user);
          return view('backend.employee.my_profile',compact('user'));
      }

      public function employee_update_password(Request $request){
          $this->validate($request,[
              'previous_password'=>'required',
              'new_password'=>'required|min:6',
              'confirm_password'=>'required|same:new_password',
          ]);
          if (Hash::check($request->previous_password, auth()->user()->password)){
              DB::table('users')->where('id',auth()->id())->update([
                  'password'=>bcrypt($request->new_password)
              ]);
              Session::flash('success',"Password Update Successful");

          }
          else{
              Session::flash('error',"The old password is not matched.");

          }
          return redirect()->back();

      }

      public function search_employee(){
          return view('backend.employee.search_employee');
      }

      public function autocomplete_employee(Request $request){
          $settings=new Settings();
          $branch_id=$settings->get_login_branch_id();
          $query = $request->get('query','');
          $employee=DB::table('tb_employee')
              ->where('emp_first_name','like',"%".$query."%")
              ->orWhere('emp_lastName','like',"%".$query."%")
              ->orWhere('employeeId','like',"%".$query."%")
              ->limit(10)->get();
          $data=[];
          foreach ($employee as $p){
              if($p->branch_id==$branch_id) {
                  $data[] = $p->emp_first_name . " " . $p->emp_lastName . "  #" . $p->employeeId;
              }

          }
          return $data;

      }

      public function short_profile(Request $request){
          $data=explode('#',"$request->emp_name_id");
          if(isset($data[1])){
              $employee=DB::table('tb_employee')
                  ->leftJoin('tb_departments','tb_employee.emp_department_id','=','tb_departments.id')
                  ->leftJoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
                  ->where('employeeId','=',$data[1])
                  ->select(DB::raw("concat(tb_employee.emp_first_name,' ',tb_employee.emp_lastName) as full_name"),
                      'tb_employee.emp_shift_id','tb_employee.employeeId','tb_employee.emp_email',
                      'tb_departments.department_name','tb_designations.designation_name','tb_employee.emp_phone')
                  ->first();
              if(isset($employee)){
                  return view('backend.employee.short_profile',compact('employee'));
              }
              else{
                  return "<div style='text-align: center; color: red'>Employee Not Found</div>";
              }
          }
          else{
              return "<div style='text-align: center; color: red'>Something went wrong. Try again later.</div>";

          }
//          return $data[1];
      }

}
