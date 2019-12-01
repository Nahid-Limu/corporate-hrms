<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Settings;
use DB;

class LeaveReportController extends Controller
{
    protected $employee;
    public function __construct()
    {
        // create object of settings class
        $this->employee = new Settings();
    }

    //leave index view
    public function index(){
        return view('backend.report.leave.index');
    }

    //current month employee on leave report
    public function currentMonthLeave(){
          $this->checkuserRole(['admin','super-admin','branch-manager'],'');
        $company=$this->employee->companyInformation();
        $current_month_first=date('Y-m-01');
        $current_month_last=date('Y-m-t');
        $leave=DB::SELECT("SELECT SUM(actual_days) as total, abs(SUM(actual_days)-tb_leave_type.total_days) as availabe_leave, tb_employee.employeeId,tb_employee.emp_first_name,tb_employee.emp_lastName,tb_leave_type.leave_type,tb_leave_type.total_days FROM `tb_leave_application` LEFT JOIN tb_employee ON tb_leave_application.emp_id=tb_employee.id LEFT JOIN tb_leave_type ON tb_leave_application.leave_type_id=tb_leave_type.id WHERE tb_leave_application.status=1 AND (leave_ending_date>='$current_month_first' AND leave_ending_date<='$current_month_last' OR leave_starting_date >= '$current_month_first' AND leave_starting_date<='$current_month_last') GROUP BY leave_type_id,tb_leave_application.emp_id");
        return view('backend.report.leave.onleave_report',compact('leave','company'));
    }

    //date wise leave report view
    public function date_wise_leave_report(){
        return view('backend.report.leave.date_wise_leave');
    }

    //date wise leave report show
    public function date_wise_leave_report_show(Request $request){
       $company=$this->employee->companyInformation();
       $start_date=date('Y-m-d',strtotime($request->start_date));
       $end_date=date('Y-m-d',strtotime($request->end_date));
       $leave=DB::table('tb_leave_application')
       ->whereBetween('tb_leave_application.leave_starting_date',array($start_date,$end_date))
       ->whereBetween('tb_leave_application.leave_ending_date',array($start_date,$end_date))
       ->where('tb_leave_application.status',1)
       ->leftjoin('tb_employee','tb_leave_application.emp_id','=','tb_employee.id')
       ->leftjoin('tb_leave_type','tb_leave_application.leave_type_id','=','tb_leave_type.id')
       ->select('tb_employee.employeeId','tb_employee.emp_first_name','tb_employee.emp_lastName','tb_leave_type.leave_type','tb_leave_application.actual_days','tb_leave_application.leave_starting_date','tb_leave_application.leave_ending_date')
       ->get();
       return view('backend.report.leave.date_wise_leave_report_show',compact('leave','company'));
    }

    //date wise leave type report view
    public function date_wise_leave_report_type(){
        $leave_type=DB::table('tb_leave_type')->get();
        return view('backend.report.leave.date_wise_leave_type_report',compact('leave_type'));
    }

     //date wise leave type report show
     public function date_wise_leave_report_type_show(Request $request){
        $company=$this->employee->companyInformation();
        $start_date=date('Y-m-d',strtotime($request->start_date));
        $end_date=date('Y-m-d',strtotime($request->end_date));
        $leave=DB::table('tb_leave_application')
        ->whereBetween('tb_leave_application.leave_starting_date',array($start_date,$end_date))
        ->whereBetween('tb_leave_application.leave_ending_date',array($start_date,$end_date))
        ->where('tb_leave_application.status',1)
        ->where('tb_leave_application.leave_type_id',$request->leave_type_id)
        ->leftjoin('tb_employee','tb_leave_application.emp_id','=','tb_employee.id')
        ->leftjoin('tb_leave_type','tb_leave_application.leave_type_id','=','tb_leave_type.id')
        ->select('tb_employee.employeeId','tb_employee.emp_first_name','tb_employee.emp_lastName','tb_leave_type.leave_type','tb_leave_application.actual_days','tb_leave_application.leave_starting_date','tb_leave_application.leave_ending_date')
        ->get();
       return view('backend.report.leave.date_wise_leave_type_report_show',compact('leave','company'));
     }


}
