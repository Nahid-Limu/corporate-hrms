<?php

namespace App\Http\Controllers;

use App\Exports\AttendanceException;
use App\Exports\DailyAbsentReport;
use App\Exports\DailyAttendanceReport;
use App\Exports\IndividualAttendanceReport;
use App\Exports\LateReport;
use App\Exports\OvertimeReport;
use App\Exports\PresentReport;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use App\Repositories\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use vakata\database\Exception;

class AttendanceReportController extends Controller
{

    protected $setting;
    public function __construct()
    {
         $this->setting = new Settings();
    }

    public function index(){
        $this->checkuserRole(['admin','super-admin','branch-manager'],'');
        return view('backend.report.attendance.index');
    }
    public function attendance_report(){
          $this->checkuserRole(['admin','super-admin','branch-manager'],'');

        if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin')){
             $branch=DB::table('tb_branch')->get();
          $branch_list2=$this->setting->branchname_loginemployee();
        $department=DB::table('tb_departments')->get(['id','department_name']);
        $designation=DB::table('tb_designations')->get(['id','designation_name']);
        return view('backend.report.attendance.attendance_report',compact('branch',
            'department','designation','branch_list2'));

        }else{
          $branch_list2=$this->setting->branchname_loginemployee();

                $branch=DB::table('tb_branch')->get();
            $department=DB::table('tb_departments')->get(['id','department_name']);
            $designation=DB::table('tb_designations')->get(['id','designation_name']);
            return view('backend.report.attendance.attendance_report',compact('branch',
                'department','designation','branch_list2'));

        }

    }

    public function attendance_report_data(Request $request){
        if(request()->ajax())
        {
            $queryAbsent=DB::table('tb_employee')
                ->leftJoin('tb_departments', 'tb_employee.emp_department_id', '=', 'tb_departments.id')
                ->leftJoin('tb_designations', 'tb_employee.emp_designation_id', '=', 'tb_designations.id')
                ->leftJoin('tb_shift', 'tb_employee.emp_shift_id', '=', 'tb_shift.id')
                ->leftJoin('tb_branch', 'tb_employee.branch_id', '=', 'tb_branch.id');
            $queryLeave=DB::table('tb_employee')
                ->leftJoin('tb_departments', 'tb_employee.emp_department_id', '=', 'tb_departments.id')
                ->leftJoin('tb_designations', 'tb_employee.emp_designation_id', '=', 'tb_designations.id')
                ->leftJoin('tb_shift', 'tb_employee.emp_shift_id', '=', 'tb_shift.id')
                ->leftJoin('tb_branch', 'tb_employee.branch_id', '=', 'tb_branch.id')
                ->join('tb_leave_application', 'tb_employee.id', '=', 'tb_leave_application.emp_id')
                ->where("tb_leave_application.leave_starting_date",'<=',$request->date)
                ->where("tb_leave_application.leave_ending_date",'>=',$request->date);


            $query=DB::table('tb_employee')
            ->leftJoin('tb_departments','tb_employee.emp_department_id','=','tb_departments.id')
            ->leftJoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
            ->leftJoin('tb_shift','tb_employee.emp_shift_id','=','tb_shift.id')
            ->leftJoin('tb_branch','tb_employee.branch_id','=','tb_branch.id')
            ->join('tb_attendance','tb_employee.id','=','tb_attendance.emp_id')
            ->where('tb_attendance.attendance_date','=',$request->date);

            if($request->branch_id!=0){
                $query=$query->where('tb_employee.branch_id','=',$request->branch_id);
                $queryAbsent=$queryAbsent->where('tb_employee.branch_id','=',$request->branch_id);
                $queryLeave=$queryLeave->where('tb_employee.branch_id','=',$request->branch_id);
            }
            if($request->emp_id!=0){
                $query=$query->where('tb_employee.id','=',$request->emp_id);
                $queryAbsent=$queryAbsent->where('tb_employee.id','=',$request->emp_id);
                $queryLeave=$queryLeave->where('tb_employee.id','=',$request->emp_id);
            }
            if($request->department_id!=0){
                $query=$query->where('tb_employee.emp_department_id','=',$request->department_id);
                $queryAbsent=$queryAbsent->where('tb_employee.emp_department_id','=',$request->department_id);
                $queryLeave=$queryLeave->where('tb_employee.emp_department_id','=',$request->department_id);
            }
            if($request->designation_id!=0){
                $query=$query->where('tb_employee.emp_designation_id','=',$request->designation_id);
                $queryAbsent=$queryAbsent->where('tb_employee.emp_designation_id','=',$request->designation_id);
                $queryLeave=$queryLeave->where('tb_employee.emp_designation_id','=',$request->designation_id);
            }
            if($request->gender_id!=0){
                $query=$query->where('tb_employee.emp_gender_id','=',$request->gender_id);
                $queryAbsent=$queryAbsent->where('tb_employee.emp_gender_id','=',$request->gender_id);
                $queryLeave=$queryLeave->where('tb_employee.emp_gender_id','=',$request->gender_id);
            }
            $queryAbsent=$queryAbsent->where('tb_employee.emp_account_status','=',1);
            $queryLeave=$queryLeave->where('tb_employee.emp_account_status','=',1);
            $queryLeave=$queryLeave->where('tb_leave_application.status','=',1);
            $query=$query->where('emp_account_status','=',1);
//            $leave_data=$queryLeave->whereBetween($request->date,)
            $present_id=$query->get('tb_employee.id');
            $leave_id=$queryLeave->get('tb_employee.id');
//            return $leave_id;


            foreach ($present_id as $p){
                $p_id[]=$p->id;

            }
            foreach ($leave_id as $l){
                $p_id[]=$l->id;

            }
//            return $p_id;
            $attendance_data=$query->select(DB::raw("CONCAT(tb_employee.emp_first_name,' ',tb_employee.emp_lastName) as full_name"),
                'tb_attendance.attendance_date','tb_attendance.in_time',
                'tb_shift.entry_time as shift_entry_time','tb_shift.exit_time as shift_exit_time',
                'tb_attendance.out_time','tb_employee.employeeId','tb_branch.branch_name',
                'tb_departments.department_name')->get();
            $leave_data=$queryLeave->select(DB::raw("CONCAT(tb_employee.emp_first_name,' ',tb_employee.emp_lastName) as full_name"),
                'tb_shift.entry_time as shift_entry_time', 'tb_shift.exit_time as shift_exit_time',
                'tb_employee.employeeId','tb_branch.branch_name', 'tb_departments.department_name',
                DB::raw("'leave' as in_time,'leave' as out_time"))
                ->get();
//            return $leave_data;
            if(isset($p_id)) {
                $absent =$queryAbsent
                    ->whereNotIn('tb_employee.id', $p_id)
                    ->select(DB::raw("CONCAT(tb_employee.emp_first_name,' ',tb_employee.emp_lastName) as full_name"),
                        'tb_shift.entry_time as shift_entry_time', 'tb_shift.exit_time as shift_exit_time',
                        'tb_employee.employeeId', 'tb_branch.branch_name', 'tb_departments.department_name',
                        DB::raw("null as in_time,null as out_time"))
                    ->get();
            }
            else{
                $absent = $queryAbsent
                    ->select(DB::raw("CONCAT(tb_employee.emp_first_name,' ',tb_employee.emp_lastName) as full_name"),
                        'tb_shift.entry_time as shift_entry_time', 'tb_shift.exit_time as shift_exit_time',
                        'tb_employee.employeeId', 'tb_branch.branch_name', 'tb_departments.department_name',
                        DB::raw("null as in_time,null as out_time"))
                    ->get();

            }
            $total_data=$attendance_data->merge($absent);
            $all_data=$total_data->merge($leave_data);
            return datatables()->of($all_data,$request)
                ->addIndexColumn()
                ->make(true);

        }
        return view('backend.report.attendance.attendance_report_data',compact('request'));
    }

    public function attendance_report_export(Request $request){
//            return $request->all();
        $queryAbsent=DB::table('tb_employee')
            ->leftJoin('tb_departments', 'tb_employee.emp_department_id', '=', 'tb_departments.id')
            ->leftJoin('tb_designations', 'tb_employee.emp_designation_id', '=', 'tb_designations.id')
            ->leftJoin('tb_shift', 'tb_employee.emp_shift_id', '=', 'tb_shift.id')
            ->leftJoin('tb_branch', 'tb_employee.branch_id', '=', 'tb_branch.id');
        $queryLeave=DB::table('tb_employee')
            ->leftJoin('tb_departments', 'tb_employee.emp_department_id', '=', 'tb_departments.id')
            ->leftJoin('tb_designations', 'tb_employee.emp_designation_id', '=', 'tb_designations.id')
            ->leftJoin('tb_shift', 'tb_employee.emp_shift_id', '=', 'tb_shift.id')
            ->leftJoin('tb_branch', 'tb_employee.branch_id', '=', 'tb_branch.id')
            ->join('tb_leave_application', 'tb_employee.id', '=', 'tb_leave_application.emp_id')
            ->where("tb_leave_application.leave_starting_date",'<=',$request->date)
            ->where("tb_leave_application.leave_ending_date",'>=',$request->date);


        $query=DB::table('tb_employee')
            ->leftJoin('tb_departments','tb_employee.emp_department_id','=','tb_departments.id')
            ->leftJoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
            ->leftJoin('tb_shift','tb_employee.emp_shift_id','=','tb_shift.id')
            ->leftJoin('tb_branch','tb_employee.branch_id','=','tb_branch.id')
            ->join('tb_attendance','tb_employee.id','=','tb_attendance.emp_id')
            ->where('tb_attendance.attendance_date','=',$request->date);

        if($request->branch_id!=0){
            $query=$query->where('tb_employee.branch_id','=',$request->branch_id);
            $queryAbsent=$queryAbsent->where('tb_employee.branch_id','=',$request->branch_id);
            $queryLeave=$queryLeave->where('tb_employee.branch_id','=',$request->branch_id);
        }
        if($request->emp_id!=0){
            $query=$query->where('tb_employee.id','=',$request->emp_id);
            $queryAbsent=$queryAbsent->where('tb_employee.id','=',$request->emp_id);
            $queryLeave=$queryLeave->where('tb_employee.id','=',$request->emp_id);
        }
        if($request->department_id!=0){
            $query=$query->where('tb_employee.emp_department_id','=',$request->department_id);
            $queryAbsent=$queryAbsent->where('tb_employee.emp_department_id','=',$request->department_id);
            $queryLeave=$queryLeave->where('tb_employee.emp_department_id','=',$request->department_id);
        }
        if($request->designation_id!=0){
            $query=$query->where('tb_employee.emp_designation_id','=',$request->designation_id);
            $queryAbsent=$queryAbsent->where('tb_employee.emp_designation_id','=',$request->designation_id);
            $queryLeave=$queryLeave->where('tb_employee.emp_designation_id','=',$request->designation_id);
        }
        if($request->gender_id!=0){
            $query=$query->where('tb_employee.emp_gender_id','=',$request->gender_id);
            $queryAbsent=$queryAbsent->where('tb_employee.emp_gender_id','=',$request->gender_id);
            $queryLeave=$queryLeave->where('tb_employee.emp_gender_id','=',$request->gender_id);
        }
        $queryAbsent=$queryAbsent->where('tb_employee.emp_account_status','=',1);
        $queryLeave=$queryLeave->where('tb_employee.emp_account_status','=',1);
        $queryLeave=$queryLeave->where('tb_leave_application.status','=',1);
        $query=$query->where('emp_account_status','=',1);
//            $leave_data=$queryLeave->whereBetween($request->date,)
        $present_id=$query->get('tb_employee.id');
        $leave_id=$queryLeave->get('tb_employee.id');
//            return $leave_id;


        foreach ($present_id as $p){
            $p_id[]=$p->id;

        }
        foreach ($leave_id as $l){
            $p_id[]=$l->id;

        }
//            return $p_id;
        $attendance_data=$query->select(DB::raw("CONCAT(tb_employee.emp_first_name,' ',tb_employee.emp_lastName) as full_name"),
            'tb_attendance.attendance_date','tb_attendance.in_time',
            'tb_shift.entry_time as shift_entry_time','tb_shift.exit_time as shift_exit_time',
            'tb_attendance.out_time','tb_employee.employeeId','tb_branch.branch_name',
            'tb_departments.department_name')->get();
        $leave_data=$queryLeave->select(DB::raw("CONCAT(tb_employee.emp_first_name,' ',tb_employee.emp_lastName) as full_name"),
            'tb_shift.entry_time as shift_entry_time', 'tb_shift.exit_time as shift_exit_time',
            'tb_employee.employeeId','tb_branch.branch_name', 'tb_departments.department_name',
            DB::raw("'leave' as in_time,'leave' as out_time"))
            ->get();
//            return $leave_data;
        if(isset($p_id)) {
            $absent =$queryAbsent
                ->whereNotIn('tb_employee.id', $p_id)
                ->select(DB::raw("CONCAT(tb_employee.emp_first_name,' ',tb_employee.emp_lastName) as full_name"),
                    'tb_shift.entry_time as shift_entry_time', 'tb_shift.exit_time as shift_exit_time',
                    'tb_employee.employeeId', 'tb_branch.branch_name', 'tb_departments.department_name',
                    DB::raw("null as in_time,null as out_time"))
                ->get();
        }
        else{
            $absent = $queryAbsent
                ->select(DB::raw("CONCAT(tb_employee.emp_first_name,' ',tb_employee.emp_lastName) as full_name"),
                    'tb_shift.entry_time as shift_entry_time', 'tb_shift.exit_time as shift_exit_time',
                    'tb_employee.employeeId', 'tb_branch.branch_name', 'tb_departments.department_name',
                    DB::raw("null as in_time,null as out_time"))
                ->take(500)
                ->get();

        }
        $total_data=$attendance_data->merge($absent);
        $all_data=$total_data->merge($leave_data);
        $company = DB::table('tb_company_information')->first();

        if($request->submit==='pdf') {
            if (count($all_data) < 400) {

                $pdf = PDF::loadView('backend.report.attendance.pdf.attendance_report_pdf', compact('all_data', 'company', 'request'));
                $name = time() . "_" . "daily_attendance_report.pdf";

                return $pdf->download($name);
            }
            else{
                return view('backend.report.attendance.pdf.attendance_report_pdf', compact('all_data', 'company', 'request'));
            }

        }
        elseif ($request->submit==='excel'){
            $name=time()."_"."DailyAttendanceReport.xlsx";
            // return Excel::download(new DailyAttendanceReport($all_data,$request,$company), $name);
            return (new DailyAttendanceReport($all_data,$request,$company))->download("$name", \Maatwebsite\Excel\Excel::XLSX);

        }
        elseif ($request->submit==='csv'){
            $name=time()."_"."DailyAttendanceReport.csv";
            // return Excel::download(new DailyAttendanceReport($all_data,$request,$company), $name);
            return (new DailyAttendanceReport($all_data,$request,$company))->download("$name", \Maatwebsite\Excel\Excel::CSV, ['Content-Type' => 'text/csv']);

        }
        else{
            return 0;
        }



    }

    public function present_report(){
          $this->checkuserRole(['admin','super-admin','branch-manager'],'');

        if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin')){
            $branch=DB::table('tb_branch')->get();
             $branch_list2=$this->setting->branchname_loginemployee();
        $department=DB::table('tb_departments')->get(['id','department_name']);
        $designation=DB::table('tb_designations')->get(['id','designation_name']);
        return view('backend.report.attendance.present_report',compact('branch',
            'department','designation','branch_list2'));
        }else{
            $branch=DB::table('tb_branch')->get();
             $branch_list2=$this->setting->branchname_loginemployee();
        $department=DB::table('tb_departments')->get(['id','department_name']);
        $designation=DB::table('tb_designations')->get(['id','designation_name']);
        return view('backend.report.attendance.present_report',compact('branch',
            'department','designation','branch_list2'));
        }


    }

    public function present_report_data(Request $request){
        if(request()->ajax()){
            $query=DB::table('tb_employee')
                ->leftJoin('tb_departments','tb_employee.emp_department_id','=','tb_departments.id')
                ->leftJoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
                ->leftJoin('tb_shift','tb_employee.emp_shift_id','=','tb_shift.id')
                ->leftJoin('tb_branch','tb_employee.branch_id','=','tb_branch.id')
                ->join('tb_attendance','tb_employee.id','=','tb_attendance.emp_id')
                ->whereBetween('tb_attendance.attendance_date',[$request->date,$request->end_date]);

            if($request->branch_id!=0){
                $query=$query->where('tb_employee.branch_id','=',$request->branch_id);
            }
            if($request->emp_id!=0){
                $query=$query->where('tb_employee.id','=',$request->emp_id);
            }
            if($request->department_id!=0){
                $query=$query->where('tb_employee.emp_department_id','=',$request->department_id);
            }
            if($request->designation_id!=0){
                $query=$query->where('tb_employee.emp_designation_id','=',$request->designation_id);
            }
            if($request->gender_id!=0){
                $query=$query->where('tb_employee.emp_gender_id','=',$request->gender_id);
            }

            $query=$query->where('emp_account_status','=',1);

            $attendance_data=$query->select(DB::raw("CONCAT(tb_employee.emp_first_name,' ',tb_employee.emp_lastName) as full_name"),
                'tb_attendance.attendance_date','tb_attendance.in_time',
                'tb_shift.entry_time as shift_entry_time','tb_shift.exit_time as shift_exit_time',
                'tb_attendance.out_time','tb_employee.employeeId','tb_branch.branch_name',
                'tb_departments.department_name')->get();
//            return $attendance_data;
            return datatables()->of($attendance_data,$request)
                ->addIndexColumn()
                ->make(true);

        }
        return view('backend.report.attendance.present_report_data',compact('request'));
    }

    public function present_report_export(Request $request){
        $query=DB::table('tb_employee')
            ->leftJoin('tb_departments','tb_employee.emp_department_id','=','tb_departments.id')
            ->leftJoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
            ->leftJoin('tb_shift','tb_employee.emp_shift_id','=','tb_shift.id')
            ->leftJoin('tb_branch','tb_employee.branch_id','=','tb_branch.id')
            ->join('tb_attendance','tb_employee.id','=','tb_attendance.emp_id')
            ->whereBetween('tb_attendance.attendance_date',[$request->date,$request->end_date]);

        if($request->branch_id!=0){
            $query=$query->where('tb_employee.branch_id','=',$request->branch_id);
        }
        if($request->emp_id!=0){
            $query=$query->where('tb_employee.id','=',$request->emp_id);
        }
        if($request->department_id!=0){
            $query=$query->where('tb_employee.emp_department_id','=',$request->department_id);
        }
        if($request->designation_id!=0){
            $query=$query->where('tb_employee.emp_designation_id','=',$request->designation_id);
        }
        if($request->gender_id!=0){
            $query=$query->where('tb_employee.emp_gender_id','=',$request->gender_id);
        }

        $query=$query->where('emp_account_status','=',1);

        $attendance_data=$query->select(DB::raw("CONCAT(tb_employee.emp_first_name,' ',tb_employee.emp_lastName) as full_name"),
            'tb_attendance.attendance_date','tb_attendance.in_time',
            'tb_shift.entry_time as shift_entry_time','tb_shift.exit_time as shift_exit_time',
            'tb_attendance.out_time','tb_employee.employeeId','tb_branch.branch_name',
            'tb_departments.department_name')->get();
//        return $attendance_data;

        $company = DB::table('tb_company_information')->first();

        if($request->submit==='pdf') {
            if (count($attendance_data) < 400) {

                $pdf = PDF::loadView('backend.report.attendance.pdf.present_report_pdf', compact('attendance_data', 'company', 'request'));
                $name = time() . "_" . "present_report.pdf";

                return $pdf->download($name);
            }
            else{
                return view('backend.report.attendance.pdf.present_report_pdf', compact('attendance_data', 'company', 'request'));
            }

        }
        elseif ($request->submit==='excel'){
            $name=time()."_"."DailyAttendanceReport.xlsx";
            // return Excel::download(new DailyAttendanceReport($all_data,$request,$company), $name);
            return (new DailyAttendanceReport($attendance_data,$request,$company))->download("$name", \Maatwebsite\Excel\Excel::XLSX);

        }
        elseif ($request->submit==='csv'){
            $name=time()."_"."DailyAttendanceReport.csv";
            // return Excel::download(new DailyAttendanceReport($all_data,$request,$company), $name);
            return (new DailyAttendanceReport($attendance_data,$request,$company))->download("$name", \Maatwebsite\Excel\Excel::CSV, ['Content-Type' => 'text/csv']);

        }
        else{
            return 0;
        }

    }

    public function late_report(){

          $this->checkuserRole(['admin','super-admin','branch-manager'],'');

        if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin')) {
            $branch=DB::table('tb_branch')->get();
             $branch_list2=$this->setting->branchname_loginemployee();
        $department=DB::table('tb_departments')->get(['id','department_name']);
        $designation=DB::table('tb_designations')->get(['id','designation_name']);
        return view('backend.report.attendance.late_report',compact('branch',
            'department','designation','branch_list2'));
        }else{
            $branch=DB::table('tb_branch')->get();
             $branch_list2=$this->setting->branchname_loginemployee();

        $department=DB::table('tb_departments')->get(['id','department_name']);
        $designation=DB::table('tb_designations')->get(['id','designation_name']);
        return view('backend.report.attendance.late_report',compact('branch',
            'department','designation','branch_list2'));
        }


    }

    public function late_report_data(Request $request){
        if(request()->ajax()){
            $query=DB::table('tb_employee')
                ->leftJoin('tb_departments','tb_employee.emp_department_id','=','tb_departments.id')
                ->leftJoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
                ->leftJoin('tb_shift','tb_employee.emp_shift_id','=','tb_shift.id')
                ->leftJoin('tb_branch','tb_employee.branch_id','=','tb_branch.id')
                ->join('tb_attendance','tb_employee.id','=','tb_attendance.emp_id')
                ->whereBetween('tb_attendance.attendance_date',[$request->date,$request->end_date]);

            if($request->branch_id!=0){
                $query=$query->where('tb_employee.branch_id','=',$request->branch_id);
            }
            if($request->emp_id!=0){
                $query=$query->where('tb_employee.id','=',$request->emp_id);
            }
            if($request->department_id!=0){
                $query=$query->where('tb_employee.emp_department_id','=',$request->department_id);
            }
            if($request->designation_id!=0){
                $query=$query->where('tb_employee.emp_designation_id','=',$request->designation_id);
            }
            if($request->gender_id!=0){
                $query=$query->where('tb_employee.emp_gender_id','=',$request->gender_id);
            }

            $query=$query->where('emp_account_status','=',1);
            $query=$query->where('tb_attendance.in_time','>',DB::raw("tb_shift.entry_time"));

            $attendance_data=$query->select(DB::raw("CONCAT(tb_employee.emp_first_name,' ',tb_employee.emp_lastName) as full_name"),
                'tb_attendance.attendance_date','tb_attendance.in_time',
                'tb_shift.entry_time as shift_entry_time','tb_shift.exit_time as shift_exit_time',
                'tb_attendance.out_time','tb_employee.employeeId','tb_branch.branch_name',
                'tb_departments.department_name')->get();
            return datatables()->of($attendance_data,$request)
                ->addIndexColumn()
                ->make(true);

        }
        return view('backend.report.attendance.late_report_data',compact('request'));

    }

    public function late_report_export(Request $request){
        $query=DB::table('tb_employee')
            ->leftJoin('tb_departments','tb_employee.emp_department_id','=','tb_departments.id')
            ->leftJoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
            ->leftJoin('tb_shift','tb_employee.emp_shift_id','=','tb_shift.id')
            ->leftJoin('tb_branch','tb_employee.branch_id','=','tb_branch.id')
            ->join('tb_attendance','tb_employee.id','=','tb_attendance.emp_id')
            ->whereBetween('tb_attendance.attendance_date',[$request->date,$request->end_date]);

        if($request->branch_id!=0){
            $query=$query->where('tb_employee.branch_id','=',$request->branch_id);
        }
        if($request->emp_id!=0){
            $query=$query->where('tb_employee.id','=',$request->emp_id);
        }
        if($request->department_id!=0){
            $query=$query->where('tb_employee.emp_department_id','=',$request->department_id);
        }
        if($request->designation_id!=0){
            $query=$query->where('tb_employee.emp_designation_id','=',$request->designation_id);
        }
        if($request->gender_id!=0){
            $query=$query->where('tb_employee.emp_gender_id','=',$request->gender_id);
        }

        $query=$query->where('emp_account_status','=',1);
        $query=$query->where('tb_attendance.in_time','>',DB::raw("tb_shift.entry_time"));

        $attendance_data=$query->select(DB::raw("CONCAT(tb_employee.emp_first_name,' ',tb_employee.emp_lastName) as full_name"),
            'tb_attendance.attendance_date','tb_attendance.in_time',
            'tb_shift.entry_time as shift_entry_time','tb_shift.exit_time as shift_exit_time',
            'tb_attendance.out_time','tb_employee.employeeId','tb_branch.branch_name',
            'tb_departments.department_name')->get();

        $company = DB::table('tb_company_information')->first();

        if($request->submit==='pdf') {
            if (count($attendance_data) < 400) {

                $pdf = PDF::loadView('backend.report.attendance.pdf.late_report_pdf', compact('attendance_data', 'company', 'request'));
                $name = time() . "_" . "late_report.pdf";
                return $pdf->download($name);
            }
            else{
                return view('backend.report.attendance.pdf.late_report_pdf', compact('attendance_data', 'company', 'request'));
            }

        }
        elseif ($request->submit==='excel'){
            $name=time()."_"."LateReport.xlsx";
            return (new LateReport($attendance_data,$request,$company))->download("$name", \Maatwebsite\Excel\Excel::XLSX);
        }

        elseif ($request->submit==='csv'){
            $name=time()."_"."LateReport.csv";
            return (new LateReport($attendance_data,$request,$company))->download("$name", \Maatwebsite\Excel\Excel::CSV, ['Content-Type' => 'text/csv']);

        }
        else{
            return 0;
        }

    }

    public function daily_absent_report(){
          $this->checkuserRole(['admin','super-admin','branch-manager'],'');

        if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin')){
            $branch=DB::table('tb_branch')->get();
            $branch_list2=$this->setting->branchname_loginemployee();
            $department=DB::table('tb_departments')->get(['id','department_name']);
            $designation=DB::table('tb_designations')->get(['id','designation_name']);
            return view('backend.report.attendance.absent_report',compact('branch',
                'department','designation','branch_list2'));
        }else{
             $branch=DB::table('tb_branch')->get();
            $branch_list2=$this->setting->branchname_loginemployee();
            $department=DB::table('tb_departments')->get(['id','department_name']);
            $designation=DB::table('tb_designations')->get(['id','designation_name']);
            return view('backend.report.attendance.absent_report',compact('branch',
                'department','designation','branch_list2'));
        }


    }

    public function daily_absent_report_data(Request $request){
//        return $request->all();
        if(request()->ajax())
        {
            $queryAbsent=DB::table('tb_employee')
                ->leftJoin('tb_departments', 'tb_employee.emp_department_id', '=', 'tb_departments.id')
                ->leftJoin('tb_designations', 'tb_employee.emp_designation_id', '=', 'tb_designations.id')
                ->leftJoin('tb_branch', 'tb_employee.branch_id', '=', 'tb_branch.id');
            $queryLeave=DB::table('tb_employee')
                ->leftJoin('tb_departments', 'tb_employee.emp_department_id', '=', 'tb_departments.id')
                ->leftJoin('tb_designations', 'tb_employee.emp_designation_id', '=', 'tb_designations.id')
                ->leftJoin('tb_shift', 'tb_employee.emp_shift_id', '=', 'tb_shift.id')
                ->leftJoin('tb_branch', 'tb_employee.branch_id', '=', 'tb_branch.id')
                ->join('tb_leave_application', 'tb_employee.id', '=', 'tb_leave_application.emp_id')
                ->where("tb_leave_application.leave_starting_date",'<=',$request->date)
                ->where("tb_leave_application.leave_ending_date",'>=',$request->date);


            $query=DB::table('tb_employee')
                ->leftJoin('tb_departments','tb_employee.emp_department_id','=','tb_departments.id')
                ->leftJoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
                ->leftJoin('tb_shift','tb_employee.emp_shift_id','=','tb_shift.id')
                ->leftJoin('tb_branch','tb_employee.branch_id','=','tb_branch.id')
                ->join('tb_attendance','tb_employee.id','=','tb_attendance.emp_id')
                ->where('tb_attendance.attendance_date','=',$request->date);

            if($request->branch_id!=0){
                $queryAbsent=$queryAbsent->where('tb_employee.branch_id','=',$request->branch_id);
            }
            if($request->emp_id!=0){
                $queryAbsent=$queryAbsent->where('tb_employee.id','=',$request->emp_id);
            }
            if($request->department_id!=0){
                $queryAbsent=$queryAbsent->where('tb_employee.emp_department_id','=',$request->department_id);
            }
            if($request->designation_id!=0){
                $queryAbsent=$queryAbsent->where('tb_employee.emp_designation_id','=',$request->designation_id);
            }
            if($request->gender_id!=0){
                $queryAbsent=$queryAbsent->where('tb_employee.emp_gender_id','=',$request->gender_id);
            }
            $queryAbsent=$queryAbsent->where('tb_employee.emp_account_status','=',1);
            $queryLeave=$queryLeave->where('tb_employee.emp_account_status','=',1);
            $queryLeave=$queryLeave->where('tb_leave_application.status','=',1);
            $query=$query->where('emp_account_status','=',1);
            $present_id=$query->get('tb_employee.id');
            $leave_id=$queryLeave->get('tb_employee.id');


            foreach ($present_id as $p){
                $p_id[]=$p->id;

            }
            foreach ($leave_id as $l){
                $p_id[]=$l->id;

            }

            if(isset($p_id)) {
                $absent =$queryAbsent
                    ->whereNotIn('tb_employee.id', $p_id)
                    ->select(DB::raw("CONCAT(tb_employee.emp_first_name,' ',tb_employee.emp_lastName) as full_name"),
                        'tb_employee.employeeId', 'tb_branch.branch_name', 'tb_departments.department_name',
                        DB::raw("null as in_time,null as out_time"))
                    ->get();
            }
            else{
                $absent = $queryAbsent
                    ->select(DB::raw("CONCAT(tb_employee.emp_first_name,' ',tb_employee.emp_lastName) as full_name"),
                        'tb_employee.employeeId', 'tb_branch.branch_name', 'tb_departments.department_name',
                        DB::raw("null as in_time,null as out_time"))
                    ->get();

            }

            return datatables()->of($absent,$request)
                ->addIndexColumn()
                ->make(true);

        }
        return view('backend.report.attendance.absent_report_data',compact('request'));
    }

    public function daily_absent_report_export(Request $request){

        $queryAbsent=DB::table('tb_employee')
            ->leftJoin('tb_departments', 'tb_employee.emp_department_id', '=', 'tb_departments.id')
            ->leftJoin('tb_designations', 'tb_employee.emp_designation_id', '=', 'tb_designations.id')
            ->leftJoin('tb_branch', 'tb_employee.branch_id', '=', 'tb_branch.id');
        $queryLeave=DB::table('tb_employee')
            ->leftJoin('tb_departments', 'tb_employee.emp_department_id', '=', 'tb_departments.id')
            ->leftJoin('tb_designations', 'tb_employee.emp_designation_id', '=', 'tb_designations.id')
            ->leftJoin('tb_shift', 'tb_employee.emp_shift_id', '=', 'tb_shift.id')
            ->leftJoin('tb_branch', 'tb_employee.branch_id', '=', 'tb_branch.id')
            ->join('tb_leave_application', 'tb_employee.id', '=', 'tb_leave_application.emp_id')
            ->where("tb_leave_application.leave_starting_date",'<=',$request->date)
            ->where("tb_leave_application.leave_ending_date",'>=',$request->date);


        $query=DB::table('tb_employee')
            ->leftJoin('tb_departments','tb_employee.emp_department_id','=','tb_departments.id')
            ->leftJoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
            ->leftJoin('tb_shift','tb_employee.emp_shift_id','=','tb_shift.id')
            ->leftJoin('tb_branch','tb_employee.branch_id','=','tb_branch.id')
            ->join('tb_attendance','tb_employee.id','=','tb_attendance.emp_id')
            ->where('tb_attendance.attendance_date','=',$request->date);

        if($request->branch_id!=0){
            $queryAbsent=$queryAbsent->where('tb_employee.branch_id','=',$request->branch_id);
        }
        if($request->emp_id!=0){
            $queryAbsent=$queryAbsent->where('tb_employee.id','=',$request->emp_id);
        }
        if($request->department_id!=0){
            $queryAbsent=$queryAbsent->where('tb_employee.emp_department_id','=',$request->department_id);
        }
        if($request->designation_id!=0){
            $queryAbsent=$queryAbsent->where('tb_employee.emp_designation_id','=',$request->designation_id);
        }
        if($request->gender_id!=0){
            $queryAbsent=$queryAbsent->where('tb_employee.emp_gender_id','=',$request->gender_id);
        }
        $queryAbsent=$queryAbsent->where('tb_employee.emp_account_status','=',1);
        $queryLeave=$queryLeave->where('tb_employee.emp_account_status','=',1);
        $queryLeave=$queryLeave->where('tb_leave_application.status','=',1);
        $query=$query->where('emp_account_status','=',1);
        $present_id=$query->get('tb_employee.id');
        $leave_id=$queryLeave->get('tb_employee.id');


        foreach ($present_id as $p){
            $p_id[]=$p->id;

        }
        foreach ($leave_id as $l){
            $p_id[]=$l->id;

        }

        if(isset($p_id)) {
            $absent =$queryAbsent
                ->whereNotIn('tb_employee.id', $p_id)
                ->select(DB::raw("CONCAT(tb_employee.emp_first_name,' ',tb_employee.emp_lastName) as full_name"),
                    'tb_employee.employeeId', 'tb_branch.branch_name', 'tb_departments.department_name',
                    DB::raw("null as in_time,null as out_time"))
                ->get();
        }
        else{
            $absent = $queryAbsent
                ->select(DB::raw("CONCAT(tb_employee.emp_first_name,' ',tb_employee.emp_lastName) as full_name"),
                    'tb_employee.employeeId', 'tb_branch.branch_name', 'tb_departments.department_name',
                    DB::raw("null as in_time,null as out_time"))
                ->get();

        }

        $company = DB::table('tb_company_information')->first();

        if($request->submit==='pdf') {
            if (count($absent) < 400) {

                $pdf = PDF::loadView('backend.report.attendance.pdf.daily_absent_report_pdf', compact('absent', 'company', 'request'));
                $name = time() . "_" . "daily_absent_report.pdf";

                return $pdf->download($name);
            }
            else{
                return view('backend.report.attendance.pdf.daily_absent_report_pdf', compact('absent', 'company', 'request'));
            }

        }
        elseif ($request->submit==='excel'){
            $name=time()."_"."DailyAbsentReport.xlsx";
            // return Excel::download(new DailyAttendanceReport($all_data,$request,$company), $name);
            return (new DailyAbsentReport($absent,$request,$company))->download("$name", \Maatwebsite\Excel\Excel::XLSX);

        }
        elseif ($request->submit==='csv'){
            $name=time()."_"."DailyAbsentReport.csv";
            // return Excel::download(new DailyAttendanceReport($all_data,$request,$company), $name);
            return (new DailyAbsentReport($absent,$request,$company))->download("$name", \Maatwebsite\Excel\Excel::CSV, ['Content-Type' => 'text/csv']);

        }
        else{
            return 0;
        }

    }



    public function individual_attendance_report(){
          $this->checkuserRole(['admin','super-admin','branch-manager','employee'],'');

        if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin')){
            $branch_list2=$this->setting->branchname_loginemployee();
            $branch=DB::table('tb_branch')->get();
        $department=DB::table('tb_departments')->get(['id','department_name']);
        $designation=DB::table('tb_designations')->get(['id','designation_name']);
        return view('backend.report.attendance.individual_attendance_report',compact('branch',
            'department','designation','branch_list2'));

        }else{
            $branch_list2=$this->setting->branchname_loginemployee();
            $branch=DB::table('tb_branch')->get();
        $department=DB::table('tb_departments')->get(['id','department_name']);
        $designation=DB::table('tb_designations')->get(['id','designation_name']);
        return view('backend.report.attendance.individual_attendance_report',compact('branch',
            'department','designation','branch_list2'));
        }

    }

    public function individual_attendance_report_data(Request $request){
          $this->checkuserRole(['admin','super-admin','branch-manager','employee'],'');
        $employee=DB::table('tb_employee')
            ->leftJoin('tb_branch','tb_employee.branch_id','=','tb_branch.id')
            ->leftJoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
            ->where('tb_employee.id','=',$request->emp_id)
            ->select(DB::raw("CONCAT(tb_employee.emp_first_name,' ',tb_employee.emp_lastName) as full_name"),
                'tb_employee.employeeId','tb_branch.branch_name','tb_designations.designation_name')
            ->first();
        $start_date = Carbon::parse($request->date);
        $end_date = Carbon::parse($request->end_date);
        $diff = $start_date->diffInDays($end_date);


        return view('backend.report.attendance.individual_attendance_report_data',compact('employee','request','diff'));

    }

    public function individual_attendance_report_export(Request $request){
        $employee=DB::table('tb_employee')
            ->leftJoin('tb_branch','tb_employee.branch_id','=','tb_branch.id')
            ->leftJoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
            ->where('tb_employee.id','=',$request->emp_id)
            ->select(DB::raw("CONCAT(tb_employee.emp_first_name,' ',tb_employee.emp_lastName) as full_name"),
                'tb_employee.employeeId','tb_branch.branch_name','tb_designations.designation_name')
            ->first();
        $company = DB::table('tb_company_information')->first();
        $start_date = Carbon::parse($request->date);
        $end_date = Carbon::parse($request->end_date);
        $diff = $start_date->diffInDays($end_date);

        if($request->submit==='pdf') {
            if ($diff <= 90) {

                $pdf = PDF::loadView('backend.report.attendance.pdf.individual_attendance_report_pdf', compact('employee', 'company', 'request'));
                $name = time() . "_" . "individual_attendance_report.pdf";

                return $pdf->download($name);
            }
            else{
                return view('backend.report.attendance.pdf.individual_attendance_report_pdf', compact('employee', 'company', 'request'));
            }

        }
        elseif ($request->submit==='excel'){
            $name=time()."_"."IndividualAttendance.xlsx";
            // return Excel::download(new DailyAttendanceReport($all_data,$request,$company), $name);
            return (new IndividualAttendanceReport($employee,$request,$company))->download("$name", \Maatwebsite\Excel\Excel::XLSX);

        }
        elseif ($request->submit==='csv'){
            $name=time()."_"."IndividualAttendance.csv";
            // return Excel::download(new DailyAttendanceReport($all_data,$request,$company), $name);
            return (new IndividualAttendanceReport($employee,$request,$company))->download("$name", \Maatwebsite\Excel\Excel::CSV, ['Content-Type' => 'text/csv']);

        }
        else{
            return 0;
        }
    }

    public function overtime_report(){
          $this->checkuserRole(['admin','super-admin','branch-manager'],'');

          $this->checkuserRole(['admin','super-admin','branch-manager'],'');

        if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin')){
             $branch=DB::table('tb_branch')->get();
             $branch_list2=$this->setting->branchname_loginemployee();
        $department=DB::table('tb_departments')->get(['id','department_name']);
        $designation=DB::table('tb_designations')->get(['id','designation_name']);
        return view('backend.report.attendance.overtime_report',compact('branch',
            'department','designation','branch_list2'));
        }else {
             $branch=DB::table('tb_branch')->get();
             $branch_list2=$this->setting->branchname_loginemployee();
        $department=DB::table('tb_departments')->get(['id','department_name']);
        $designation=DB::table('tb_designations')->get(['id','designation_name']);
        return view('backend.report.attendance.overtime_report',compact('branch',
            'department','designation','branch_list2'));
        }

    }

    public function overtime_report_data(Request $request){
        if(request()->ajax()){
            $query=DB::table('tb_employee')
                ->leftJoin('tb_departments','tb_employee.emp_department_id','=','tb_departments.id')
                ->leftJoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
                ->leftJoin('tb_shift','tb_employee.emp_shift_id','=','tb_shift.id')
                ->leftJoin('tb_branch','tb_employee.branch_id','=','tb_branch.id')
                ->join('tb_attendance','tb_employee.id','=','tb_attendance.emp_id')
                ->whereBetween('tb_attendance.attendance_date',[$request->date,$request->end_date]);

            if($request->branch_id!=0){
                $query=$query->where('tb_employee.branch_id','=',$request->branch_id);
            }
            if($request->emp_id!=0){
                $query=$query->where('tb_employee.id','=',$request->emp_id);
            }
            if($request->department_id!=0){
                $query=$query->where('tb_employee.emp_department_id','=',$request->department_id);
            }
            if($request->designation_id!=0){
                $query=$query->where('tb_employee.emp_designation_id','=',$request->designation_id);
            }
            if($request->gender_id!=0){
                $query=$query->where('tb_employee.emp_gender_id','=',$request->gender_id);
            }

            $query=$query->where('emp_account_status','=',1);
            $query=$query->where('tb_attendance.out_time','>',DB::raw("tb_shift.exit_time"));

            $attendance_data=$query->select(DB::raw("CONCAT(tb_employee.emp_first_name,' ',tb_employee.emp_lastName) as full_name"),
                'tb_attendance.attendance_date','tb_attendance.in_time',
                'tb_shift.entry_time as shift_entry_time','tb_shift.exit_time as shift_exit_time',
                'tb_attendance.out_time','tb_employee.employeeId','tb_branch.branch_name',
                'tb_departments.department_name',DB::raw("TIME_FORMAT(timediff(tb_attendance.out_time, tb_shift.exit_time),'%H:%i') as overtime_hour"))->get();
            return datatables()->of($attendance_data,$request)
                ->addIndexColumn()
                ->make(true);

        }
        return view('backend.report.attendance.overtime_report_data',compact('request'));
    }
    public function overtime_report_export(Request $request){
        $query=DB::table('tb_employee')
            ->leftJoin('tb_departments','tb_employee.emp_department_id','=','tb_departments.id')
            ->leftJoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
            ->leftJoin('tb_shift','tb_employee.emp_shift_id','=','tb_shift.id')
            ->leftJoin('tb_branch','tb_employee.branch_id','=','tb_branch.id')
            ->join('tb_attendance','tb_employee.id','=','tb_attendance.emp_id')
            ->whereBetween('tb_attendance.attendance_date',[$request->date,$request->end_date]);

        if($request->branch_id!=0){
            $query=$query->where('tb_employee.branch_id','=',$request->branch_id);
        }
        if($request->emp_id!=0){
            $query=$query->where('tb_employee.id','=',$request->emp_id);
        }
        if($request->department_id!=0){
            $query=$query->where('tb_employee.emp_department_id','=',$request->department_id);
        }
        if($request->designation_id!=0){
            $query=$query->where('tb_employee.emp_designation_id','=',$request->designation_id);
        }
        if($request->gender_id!=0){
            $query=$query->where('tb_employee.emp_gender_id','=',$request->gender_id);
        }

        $query=$query->where('emp_account_status','=',1);
        $query=$query->where('tb_attendance.out_time','>',DB::raw("tb_shift.exit_time"));

        $attendance_data=$query->select(DB::raw("CONCAT(tb_employee.emp_first_name,' ',tb_employee.emp_lastName) as full_name"),
            'tb_attendance.attendance_date','tb_attendance.in_time',
            'tb_shift.entry_time as shift_entry_time','tb_shift.exit_time as shift_exit_time',
            'tb_attendance.out_time','tb_employee.employeeId','tb_branch.branch_name',
            'tb_departments.department_name',DB::raw("TIME_FORMAT(timediff(tb_attendance.out_time, tb_shift.exit_time),'%H:%i') as overtime_hour"))
            ->get();

        $company = DB::table('tb_company_information')->first();


        if($request->submit==='pdf') {
            if (count($attendance_data) < 400) {

                $pdf = PDF::loadView('backend.report.attendance.pdf.overtime_report_pdf', compact('attendance_data', 'company', 'request'));
                $name = time() . "_" . "overtime_report.pdf";
                return $pdf->download($name);
            }
            else{
                return view('backend.report.attendance.pdf.overtime_report_pdf', compact('attendance_data', 'company', 'request'));
            }

        }
        elseif ($request->submit==='excel'){
            $name=time()."_"."OvertimeReport.xlsx";
            return (new OvertimeReport($attendance_data,$request,$company))->download("$name", \Maatwebsite\Excel\Excel::XLSX);
        }

        elseif ($request->submit==='csv'){
            $name=time()."_"."OvertimeReport.csv";
            return (new OvertimeReport($attendance_data,$request,$company))->download("$name", \Maatwebsite\Excel\Excel::CSV, ['Content-Type' => 'text/csv']);

        }
        else{
            return 0;
        }
    }

    public function attendance_exception_report(){
          $this->checkuserRole(['admin','super-admin','branch-manager'],'');


        if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin')){
            $branch=DB::table('tb_branch')->get();
             $branch_list2=$this->setting->branchname_loginemployee();
        $department=DB::table('tb_departments')->get(['id','department_name']);
        $designation=DB::table('tb_designations')->get(['id','designation_name']);
        return view('backend.report.attendance.attendance_exception_report',compact('branch',
            'department','designation','branch_list2'));
        }else{
             $branch=DB::table('tb_branch')->get();
             $branch_list2=$this->setting->branchname_loginemployee();
        $department=DB::table('tb_departments')->get(['id','department_name']);
        $designation=DB::table('tb_designations')->get(['id','designation_name']);
        return view('backend.report.attendance.attendance_exception_report',compact('branch',
            'department','designation','branch_list2'));
        }


    }

    public function attendance_exception_data(Request $request){
        if(request()->ajax()){
            $query=DB::table('tb_employee')
                ->leftJoin('tb_departments','tb_employee.emp_department_id','=','tb_departments.id')
                ->leftJoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
                ->leftJoin('tb_branch','tb_employee.branch_id','=','tb_branch.id')
                ->join('tb_attendance','tb_employee.id','=','tb_attendance.emp_id')
                ->whereBetween('tb_attendance.attendance_date',[$request->date,$request->end_date]);

            if($request->branch_id!=0){
                $query=$query->where('tb_employee.branch_id','=',$request->branch_id);
            }
            if($request->emp_id!=0){
                $query=$query->where('tb_employee.id','=',$request->emp_id);
            }
            if($request->department_id!=0){
                $query=$query->where('tb_employee.emp_department_id','=',$request->department_id);
            }
            if($request->designation_id!=0){
                $query=$query->where('tb_employee.emp_designation_id','=',$request->designation_id);
            }
            if($request->gender_id!=0){
                $query=$query->where('tb_employee.emp_gender_id','=',$request->gender_id);
            }

            $query=$query->where('emp_account_status','=',1);
            $query=$query->where('tb_attendance.in_time','=',DB::raw("tb_attendance.out_time"));

            $attendance_data=$query->select(DB::raw("CONCAT(tb_employee.emp_first_name,' ',tb_employee.emp_lastName) as full_name"),
                'tb_attendance.attendance_date','tb_attendance.in_time',
                'tb_attendance.out_time','tb_employee.employeeId','tb_branch.branch_name',
                'tb_departments.department_name')->get();
            return datatables()->of($attendance_data,$request)
                ->addIndexColumn()
                ->make(true);

        }
        return view('backend.report.attendance.attendance_exception_data',compact('request'));
    }

    public function attendance_exception_export(Request $request){
//        return $request->all();
        $query=DB::table('tb_employee')
            ->leftJoin('tb_departments','tb_employee.emp_department_id','=','tb_departments.id')
            ->leftJoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
            ->leftJoin('tb_branch','tb_employee.branch_id','=','tb_branch.id')
            ->join('tb_attendance','tb_employee.id','=','tb_attendance.emp_id')
            ->whereBetween('tb_attendance.attendance_date',[$request->date,$request->end_date]);

        if($request->branch_id!=0){
            $query=$query->where('tb_employee.branch_id','=',$request->branch_id);
        }
        if($request->emp_id!=0){
            $query=$query->where('tb_employee.id','=',$request->emp_id);
        }
        if($request->department_id!=0){
            $query=$query->where('tb_employee.emp_department_id','=',$request->department_id);
        }
        if($request->designation_id!=0){
            $query=$query->where('tb_employee.emp_designation_id','=',$request->designation_id);
        }
        if($request->gender_id!=0){
            $query=$query->where('tb_employee.emp_gender_id','=',$request->gender_id);
        }

        $query=$query->where('emp_account_status','=',1);
        $query=$query->where('tb_attendance.in_time','=',DB::raw("tb_attendance.out_time"));

        $attendance_data=$query->select(DB::raw("CONCAT(tb_employee.emp_first_name,' ',tb_employee.emp_lastName) as full_name"),
            'tb_attendance.attendance_date','tb_attendance.in_time',
            'tb_attendance.out_time','tb_employee.employeeId','tb_branch.branch_name',
            'tb_departments.department_name')
            ->get();

        $company = DB::table('tb_company_information')->first();


        if($request->submit==='pdf') {
            if (count($attendance_data) < 400) {

                $pdf = PDF::loadView('backend.report.attendance.pdf.attendance_exception_pdf', compact('attendance_data', 'company', 'request'));
                $name = time() . "_" . "Attendance_Exception.pdf";
                return $pdf->download($name);
            }
            else{
                return view('backend.report.attendance.pdf.attendance_exception_pdf', compact('attendance_data', 'company', 'request'));
            }

        }
        elseif ($request->submit==='excel'){
            $name=time()."_"."AttendanceException.xlsx";
            return (new AttendanceException($attendance_data,$request,$company))->download("$name", \Maatwebsite\Excel\Excel::XLSX);
        }

        elseif ($request->submit==='csv'){
            $name=time()."_"."AttendanceException.csv";
            return (new AttendanceException($attendance_data,$request,$company))->download("$name", \Maatwebsite\Excel\Excel::CSV, ['Content-Type' => 'text/csv']);

        }
        else{
            return 0;
        }
    }
}
