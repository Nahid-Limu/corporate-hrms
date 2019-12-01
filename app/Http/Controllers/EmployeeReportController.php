<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Repositories\Settings;
use Session;
use Carbon\Carbon;
use PDF;

class EmployeeReportController extends Controller
{
    protected $employee;
    public function __construct()
    {
        // create object of settings class
        $this->employee = new Settings();
    }

	/**
     * employee report view page.
     */
    public function index(){
       $this->checkuserRole(['admin','super-admin','branch-manager'],'');
      return view('backend.report.employee.index');
    }


    /**
     * employee search view page.
     */
    public function searchEmployee(){
       $this->checkuserRole(['admin','super-admin','branch-manager'],'');

      if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin')){
      $employee=$this->employee->all_employee();
      return view('backend.report.employee.search_employee_profile',compact('employee'));
      }else{
         $employee=$this->employee->branchall_employee();
         return view('backend.report.employee.search_employee_profile',compact('employee'));
      }
    }


     /**
     * employee search profile view page.
     */

     public function SearchProfileEmployee(){
        $id=$_GET['id'];
        $branch=$this->employee->all_branch();
        $department=$this->employee->all_department();
        $designation=$this->employee->all_designation();
        $shift=$this->employee->all_shift();
        $employee_profile = DB::table('tb_employee')
            ->leftjoin('tb_departments','tb_employee.emp_department_id','=','tb_departments.id')
            ->leftjoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
            ->leftjoin('tb_branch','tb_employee.branch_id','=','tb_branch.id')
            ->leftjoin('tb_shift','tb_employee.emp_shift_id','=','tb_shift.id')
            ->select('tb_employee.id as emp_id','tb_employee.*','tb_departments.department_name','tb_designations.designation_name','tb_branch.branch_name','tb_shift.shift_name')
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
        $total=$this->employee->dayCalculator($start,Carbon::now()->toDateString());
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

        return view('backend.report.employee.search_employee_profile_show',compact('employee_profile','branch','department','designation','shift','employee_education','task_list','attendace','current_salary'));
     }



     /**
     * employee list view page.
     */
    public function employeeList(){
      return view('backend.report.employee.employee_list');
    }


    /**
     * Branch employee list view page.
     */
    public function branch_wise_employee(){
       $this->checkuserRole(['admin','super-admin','branch-manager'],'');
       $branch=$this->employee->all_branch();
      return view('backend.report.employee.branch_wise_employee',compact('branch'));
    }



   /**
     * Department employee list view page.
     */
    public function department_wise_employee(){

          $this->checkuserRole(['admin','super-admin','branch-manager'],'');
      // if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin')){
       $department=$this->employee->all_department();
      return view('backend.report.employee.department_wise_employee',compact('department'));
      // }else{

      // }
    }


   /**
     * Designation employee list view page.
     */
   public function designation_wise_employee(){
          $this->checkuserRole(['admin','super-admin','branch-manager'],'');

      $designation=$this->employee->all_designation();
      return view('backend.report.employee.designation_wise_employee',compact('designation'));
    }

    /**
     * Branch employee list ajax view.
     */
    public function branch_wise_employee_show(Request $request){
        $employee=DB::table('tb_employee')->where('branch_id',$request->branch_id)
        ->leftjoin('tb_departments','tb_employee.emp_department_id','=','tb_departments.id')
        ->leftjoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
        ->select('tb_employee.id','emp_first_name','emp_lastName','employeeId','tb_departments.department_name','tb_designations.designation_name')
        ->get();
        $company=$this->employee->companyInformation();
        $branch=DB::table('tb_branch')->where('id',$request->branch_id)->first();
        if($request->preview){
            return view('backend.report.employee.branch.branch_employee_show',compact('employee'));
           }else{
            $pdf = \PDF::loadView('backend.report.employee.branch.pdf.branch_employee_show', compact('employee','company','branch'));
            return $pdf->download('branch_employee_list.pdf');
           }
    }


     /**
     * Department employee list ajax view.
     */
    public function department_wise_employee_show(Request $request){


      if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin')){
      
        $employee=DB::table('tb_employee')->where('emp_department_id',$request->department_id)
        ->leftjoin('tb_departments','tb_employee.emp_department_id','=','tb_departments.id')
        ->leftjoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
        ->select('tb_employee.id','emp_first_name','emp_lastName','employeeId','tb_departments.department_name','tb_designations.designation_name')
        ->get();
        $company=$this->employee->companyInformation();
        $department=DB::table('tb_departments')->where('id',$request->department_id)->first();
        if($request->preview){
            return view('backend.report.employee.department.department_employee_show',compact('employee'));
           }else{
            $pdf = \PDF::loadView('backend.report.employee.department.pdf.department_employee_show', compact('employee','company','department'));
            return $pdf->download('department_employee_list.pdf');
           }
        }
        else{
          

          $employee=DB::table('tb_employee')->where('emp_department_id',$request->department_id)
        ->leftjoin('tb_departments','tb_employee.emp_department_id','=','tb_departments.id')
        ->leftjoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
        ->select('tb_employee.id','emp_first_name','emp_lastName','employeeId','tb_departments.department_name','tb_designations.designation_name')
        ->where('tb_employee.branch_id',$this->employee->branchname_loginemployee()->id)
        ->get();
        $company=$this->employee->companyInformation();
        $department=DB::table('tb_departments')->where('id',$request->department_id)->first();
        if($request->preview){
            return view('backend.report.employee.department.department_employee_show',compact('employee'));
           }else{
            $pdf = \PDF::loadView('backend.report.employee.department.pdf.department_employee_show', compact('employee','company','department'));
            return $pdf->download('department_employee_list.pdf');
           }

          }   


          
    }

     /**
     * Designation employee list ajax view.
     */
    public function designation_wise_employee_show(Request $request){

      if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin')){
         $employee=DB::table('tb_employee')->where('emp_designation_id',$request->designation_id)
        ->leftjoin('tb_departments','tb_employee.emp_department_id','=','tb_departments.id')
        ->leftjoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
        ->select('tb_employee.id','emp_first_name','emp_lastName','employeeId','tb_departments.department_name','tb_designations.designation_name')
        ->get();
        $company=$this->employee->companyInformation();
        $designation=DB::table('tb_designations')->where('id',$request->designation_id)->first();
        if($request->preview){
            return view('backend.report.employee.designation.designation_employee_show',compact('employee'));
           }else{
            $pdf = \PDF::loadView('backend.report.employee.designation.pdf.designation_employee_show',compact('employee','company','designation'));
            return $pdf->download('designation_employee_list.pdf');
           }
      }else{
         $employee=DB::table('tb_employee')->where('emp_designation_id',$request->designation_id)
        ->leftjoin('tb_departments','tb_employee.emp_department_id','=','tb_departments.id')
        ->leftjoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
        ->select('tb_employee.id','emp_first_name','emp_lastName','employeeId','tb_departments.department_name','tb_designations.designation_name')
         ->where('tb_employee.branch_id',$this->employee->branchname_loginemployee()->id)
        ->get();
        $company=$this->employee->companyInformation();
        $designation=DB::table('tb_designations')->where('id',$request->designation_id)->first();
        if($request->preview){
            return view('backend.report.employee.designation.designation_employee_show',compact('employee'));
           }else{
            $pdf = \PDF::loadView('backend.report.employee.designation.pdf.designation_employee_show',compact('employee','company','designation'));
            return $pdf->download('designation_employee_list.pdf');
           }
      }
       
    }

}
