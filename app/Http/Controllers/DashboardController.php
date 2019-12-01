<?php

namespace App\Http\Controllers;

use PDF;
use Auth;
use Session;
use Validator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Repositories\Settings;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display dashboard after login successful.
     */
        // if (condition) {
        //     # code...
        // } else {
        //     # code...
        // }
        


     public function dashboard_view(){
         $dashboard=array();
         $today=Carbon::now()->toDateString();

         if(auth()->user()->hasRole(['admin','super-admin'])) {


             $employee_list = DB::table('tb_employee')->count();
             $dashboard['all_employee_list'] = $employee_list;

             $active_employee_list = DB::table('tb_employee')->where('emp_account_status', '=', '1')->count();
             $dashboard['active_employee_list'] = $active_employee_list;

             $inactive_employee_list = DB::table('tb_employee')->where('emp_account_status', '=', '0')->count();
             $dashboard['inactive_employee_list'] = $inactive_employee_list;


             $active_male_employee_list = DB::table('tb_employee')->where([['emp_account_status', '=', '1'], ['emp_gender_id', '=', '1']])->count();
             $dashboard['active_male_employee_list'] = $active_male_employee_list;

             $active_female_employee_list = DB::table('tb_employee')->where([['emp_account_status', '=', '1'], ['emp_gender_id', '=', '2']])->count();
             $dashboard['active_female_employee_list'] = $active_female_employee_list;

             $favourites_employee = DB::table('tb_favourites')->count();
             $dashboard['favourites_employee'] = $favourites_employee;

             $employee_group = DB::table('tb_groups')->count();
             $dashboard['employee_group'] = $employee_group;

             $branch = DB::table('tb_branch')->count();
             $dashboard['branch'] = $branch;

             $designations = DB::table('tb_designations')->count();
             $dashboard['designations'] = $designations;

             $departments = DB::table('tb_departments')->count();
             $dashboard['departments'] = $departments;

             $clients = DB::table('tb_clients')->count();
             $dashboard['clients'] = $clients;

             $projects = DB::table('tb_project')->count();
             $dashboard['projects'] = $projects;

             $training = DB::table('tb_training')->count();
             $dashboard['training'] = $training;

             $shift = DB::table('tb_shift')->count();
             $dashboard['shift'] = $shift;

             $today_attendance = DB::table('tb_attendance')->where('attendance_date', date('Y-m-d'))->count();
             $dashboard['today_attendance'] = $today_attendance;

             $meeting = DB::table('tb_meetings')->where('meeting_date', '>=', date('Y-m-d'))->count();
             $dashboard['meeting'] = $meeting;

             $lastThirtyDay = \Carbon\Carbon::today()->subDays(30);
             $lastThirtyDate = date('Y-m-d', strtotime($lastThirtyDay));

             $newEmployeeList = DB::table('tb_employee')
                 ->leftjoin('tb_departments', 'tb_employee.emp_department_id', '=', 'tb_departments.id')
                 ->leftjoin('tb_designations', 'tb_employee.emp_designation_id', '=', 'tb_designations.id')
                 ->leftjoin('tb_branch', 'tb_employee.branch_id', '=', 'tb_branch.id')
                 ->select('tb_employee.id', 'tb_employee.emp_first_name', 'tb_employee.emp_lastName', 'tb_employee.emp_joining_date', 'tb_employee.employeeId', 'tb_departments.department_name', 'tb_designations.designation_name', 'tb_employee.employeeId', 'tb_branch.branch_name')
                 ->where('tb_employee.emp_joining_date', '>', $lastThirtyDate)
                 ->orderBy('tb_employee.emp_joining_date', 'DESC')
                 ->get();
             for ($i = $lastThirtyDay; $i <= $today; $i = $i->addDay()) {
                 $date = Carbon::parse($i)->toDateString();
                 $present = DB::table('tb_attendance')->where('attendance_date', '=', $date)
                     ->count();
                 $presentData[] = [
                     'date' => $date,
                     'present' => $present,
                 ];

             }
//        $thirtyDayAttendance=DB::table('tb_attendance')
//            ->whereBetween('attendance_date',[$lastThirtyDay,$today])
//            ->groupBy('attendance_date')
//            ->select('attendance_date',DB::raw("count('emp_id') as present"))
//            ->get();
//
//        return $presentData;
             $lateEmployeeList = DB::table('tb_employee')
                 ->join('tb_attendance', 'tb_employee.id', '=', 'tb_attendance.emp_id')
                 ->leftjoin('tb_departments', 'tb_employee.emp_department_id', '=', 'tb_departments.id')
                 ->leftjoin('tb_designations', 'tb_employee.emp_designation_id', '=', 'tb_designations.id')
                 ->leftjoin('tb_branch', 'tb_employee.branch_id', '=', 'tb_branch.id')
                 ->leftJoin('tb_shift', 'tb_employee.emp_shift_id', '=', 'tb_shift.id')
                 ->select('tb_employee.id', 'tb_attendance.in_time', 'tb_employee.emp_first_name', 'tb_employee.emp_lastName', 'tb_employee.emp_joining_date', 'tb_employee.employeeId', 'tb_departments.department_name', 'tb_designations.designation_name', 'tb_employee.employeeId', 'tb_branch.branch_name')
                 ->where('tb_employee.emp_account_status', '=', 1)
                 ->where('tb_attendance.in_time', '>', DB::raw("tb_shift.entry_time"))
                 ->where('tb_attendance.attendance_date', '=', $today)
                 ->orderBy('tb_employee.emp_first_name')
                 ->get();

             $leaveEmployeeList = DB::table('tb_employee')
                 ->leftjoin('tb_departments', 'tb_employee.emp_department_id', '=', 'tb_departments.id')
                 ->leftjoin('tb_designations', 'tb_employee.emp_designation_id', '=', 'tb_designations.id')
                 ->leftjoin('tb_branch', 'tb_employee.branch_id', '=', 'tb_branch.id')
                 ->join('tb_leave_application', 'tb_employee.id', '=', 'tb_leave_application.emp_id')
                 ->where("tb_leave_application.leave_starting_date", '<=', $today)
                 ->where("tb_leave_application.leave_ending_date", '>=', $today)
                 ->where('tb_leave_application.status', '=', 1)
                 ->select('tb_employee.id', 'tb_employee.emp_first_name', 'tb_employee.emp_lastName', 'tb_employee.emp_joining_date', 'tb_employee.employeeId', 'tb_departments.department_name', 'tb_designations.designation_name', 'tb_employee.employeeId', 'tb_branch.branch_name')
                 ->orderBy('tb_employee.emp_first_name')
                 ->get();

             $upcomingNotice=DB::table('tb_announcement')->where('end_date','>=',$today)
                 ->get();

             $expenseList=DB::table('tb_expanse')
                 ->join('tb_expanse_category','tb_expanse.category_id','=','tb_expanse_category.id')
                 ->join('users','tb_expanse.created_by','=','users.id')
                 ->join('tb_employee','users.emp_id','=','tb_employee.id')
                 ->where('tb_expanse.expanse_date','=',Carbon::now()->toDateString())
                 ->orderBy('tb_expanse.created_by','desc')
                 ->select('tb_expanse.id','tb_expanse.amount','tb_expanse_category.category_name',
                     'tb_expanse.expanse_date','tb_employee.emp_first_name',
                     'tb_employee.emp_lastName','tb_employee.employeeId','tb_expanse.status')
                 ->get();

             $pendingEmployeeList = DB::table('tb_employee')
                 ->leftjoin('tb_departments', 'tb_employee.emp_department_id', '=', 'tb_departments.id')
                 ->leftjoin('tb_designations', 'tb_employee.emp_designation_id', '=', 'tb_designations.id')
                 ->leftjoin('tb_branch', 'tb_employee.branch_id', '=', 'tb_branch.id')
                 ->join('tb_leave_application', 'tb_employee.id', '=', 'tb_leave_application.emp_id')
                 ->where('tb_leave_application.status', '=', 0)
                 ->select('tb_employee.id', 'tb_leave_application.leave_starting_date', 'tb_leave_application.leave_ending_date', 'tb_employee.emp_first_name', 'tb_employee.emp_lastName', 'tb_employee.emp_joining_date', 'tb_employee.employeeId', 'tb_departments.department_name', 'tb_designations.designation_name', 'tb_employee.employeeId', 'tb_branch.branch_name')
                 ->orderBy('tb_employee.emp_first_name')
                 ->get();

            return view('backend.dashboard.dashboard',compact('dashboard','presentData','leaveEmployeeList', 'newEmployeeList','pendingEmployeeList','lateEmployeeList','expenseList', 'upcomingNotice'));
         }

         if(auth()->user()->hasRole(['branch-manager'])) {
             $settings = new Settings();
//             $branch_id = DB::table('users')->leftJoin('tb_employee', 'users.emp');
             $branch_id=$settings->get_login_branch_id();
             $employee_list = DB::table('tb_employee')
                 ->where('branch_id','=',$branch_id)
                 ->count();
             $dashboard['all_employee_list'] = $employee_list;

             $active_employee_list = DB::table('tb_employee')
                 ->where('branch_id','=',$branch_id)
                 ->where('emp_account_status', '=', '1')
                 ->count();
             $dashboard['active_employee_list'] = $active_employee_list;

             $inactive_employee_list = DB::table('tb_employee')
                 ->where('branch_id','=',$branch_id)
                 ->where('emp_account_status', '=', '0')
                 ->count();
             $dashboard['inactive_employee_list'] = $inactive_employee_list;


             $active_male_employee_list = DB::table('tb_employee')
                 ->where('branch_id','=',$branch_id)
                 ->where([['emp_account_status', '=', '1'], ['emp_gender_id', '=', '1']])
                 ->count();
//             return $active_male_employee_list;
             $dashboard['active_male_employee_list'] = $active_male_employee_list;

             $active_female_employee_list = DB::table('tb_employee')
                 ->where('branch_id','=',$branch_id)
                 ->where([['emp_account_status', '=', '1'], ['emp_gender_id', '=', '2']])
                 ->count();
//             return $active_female_employee_list;
             $dashboard['active_female_employee_list'] = $active_female_employee_list;

             $favourites_employee = DB::table('tb_favourites')
                 ->leftJoin('tb_employee','tb_favourites.emp_id','=','tb_employee.id')
                 ->where('branch_id','=',$branch_id)
                 ->count();
             $dashboard['favourites_employee'] = $favourites_employee;

             $employee_group = DB::table('tb_groups')
                 ->leftJoin('tb_employee','tb_groups.group_leader_id','=','tb_employee.id')
                 ->where('branch_id','=',$branch_id)
                 ->count();
             $dashboard['employee_group'] = $employee_group;

             $branch = DB::table('tb_branch')->count();
             $dashboard['branch'] = $branch;

             $designations = DB::table('tb_designations')->count();
             $dashboard['designations'] = $designations;

             $departments = DB::table('tb_departments')->count();
             $dashboard['departments'] = $departments;

             $clients = DB::table('tb_clients')
                 ->where('branch_id','=',$branch_id)
                 ->count();
             $dashboard['clients'] = $clients;

             $projects = DB::table('tb_project')
                 ->where('branch_id','=',$branch_id)
                 ->count();
             $dashboard['projects'] = $projects;

             $training = DB::table('tb_training')->count();
             $dashboard['training'] = $training;

             $shift = DB::table('tb_shift')->count();
             $dashboard['shift'] = $shift;

             $today_attendance = DB::table('tb_attendance')
                 ->leftJoin('tb_employee','tb_attendance.emp_id','tb_employee.id')
                 ->where('tb_employee.branch_id','=',$branch_id)
                 ->where('attendance_date', date('Y-m-d'))->count();
             $dashboard['today_attendance'] = $today_attendance;

             $meeting = DB::table('tb_meetings')
                 ->where('branch_id','=',$branch_id)
                 ->where('meeting_date', '>=', date('Y-m-d'))->count();
             $dashboard['meeting'] = $meeting;

             $lastThirtyDay = \Carbon\Carbon::today()->subDays(30);
             $lastThirtyDate = date('Y-m-d', strtotime($lastThirtyDay));
             $newEmployeeList = DB::table('tb_employee')
                 ->leftjoin('tb_departments', 'tb_employee.emp_department_id', '=', 'tb_departments.id')
                 ->leftjoin('tb_designations', 'tb_employee.emp_designation_id', '=', 'tb_designations.id')
                 ->leftjoin('tb_branch', 'tb_employee.branch_id', '=', 'tb_branch.id')
                 ->where('tb_employee.branch_id','=',$branch_id)
                 ->select('tb_employee.id', 'tb_employee.emp_first_name', 'tb_employee.emp_lastName', 'tb_employee.emp_joining_date', 'tb_employee.employeeId', 'tb_departments.department_name', 'tb_designations.designation_name', 'tb_employee.employeeId', 'tb_branch.branch_name')
                 ->where('tb_employee.emp_joining_date', '>', $lastThirtyDate)
                 ->orderBy('tb_employee.emp_joining_date', 'DESC')
                 ->get();
             for ($i = $lastThirtyDay; $i <= $today; $i = $i->addDay()) {
                 $date = Carbon::parse($i)->toDateString();
                 $present = DB::table('tb_attendance')
                     ->leftJoin('tb_employee','tb_attendance.emp_id','tb_employee.id')
                     ->where('tb_employee.branch_id','=',$branch_id)
                     ->where('attendance_date', '=', $date)
                     ->count();
                 $presentData[] = [
                     'date' => $date,
                     'present' => $present,
                 ];

             }
//        $thirtyDayAttendance=DB::table('tb_attendance')
//            ->whereBetween('attendance_date',[$lastThirtyDay,$today])
//            ->groupBy('attendance_date')
//            ->select('attendance_date',DB::raw("count('emp_id') as present"))
//            ->get();
//
//        return $presentData;
             $lateEmployeeList = DB::table('tb_employee')
                 ->join('tb_attendance', 'tb_employee.id', '=', 'tb_attendance.emp_id')
                 ->leftjoin('tb_departments', 'tb_employee.emp_department_id', '=', 'tb_departments.id')
                 ->leftjoin('tb_designations', 'tb_employee.emp_designation_id', '=', 'tb_designations.id')
                 ->leftjoin('tb_branch', 'tb_employee.branch_id', '=', 'tb_branch.id')
                 ->leftJoin('tb_shift', 'tb_employee.emp_shift_id', '=', 'tb_shift.id')
                 ->select('tb_employee.id', 'tb_attendance.in_time', 'tb_employee.emp_first_name', 'tb_employee.emp_lastName', 'tb_employee.emp_joining_date', 'tb_employee.employeeId', 'tb_departments.department_name', 'tb_designations.designation_name', 'tb_employee.employeeId', 'tb_branch.branch_name')
                 ->where('tb_employee.branch_id','=',$branch_id)
                 ->where('tb_employee.emp_account_status', '=', 1)
                 ->where('tb_attendance.in_time', '>', DB::raw("tb_shift.entry_time"))
                 ->where('tb_attendance.attendance_date', '=', $today)
                 ->orderBy('tb_employee.emp_first_name')
                 ->get();

             $leaveEmployeeList = DB::table('tb_employee')
                 ->leftjoin('tb_departments', 'tb_employee.emp_department_id', '=', 'tb_departments.id')
                 ->leftjoin('tb_designations', 'tb_employee.emp_designation_id', '=', 'tb_designations.id')
                 ->leftjoin('tb_branch', 'tb_employee.branch_id', '=', 'tb_branch.id')
                 ->join('tb_leave_application', 'tb_employee.id', '=', 'tb_leave_application.emp_id')
                 ->where('tb_employee.branch_id','=',$branch_id)
                 ->where("tb_leave_application.leave_starting_date", '<=', $today)
                 ->where("tb_leave_application.leave_ending_date", '>=', $today)
                 ->where('tb_leave_application.status', '=', 1)
                 ->select('tb_employee.id', 'tb_employee.emp_first_name', 'tb_employee.emp_lastName', 'tb_employee.emp_joining_date', 'tb_employee.employeeId', 'tb_departments.department_name', 'tb_designations.designation_name', 'tb_employee.employeeId', 'tb_branch.branch_name')
                 ->orderBy('tb_employee.emp_first_name')
                 ->get();

             $expenseList=DB::table('tb_expanse')
                 ->join('tb_expanse_category','tb_expanse.category_id','=','tb_expanse_category.id')
                 ->join('users','tb_expanse.created_by','=','users.id')
                 ->join('tb_employee','users.emp_id','=','tb_employee.id')
                 ->where('tb_employee.branch_id','=',$branch_id)
                 ->where('tb_expanse.expanse_date','=',Carbon::now()->toDateString())
                 ->orderBy('tb_expanse.created_by','desc')
                 ->select('tb_expanse.id','tb_expanse.amount','tb_expanse_category.category_name',
                     'tb_expanse.expanse_date','tb_employee.emp_first_name',
                     'tb_employee.emp_lastName','tb_employee.employeeId','tb_expanse.status')
                 ->get();

             $pendingEmployeeList = DB::table('tb_employee')
                 ->leftjoin('tb_departments', 'tb_employee.emp_department_id', '=', 'tb_departments.id')
                 ->leftjoin('tb_designations', 'tb_employee.emp_designation_id', '=', 'tb_designations.id')
                 ->leftjoin('tb_branch', 'tb_employee.branch_id', '=', 'tb_branch.id')
                 ->join('tb_leave_application', 'tb_employee.id', '=', 'tb_leave_application.emp_id')
                 ->where('tb_leave_application.status', '=', 0)
                 ->where('tb_employee.branch_id','=',$branch_id)
                 ->select('tb_employee.id', 'tb_leave_application.leave_starting_date', 'tb_leave_application.leave_ending_date', 'tb_employee.emp_first_name', 'tb_employee.emp_lastName', 'tb_employee.emp_joining_date', 'tb_employee.employeeId', 'tb_departments.department_name', 'tb_designations.designation_name', 'tb_employee.employeeId', 'tb_branch.branch_name')
                 ->orderBy('tb_employee.emp_first_name')
                 ->get();

             $upcomingNotice=DB::table('tb_announcement')->where('end_date','>=',$today)
                 ->whereBetween('branch_id',[0,$branch_id])
                 ->get();


            return view('backend.dashboard.dashboard',compact('dashboard','presentData','leaveEmployeeList', 'newEmployeeList','pendingEmployeeList','lateEmployeeList','expenseList', 'upcomingNotice'));
         }

         if(auth()->user()->hasRole(['employee'])) {
             $id=auth()->user()->emp_id;
            
             $projects = DB::table('tb_assign_project')
                 ->where('member_id','=',auth()->user()->emp_id)
                 ->count();
             $dashboard['projects'] = $projects;

             $training = DB::table('tb_training')->count();
             $dashboard['training'] = $training;

             $meeting = DB::table('tb_meetings')->where('meeting_date', '>=', date('Y-m-d'))->count();
             $dashboard['meeting'] = $meeting;
            
             $task = DB::table('tb_task_employee')->where([['emp_id', '=', $id], ['status', '=', 1]])->count();
             $dashboard['task'] = $task;

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
            $settings = new Settings();
            $total=$settings->dayCalculator($start,Carbon::now()->toDateString());
            $attendace =  [
                'month' => $month,
                'present' => $present,
                'leave' => $leave_total,
                'working_days'=>$total,
            ];

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
            return view('backend.dashboard.employee_dashboard',compact('dashboard','attendace','user'));
         }

     }

    public function employee_list($group){

         $settings=new Settings();

        $groupId=base64_decode($group);
        $groupName='';
        if(auth()->user()->hasRole(['admin','super-admin'])) {
            if($groupId=='all_employee_list'){
                $groupName="All employee list";

                $employee_list = DB::table('tb_employee')
                ->leftjoin('tb_departments','tb_employee.emp_department_id','=','tb_departments.id')
                ->leftjoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
                ->leftjoin('tb_branch','tb_employee.branch_id','=','tb_branch.id')
                ->select('tb_employee.id','tb_employee.emp_first_name','tb_employee.emp_account_status','tb_employee.emp_card_number','tb_departments.department_name','tb_designations.designation_name','tb_employee.employeeId','tb_branch.branch_name')
                ->orderBy('tb_employee.id', 'asc')->get();
            }
            elseif($groupId=='active_employee_list'){
                $groupName="Active employee list";

                $employee_list = DB::table('tb_employee')
                ->leftjoin('tb_departments','tb_employee.emp_department_id','=','tb_departments.id')
                ->leftjoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
                ->leftjoin('tb_branch','tb_employee.branch_id','=','tb_branch.id')
                ->select('tb_employee.id','tb_employee.emp_first_name','tb_employee.emp_account_status','tb_employee.emp_card_number','tb_departments.department_name','tb_designations.designation_name','tb_employee.employeeId','tb_branch.branch_name')
                ->where('tb_employee.emp_account_status','=',1)
                ->orderBy('tb_employee.id', 'asc')->get();
            }
            elseif($groupId=='inactive_employee_list'){
                $groupName="Inactive employee list";

                $employee_list = DB::table('tb_employee')
                ->leftjoin('tb_departments','tb_employee.emp_department_id','=','tb_departments.id')
                ->leftjoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
                ->leftjoin('tb_branch','tb_employee.branch_id','=','tb_branch.id')
                ->select('tb_employee.id','tb_employee.emp_first_name','tb_employee.emp_account_status','tb_employee.emp_card_number','tb_departments.department_name','tb_designations.designation_name','tb_employee.employeeId','tb_branch.branch_name')
                ->where('tb_employee.emp_account_status','=',0)
                ->orderBy('tb_employee.id', 'asc')->get();
            }
            elseif($groupId=='active_male_employee_list'){
                $groupName="Active male employee list";

                $employee_list = DB::table('tb_employee')
                ->leftjoin('tb_departments','tb_employee.emp_department_id','=','tb_departments.id')
                ->leftjoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
                ->leftjoin('tb_branch','tb_employee.branch_id','=','tb_branch.id')
                ->select('tb_employee.id','tb_employee.emp_first_name','tb_employee.emp_account_status','tb_employee.emp_card_number','tb_departments.department_name','tb_designations.designation_name','tb_employee.employeeId','tb_branch.branch_name')
                ->where([['tb_employee.emp_account_status','=',1],['tb_employee.emp_gender_id','=',1]])
                ->orderBy('tb_employee.id', 'asc')->get();
            }
            elseif($groupId=='active_female_employee_list'){
                $groupName="Active female employee list";

                $employee_list = DB::table('tb_employee')
                ->leftjoin('tb_departments','tb_employee.emp_department_id','=','tb_departments.id')
                ->leftjoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
                ->leftjoin('tb_branch','tb_employee.branch_id','=','tb_branch.id')
                ->select('tb_employee.id','tb_employee.emp_first_name','tb_employee.emp_account_status','tb_employee.emp_card_number','tb_departments.department_name','tb_designations.designation_name','tb_employee.employeeId','tb_branch.branch_name')
                ->where([['tb_employee.emp_account_status','=',1],['tb_employee.emp_gender_id','=',2]])
                ->orderBy('tb_employee.id', 'asc')->get();
            }
        }
        else{
            $branch_id=$settings->get_login_branch_id();
            if($groupId=='all_employee_list'){
                $groupName="All employee list";

                $employee_list = DB::table('tb_employee')
                    ->leftjoin('tb_departments','tb_employee.emp_department_id','=','tb_departments.id')
                    ->leftjoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
                    ->leftjoin('tb_branch','tb_employee.branch_id','=','tb_branch.id')
                    ->select('tb_employee.id','tb_employee.emp_first_name','tb_employee.emp_account_status','tb_employee.emp_card_number','tb_departments.department_name','tb_designations.designation_name','tb_employee.employeeId','tb_branch.branch_name')
                    ->where('tb_employee.branch_id','=',$branch_id)
                    ->orderBy('tb_employee.id', 'asc')->get();
            }
            elseif($groupId=='active_employee_list'){
                $groupName="Active employee list";

                $employee_list = DB::table('tb_employee')
                    ->leftjoin('tb_departments','tb_employee.emp_department_id','=','tb_departments.id')
                    ->leftjoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
                    ->leftjoin('tb_branch','tb_employee.branch_id','=','tb_branch.id')
                    ->select('tb_employee.id','tb_employee.emp_first_name','tb_employee.emp_account_status','tb_employee.emp_card_number','tb_departments.department_name','tb_designations.designation_name','tb_employee.employeeId','tb_branch.branch_name')
                    ->where('tb_employee.branch_id','=',$branch_id)
                    ->where('tb_employee.emp_account_status','=',1)
                    ->orderBy('tb_employee.id', 'asc')->get();
            }
            elseif($groupId=='inactive_employee_list'){
                $groupName="Inactive employee list";

                $employee_list = DB::table('tb_employee')
                    ->leftjoin('tb_departments','tb_employee.emp_department_id','=','tb_departments.id')
                    ->leftjoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
                    ->leftjoin('tb_branch','tb_employee.branch_id','=','tb_branch.id')
                    ->select('tb_employee.id','tb_employee.emp_first_name','tb_employee.emp_account_status','tb_employee.emp_card_number','tb_departments.department_name','tb_designations.designation_name','tb_employee.employeeId','tb_branch.branch_name')
                    ->where('tb_employee.branch_id','=',$branch_id)
                    ->where('tb_employee.emp_account_status','=',0)
                    ->orderBy('tb_employee.id', 'asc')->get();
            }
            elseif($groupId=='active_male_employee_list'){
                $groupName="Active male employee list";

                $employee_list = DB::table('tb_employee')
                    ->leftjoin('tb_departments','tb_employee.emp_department_id','=','tb_departments.id')
                    ->leftjoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
                    ->leftjoin('tb_branch','tb_employee.branch_id','=','tb_branch.id')
                    ->select('tb_employee.id','tb_employee.emp_first_name','tb_employee.emp_account_status','tb_employee.emp_card_number','tb_departments.department_name','tb_designations.designation_name','tb_employee.employeeId','tb_branch.branch_name')
                    ->where('tb_employee.branch_id','=',$branch_id)
                    ->where([['tb_employee.emp_account_status','=',1],['tb_employee.emp_gender_id','=',1]])
                    ->orderBy('tb_employee.id', 'asc')->get();
            }
            elseif($groupId=='active_female_employee_list'){
                $groupName="Active female employee list";

                $employee_list = DB::table('tb_employee')
                    ->leftjoin('tb_departments','tb_employee.emp_department_id','=','tb_departments.id')
                    ->leftjoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
                    ->leftjoin('tb_branch','tb_employee.branch_id','=','tb_branch.id')
                    ->select('tb_employee.id','tb_employee.emp_first_name','tb_employee.emp_account_status','tb_employee.emp_card_number','tb_departments.department_name','tb_designations.designation_name','tb_employee.employeeId','tb_branch.branch_name')
                    ->where('tb_employee.branch_id','=',$branch_id)
                    ->where([['tb_employee.emp_account_status','=',1],['tb_employee.emp_gender_id','=',2]])
                    ->orderBy('tb_employee.id', 'asc')->get();
            }

        }


        if(request()->ajax())
        {
            $start=0;
            return datatables()->of($employee_list)
                ->addColumn('action', function($data){
                    return '<a target="_blank" class="profile btn btn-blue btn-xs" title="View Profile" href="'.route('employee.profile', base64_encode($data->id)).'"><i class="fa fa-eye"></i></a>';
                })
              ->rawColumns(['action'])
              ->addIndexColumn()
                ->make(true);
        }
       return view('backend.dashboard.employee_list', compact('group','groupName'));
    }
}
