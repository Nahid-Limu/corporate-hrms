<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use Auth;
use App\Repositories\Settings;
use PDF;

class SalaryReportController extends Controller{


    protected $employee;
    public function __construct()
    {
        // create object of settings class
        $this->employee = new Settings();
    }
       public function index(){
        return view('backend.report.salary.index');
    }
    public function salary_month(){
          $this->checkuserRole(['admin','super-admin','branch-manager'],'');
         if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin')){
             $branch=$this->employee->all_branch();
             return view('backend.report.salary.selary_report_month_wise',compact('branch'));
         }else{
                 $branch=$this->employee->emp_branch_name();
             return view('backend.report.salary.selary_report_month_wise',compact('branch'));
         }
         
    }

    public function salary_sheet(){
        $pdf=PDF::loadView('backend.report.salary.pdf.salary_sheet');
        $pdf->setPaper('A4', 'landscape');
        $name=time()."_"."salary_sheet.pdf";
        return $pdf->download($name);
    }
    public function month_wise_salary_report(Request $request){ 



         $year_month=Carbon::parse($request->salary_month)->toDateString();

        $emp_salary_details =  DB::table('tb_salary_process')
        ->leftJoin('tb_employee','tb_salary_process.emp_id','=','tb_employee.id')
        ->leftJoin('tb_salary_grade','tb_salary_process.grade_id','=','tb_salary_grade.id')
        ->leftJoin('tb_payroll_salary','tb_salary_process.emp_id','=','tb_payroll_salary.id')
        ->leftJoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
        ->where('salary_month_year', $year_month)
        ->where('tb_employee.branch_id', $request->branch_id)
        ->select('tb_salary_process.*','tb_employee.emp_first_name','tb_employee.emp_lastName','tb_employee.employeeId','tb_employee.emp_card_number','tb_designations.designation_name','tb_salary_grade.grade_name','tb_payroll_salary.total_salary as Gross_salary','tb_payroll_salary.provident_fund_amount')
        ->get();

        // dd($emp_salary_details);
            if($emp_salary_details){

                return view('backend.report.salary.salary_report',compact('emp_salary_details','year_month'));
            }else {
                return "nathing";
            }
    }

 

    public function salary_month_employee(){
          $this->checkuserRole(['admin','super-admin','branch-manager'],'');
        if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin')){
          $branch=$this->employee->all_branch();
          return view('backend.report.salary.salary_report_employee',compact('branch'));
        }else{
            $branch=$this->employee->emp_branch_name();
            return view('backend.report.salary.salary_report_employee',compact('branch'));
        }
    }

    public function pay_slip(Request $request){

               $year_month=Carbon::parse($request->salary_month)->toDateString();
            //    dd(  $request->all_employee_id);
               
         $emp_salary_pay_slip =  DB::table('tb_salary_process')
        ->leftJoin('tb_employee','tb_salary_process.emp_id','=','tb_employee.id')
        ->leftJoin('tb_salary_grade','tb_salary_process.grade_id','=','tb_salary_grade.id')
        ->leftJoin('tb_payroll_salary','tb_salary_process.emp_id','=','tb_payroll_salary.id')
        ->leftJoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
        ->leftJoin('tb_departments','tb_employee.emp_department_id','=','tb_departments.id')
        ->where('salary_month_year', $year_month)
        ->where('tb_salary_process.emp_id', $request->all_employee_id)
        ->select('tb_salary_process.*','tb_employee.emp_first_name','tb_employee.emp_lastName','tb_employee.employeeId','tb_employee.emp_card_number','tb_employee.emp_phone','tb_employee.emp_father_name','tb_designations.designation_name','tb_employee.emp_joining_date','tb_salary_grade.grade_name','tb_payroll_salary.total_salary as Gross_salary','tb_payroll_salary.provident_fund_amount','tb_departments.department_name')
        ->first();

        // dd( $emp_salary_pay_slip);
            if($emp_salary_pay_slip){

                return view('backend.report.salary.selary_report_employee_month_wise',compact('emp_salary_pay_slip','year_month'));
            }else {
                return 'nathing';
            }
    }


     public function branchDepartment($id){
      $designation=DB::table('tb_employee')->where('tb_employee.branch_id',$id)
      ->leftjoin('tb_departments','tb_employee.emp_department_id','=','tb_departments.id')
      ->select('tb_departments.department_name','tb_departments.id as department_id')
      ->groupBy('tb_employee.emp_department_id')
      ->get();
      return response()->json($designation);
    }



    public function departmentEmployee($id){
        if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin')){
            $designation=DB::table('tb_employee')->where('tb_employee.emp_department_id',$id)
            ->leftjoin('tb_payroll_salary','tb_employee.id','=','tb_payroll_salary.emp_id')
            ->select('tb_employee.id as emp_id','tb_employee.emp_first_name','tb_employee.emp_lastName')
            ->get();
           return response()->json($designation);
        }else{
             $designation=DB::table('tb_employee')->where('tb_employee.emp_department_id',$id)
            ->leftjoin('tb_payroll_salary','tb_employee.id','=','tb_payroll_salary.emp_id')
            ->select('tb_employee.id as emp_id','tb_employee.emp_first_name','tb_employee.emp_lastName')
            ->where('tb_employee.branch_id',$this->employee->branchname_loginemployee()->id)
            ->get();
           return response()->json($designation);
        }
        
    }

}
