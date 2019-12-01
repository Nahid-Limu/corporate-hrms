<?php

namespace App\Http\Controllers\Api;

use Auth;
use Illuminate\Support\Facades\DB;
use Validator;
use Carbon\Carbon;
use App\Repositories\Settings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BrancheManagerPanelController extends Controller
{
    protected $settings;

    public function __construct()
    {
        // create object of settings class
        $this->settings = new Settings();
    }

    public $successStatus = 200;


        // ===================================== adminDashboard ============================================
     public function BrancheDashboard(){

         $settings = new Settings();
             $branch_id=$settings->get_login_branch_id();
             $employee_list = DB::table('tb_employee')
                 ->where('branch_id','=',$branch_id)
                 ->count();


             $active_employee_list = DB::table('tb_employee')
                 ->where('branch_id','=',$branch_id)
                 ->where('emp_account_status', '=', '1')
                 ->count();


             $inactive_employee_list = DB::table('tb_employee')
                 ->where('branch_id','=',$branch_id)
                 ->where('emp_account_status', '=', '0')
                 ->count();



             $active_male_employee_list = DB::table('tb_employee')
                 ->where('branch_id','=',$branch_id)
                 ->where([['emp_account_status', '=', '1'], ['emp_gender_id', '=', '1']])
                 ->count();
//

             $active_female_employee_list = DB::table('tb_employee')
                 ->where('branch_id','=',$branch_id)
                 ->where([['emp_account_status', '=', '1'], ['emp_gender_id', '=', '2']])
                 ->count();
//

             $favourites_employee = DB::table('tb_favourites')
                 ->leftJoin('tb_employee','tb_favourites.emp_id','=','tb_employee.id')
                 ->where('branch_id','=',$branch_id)
                 ->count();


             $employee_group = DB::table('tb_groups')
                 ->leftJoin('tb_employee','tb_groups.group_leader_id','=','tb_employee.id')
                 ->where('branch_id','=',$branch_id)
                 ->count();


             $branch = DB::table('tb_branch')->count();


             $designations = DB::table('tb_designations')->count();


             $departments = DB::table('tb_departments')->count();


             $clients = DB::table('tb_clients')
                 ->where('branch_id','=',$branch_id)
                 ->count();


             $projects = DB::table('tb_project')
                 ->where('branch_id','=',$branch_id)
                 ->count();


             $training = DB::table('tb_training')->count();


             $shift = DB::table('tb_shift')->count();


             $today_attendance = DB::table('tb_attendance')
                 ->leftJoin('tb_employee','tb_attendance.emp_id','tb_employee.id')
                 ->where('tb_employee.branch_id','=',$branch_id)
                 ->where('attendance_date', date('Y-m-d'))->count();


             $meeting = DB::table('tb_meetings')
                 ->where('branch_id','=',$branch_id)
                 ->where('meeting_date', '>=', date('Y-m-d'))->count();




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

            //  $upcomingNotice=DB::table('tb_announcement')->where('end_date','>=',$today)
            //      ->whereBetween('branch_id',[0,$branch_id])
            //      ->get();



      $queryLeave=DB::table('tb_employee')
                ->leftJoin('tb_departments', 'tb_employee.emp_department_id', '=', 'tb_departments.id')
                ->leftJoin('tb_designations', 'tb_employee.emp_designation_id', '=', 'tb_designations.id')
                ->leftJoin('tb_shift', 'tb_employee.emp_shift_id', '=', 'tb_shift.id')
                ->leftJoin('tb_branch', 'tb_employee.branch_id', '=', 'tb_branch.id')
                ->join('tb_leave_application', 'tb_employee.id', '=', 'tb_leave_application.emp_id')
                 ->where('tb_employee.branch_id','=',$branch_id)
                ->where("tb_leave_application.leave_starting_date",'<=', date('Y-m-d'))
                ->where("tb_leave_application.leave_ending_date",'>=', date('Y-m-d'))->count();

        $absent = $active_employee_list - $today_attendance-$queryLeave ;


         $leate=DB::table('tb_employee')
                ->leftJoin('tb_departments','tb_employee.emp_department_id','=','tb_departments.id')
                ->leftJoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
                ->leftJoin('tb_shift','tb_employee.emp_shift_id','=','tb_shift.id')
                ->leftJoin('tb_branch','tb_employee.branch_id','=','tb_branch.id')
                ->join('tb_attendance','tb_employee.id','=','tb_attendance.emp_id')
                 ->where('tb_employee.branch_id','=',$branch_id)
                ->whereBetween('tb_attendance.attendance_date',[ date('Y-m-d'), date('Y-m-d')])->count();



         $dashboard=   [
                'total_employee_count' => $employee_list,
                'total_active_employee_count' => $active_employee_list,
                'total_inactive_employee_count' => $inactive_employee_list,
                'total_active_male_employee_count' => $active_male_employee_list,
                'total_active_female_employee_count' => $active_female_employee_list,
                'total_favourites_employee_count' => $favourites_employee,
                'total_employee_group_count' => $employee_group,
                'total_branch_count' => $branch,
                'total_designations_count' => $designations,
                'total_departments_count' => $departments,
                'clients_count' => $clients,
                'total_projects_count' => $projects,
                'total_training_count' => $training,
                'total_today_attendance_count' => $today_attendance,
                'total_absent_count' => $absent,
                'total_Leave_count' => $queryLeave,
                'total_late_count' => $leate,



             ];

         return response()->json(['dashboard'=>$dashboard], $this->successStatus);


    }

    // ===================================== End adminDashboard ============================================

       public function BrancheManagerallEmployee(){

        $branch_id=$this->settings->branchname_loginemployee();
        $all_brancheemployee_list = DB::table('tb_employee')
        ->leftjoin('tb_departments','tb_employee.emp_department_id','=','tb_departments.id')
        ->leftjoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
        ->leftjoin('tb_branch','tb_employee.branch_id','=','tb_branch.id')
        ->select('tb_employee.id','tb_employee.emp_first_name','tb_employee.emp_lastName','tb_employee.emp_account_status','tb_employee.emp_photo','tb_employee.emp_card_number','tb_departments.department_name','tb_designations.designation_name','tb_employee.employeeId','tb_branch.branch_name')
        ->orderBy('tb_employee.id', 'ASC')
        ->where('tb_employee.branch_id', $branch_id->id)
        ->get();

          $path = asset('employee_image');
        //   $path = asset('vendor_image/'.$profile->photo);

        //   $path = asset('employee_image/profile_image.jpg');
         return response()->json([['all_brancheemployee_list' => $all_brancheemployee_list],['filepath'=>$path]], $this->successStatus);

    }


    public function department_employee($id){
        $path['link'] = asset('employee_image/');
        $settings = new Settings();
        $branch_id=$settings->get_login_branch_id();
        $query=DB::table('tb_employee')
             ->leftjoin('tb_departments','tb_employee.emp_department_id','=','tb_departments.id')
             ->leftjoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
             ->leftjoin('tb_branch','tb_employee.branch_id','=','tb_branch.id')
             ->where('tb_branch.id','=',$branch_id);

        if($id!='All'){
            $query=$query->where('tb_employee.emp_department_id','=',$id);
        }

        $employee=$query->orderBy('tb_employee.id', 'ASC')
            ->select('tb_employee.*','tb_departments.department_name','tb_designations.designation_name')
            ->get();

        return response()->json(['employee' => $employee,
            'filepath'=>$path
        ], $this->successStatus);
    }

    public function designation_employee($id){
        $path['link'] = asset('employee_image/');
        $settings = new Settings();
        $branch_id=$settings->get_login_branch_id();
        $query=DB::table('tb_employee')
            ->leftjoin('tb_departments','tb_employee.emp_department_id','=','tb_departments.id')
            ->leftjoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
            ->leftjoin('tb_branch','tb_employee.branch_id','=','tb_branch.id')
            ->where('tb_branch.id','=',$branch_id);

        if($id != 'All'){
            $query=$query->where('tb_employee.emp_designation_id','=',$id);
        }

        $employee=$query->orderBy('tb_employee.id', 'ASC')
            ->select('tb_employee.*','tb_departments.department_name','tb_designations.designation_name')
            ->get();

        return response()->json(['employee' => $employee,
            'filepath'=>$path
        ], $this->successStatus);
    }






    public function brancheallEmployee(Request $request){


        if($departmen =$request->dpid=='All' &&  $designation =$request->des=='All'){


        $employee_list = DB::table('tb_employee')
        ->leftjoin('tb_departments','tb_employee.emp_department_id','=','tb_departments.id')
        ->leftjoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
        ->leftjoin('tb_branch','tb_employee.branch_id','=','tb_branch.id')
        ->select('tb_employee.id','tb_employee.emp_first_name','tb_employee.emp_lastName','tb_employee.emp_account_status','tb_employee.emp_card_number','tb_departments.department_name','tb_designations.designation_name','tb_employee.employeeId','tb_branch.branch_name','tb_employee.emp_photo')
        ->where('tb_employee.branch_id', $branch_id)
        ->orderBy('tb_employee.id', 'ASC')
        ->get();

          $path['link']= asset('employee_image/');
         return response()->json(['employee' => $employee_list,
        'filepath'=>$path
        ], $this->successStatus);

        }

        if( $departmen =$request->dpid=='All'){

              if( $designation =$request->dpid==null){
                   $settings = new Settings();
                $branch_id=$settings->get_login_branch_id();
            $employee_list = DB::table('tb_employee')
            ->leftjoin('tb_departments','tb_employee.emp_department_id','=','tb_departments.id')
            ->leftjoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
            ->leftjoin('tb_branch','tb_employee.branch_id','=','tb_branch.id')
            ->select('tb_employee.id','tb_employee.emp_first_name','tb_employee.emp_lastName','tb_employee.emp_account_status','tb_employee.emp_card_number','tb_departments.department_name','tb_designations.designation_name','tb_employee.employeeId','tb_branch.branch_name','tb_employee.emp_photo')
            ->where('tb_employee.branch_id', $branch_id)
            ->orderBy('tb_employee.id', 'ASC')
            ->get();

            $path['link']= asset('employee_image/');
            return response()->json(['employee' => $employee_list,
            'filepath'=>$path
            ], $this->successStatus);
            }
            else{
                 $settings = new Settings();
                $branch_id=$settings->get_login_branch_id();
                 $dpid =$request->dpid;
                 $designation =$request->des;
                $employee_list = DB::table('tb_employee')
                ->leftjoin('tb_departments','tb_employee.emp_department_id','=','tb_departments.id')
                ->leftjoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
                ->leftjoin('tb_branch','tb_employee.branch_id','=','tb_branch.id')
                ->select('tb_employee.id','tb_employee.emp_first_name','tb_employee.emp_lastName','tb_employee.emp_account_status','tb_employee.emp_card_number','tb_departments.department_name','tb_designations.designation_name','tb_employee.employeeId','tb_branch.branch_name','tb_employee.emp_photo')
                ->where('tb_employee.branch_id', $branch_id)
                 ->where('tb_employee.emp_department_id', $dpid)
                 ->where('tb_employee.emp_department_id', $designation)
                ->orderBy('tb_employee.id', 'ASC')
                ->get();

                $path['link']= asset('employee_image/');
                return response()->json(['employee' => $employee_list,
                'filepath'=>$path
                ], $this->successStatus);
            }
        }

        if($dpid =$request->dpid=='All'){
             $settings = new Settings();
             $branch_id=$settings->get_login_branch_id();
            $designation =$request->des;
            $employee_list = DB::table('tb_employee')
            ->leftjoin('tb_departments','tb_employee.emp_department_id','=','tb_departments.id')
            ->leftjoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
            ->leftjoin('tb_branch','tb_employee.branch_id','=','tb_branch.id')
            ->select('tb_employee.id','tb_employee.emp_first_name','tb_employee.emp_lastName','tb_employee.emp_account_status','tb_employee.emp_card_number','tb_departments.department_name','tb_designations.designation_name','tb_employee.employeeId','tb_branch.branch_name','tb_employee.emp_photo')
             ->where('tb_employee.branch_id', $branch_id)
            ->where('tb_employee.emp_department_id', $designation)
            ->orderBy('tb_employee.id', 'ASC')
            ->get();
            $path['link']= asset('employee_image/');
                return response()->json(['employee' => $employee_list,
                'filepath'=>$path
                ], $this->successStatus);
        }else{
            $dpid =$request->dpid;
              $designation =$request->des;
               $settings = new Settings();
                $branch_id=$settings->get_login_branch_id();
            $employee_list = DB::table('tb_employee')
            ->leftjoin('tb_departments','tb_employee.emp_department_id','=','tb_departments.id')
            ->leftjoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
            ->leftjoin('tb_branch','tb_employee.branch_id','=','tb_branch.id')
            ->select('tb_employee.id','tb_employee.emp_first_name','tb_employee.emp_lastName','tb_employee.emp_account_status','tb_employee.emp_card_number','tb_departments.department_name','tb_designations.designation_name','tb_employee.employeeId','tb_branch.branch_name','tb_employee.emp_photo')
             ->where('tb_employee.branch_id', $branch_id)
             ->where('tb_employee.emp_department_id', $dpid)
              ->where('tb_employee.emp_department_id', $designation)
            ->orderBy('tb_employee.id', 'ASC')
            ->get();
            $path['link']= asset('employee_image/');
                return response()->json(['employee' => $employee_list,
                'filepath'=>$path
                ], $this->successStatus);
        }







    }

    public function brancheEmployeeProfile($id){

          $id = $id;
        $branch_list2=$this->settings->branchname_loginemployee();
        $branch=$this->settings->all_branch();
        $department=$this->settings->all_department();
        $designation=$this->settings->all_designation();
        $shift=$this->settings->all_shift();

        $settings = new Settings();
             $branch_id=$settings->get_login_branch_id();
        $employee_profile = DB::table('tb_employee')
            ->leftjoin('tb_departments','tb_employee.emp_department_id','=','tb_departments.id')
            ->leftjoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
            ->leftjoin('tb_branch','tb_employee.branch_id','=','tb_branch.id')
            ->leftjoin('tb_shift','tb_employee.emp_shift_id','=','tb_shift.id')
            ->select('tb_employee.id as emp_id','tb_employee.*','tb_departments.department_name','tb_designations.designation_name','tb_branch.branch_name','tb_shift.shift_name')
            ->where('tb_employee.id',$id)
            ->where('tb_employee.branch_id', $branch_id)
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
        // $leave=DB::select("select SUM(actual_days) as total_leave from `tb_leave_application` where `emp_id` = $id and `status` = 1 and (`leave_starting_date` between '$start' and '$now'  or `leave_ending_date` between '$start' and '$now') group by `emp_id`");
        // if(isset($leave[0]->total_leave)){
        //     $leave_total=$leave[0]->total_leave;
        // }
        // else{
        //     $leave_total=0;
        // }
        // $total=$this->settings->dayCalculator($start,Carbon::now()->toDateString());
        // $attendace = (object) [
        //     'month' => $month,
        //     'present' => $present,
        //     'leave' => $leave_total,
        //     'working_days'=>$total,
        // ];

        $current_salary=DB::table('tb_payroll_salary')
        ->where('tb_payroll_salary.emp_id',$id)
        ->leftjoin('tb_employee','tb_payroll_salary.emp_id','=','tb_employee.id')
        ->leftjoin('tb_salary_grade','tb_payroll_salary.grade_id','=','tb_salary_grade.id')
        ->select('tb_payroll_salary.*','tb_salary_grade.grade_name')
        ->get();

        return response()->json(
                [
                    'employee_profile' => $employee_profile,
                    //  'branch' => $branch,
                    //  'branch' => $branch,
                    //  'department' => $department,
                    //  'designation' => $designation,
                    //  'shift' => $shift,
                    //  'employee_education' => $employee_education,
                    //  'task_list' => $task_list,
                    // //  'attendace' => $attendace,
                    //  'current_salary' => $current_salary,
                    //  'branch_list2' => $branch_list2,
                ], $this->successStatus);
     }




         // ===================================== branchemanagerLeaveStatusPending ============================================
    public function branchemanagerLeaveStatusPending(Request $request){

        $settings = new Settings();
        $branch_id=$settings->get_login_branch_id();


            $leave_applicationpending = DB::table('tb_leave_application')
        ->leftJoin('tb_employee','tb_leave_application.emp_id','=','tb_employee.id')
        ->leftJoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
        ->leftJoin('tb_leave_type','tb_leave_application.leave_type_id','=','tb_leave_type.id')
        ->leftJoin('users','tb_leave_application.approved_by','=','users.id')
        ->select('tb_leave_application.id','tb_leave_application.unique_id','tb_employee.id as eid','tb_employee.employeeId',
            DB::raw("CONCAT(tb_employee.emp_first_name,' ',tb_employee.emp_lastName) as emp_name"),
            'tb_designations.designation_name','tb_leave_type.leave_type',
            DB::raw('MIN(tb_leave_application.leave_starting_date) as leave_starting_date'),
            DB::raw('MAX(tb_leave_application.leave_ending_date) as leave_ending_date'),
            DB::raw('SUM(actual_days) actual_days'),
            'users.name as approve_by',
            'tb_leave_application.status')
        ->groupBy('unique_id')
        ->where('tb_leave_application.status','=',0)
         ->where('tb_employee.branch_id',$branch_id)
        ->get();

         return response()->json(['leave_applicationpending' =>$leave_applicationpending], $this->successStatus);



    }

    // ===================================== End branchemanagerLeaveStatusPending ============================================






            // ===================================== branchemanagerLeaveStatusApproved ============================================
    public function branchemanagerLeaveStatusApproved(Request $request){

        $settings = new Settings();
        $branch_id=$settings->get_login_branch_id();

        $approvedleave_application = DB::table('tb_leave_application')
        ->leftJoin('tb_employee','tb_leave_application.emp_id','=','tb_employee.id')
        ->leftJoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
        ->leftJoin('tb_leave_type','tb_leave_application.leave_type_id','=','tb_leave_type.id')
        ->leftJoin('users','tb_leave_application.approved_by','=','users.id')
        ->select('tb_leave_application.id','tb_leave_application.unique_id','tb_employee.id as eid','tb_employee.employeeId',
            DB::raw("CONCAT(tb_employee.emp_first_name,' ',tb_employee.emp_lastName) as emp_name"),
            'tb_designations.designation_name','tb_leave_type.leave_type',
            DB::raw('MIN(tb_leave_application.leave_starting_date) as leave_starting_date'),
            DB::raw('MAX(tb_leave_application.leave_ending_date) as leave_ending_date'),
            DB::raw('SUM(actual_days) actual_days'),
            'users.name as approve_by',
            'tb_leave_application.status')
        ->groupBy('unique_id')
        ->where('tb_leave_application.status','=',1)
         ->where('tb_employee.branch_id',$branch_id)
        ->get();

         return response()->json(['approvedleave_application' =>$approvedleave_application], $this->successStatus);



    }

    // ===================================== End branchemanagerLeaveStatusApproved ============================================





    // ===================================== adminLeaveStatusReject ============================================

        public function  branchemanagerLeaveStatusReject(Request $request){

        $settings = new Settings();
        $branch_id=$settings->get_login_branch_id();
         $rejectleave_application = DB::table('tb_leave_application')
        ->leftJoin('tb_employee','tb_leave_application.emp_id','=','tb_employee.id')
        ->leftJoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
        ->leftJoin('tb_leave_type','tb_leave_application.leave_type_id','=','tb_leave_type.id')
        ->leftJoin('users','tb_leave_application.approved_by','=','users.id')
        ->select('tb_leave_application.id','tb_leave_application.unique_id','tb_employee.id as eid','tb_employee.employeeId',
            DB::raw("CONCAT(tb_employee.emp_first_name,' ',tb_employee.emp_lastName) as emp_name"),
            'tb_designations.designation_name','tb_leave_type.leave_type',
            DB::raw('MIN(tb_leave_application.leave_starting_date) as leave_starting_date'),
            DB::raw('MAX(tb_leave_application.leave_ending_date) as leave_ending_date'),
            DB::raw('SUM(actual_days) actual_days'),
            'users.name as approve_by',
            'tb_leave_application.status')
        ->groupBy('unique_id')
        ->where('tb_leave_application.status','=',2)
         ->where('tb_employee.branch_id',$branch_id)
        ->get();

         return response()->json(['rejectleave_application' =>$rejectleave_application], $this->successStatus);


    }

    // ===================================== End  adminLeaveStatusReject ============================================




     // =====================================  tb_leave_application ============================================
        public function leave_status_approve(Request $request){
             $leave_application =  DB::table('tb_leave_application')
                ->where('id',$request->id)
                ->update(
                    [
                        'status' =>1,
                        'approved_by'=>Auth::user()->id,
                    ]
                );

                 return response()->json(['success' => 'Leave Application been successfully Approved.']);
        }
    // =====================================  tb_leave_application ============================================



    // =====================================  tb_leave_application ============================================
        public function leave_status_rejected(Request $request){
             $leave_application =  DB::table('tb_leave_application')
                ->where('id',$request->id)
                ->update(
                    [
                        'status' =>2,
                        'approved_by'=>Auth::user()->id,
                    ]
                );

                 return response()->json(['success' => 'Leave Application been successfully Rejected.']);
        }
    // =====================================  tb_leave_application ============================================



      // ===================================== brancheClientList ============================================

      public function brancheClientList(Request $request){

        $settings = new Settings();
        $branch_id=$settings->get_login_branch_id();

            $client=DB::table('tb_clients')->where('branch_id',$branch_id)->get();


           return response()->json(['client' => $client], $this->successStatus);



    }
    // ===================================== End brancheClientList ============================================




       // ===================================== brancheclientProjectList ============================================
   public function brancheclientProjectList(Request $request){

          $settings = new Settings();
        $branch_id=$settings->get_login_branch_id();

        $client_project=DB::table('tb_project')->where('tb_project.branch_id',$branch_id)
        ->leftjoin('tb_clients','tb_project.client_id','=','tb_clients.id')
        ->select('tb_project.*','tb_clients.*')
        ->get();


           return response()->json(['client_project' => $client_project], $this->successStatus);


    }

    // ===================================== End brancheclientProjectList ============================================





    // ===================================== branchannouncementList ============================================

       public function branchannouncementList(Request $request){

         $settings = new Settings();
        $branch_id=$settings->get_login_branch_id();

           $announcement_list=DB::table('tb_announcement')
            ->leftJoin('tb_branch','tb_announcement.branch_id','=','tb_branch.id')
            ->select('tb_announcement.*','tb_branch.branch_name')
            ->where('tb_announcement.branch_id',$branch_id)
            ->orWhere('tb_announcement.branch_id', 0)

            ->get();

         return response()->json([
             'announcement_list' => $announcement_list,
            ], $this->successStatus);

    }
    // ===================================== End branchannouncementList ============================================




    // ===================================== adminMeetingList ============================================

    public function branchMeetingList(Request $request){


                $settings = new Settings();
                 $branch_id=$settings->get_login_branch_id();

            $meeting_list = DB::table('tb_meetings')
            ->leftJoin('users','tb_meetings.created_by','=','users.id')
            ->leftJoin('tb_branch','tb_meetings.branch_id','=','tb_branch.id')
            ->select('tb_meetings.*','users.name','tb_branch.branch_name')
            ->where('tb_meetings.branch_id', $branch_id)
            ->get();

         return response()->json([
             'meeting_list' => $meeting_list,
            ], $this->successStatus);


    }

    // ===================================== End adminMeetingList ============================================


      // =====================================  individual_attendance  ===========================================


    public function individual_attendance(){
            return response()->json([
             'ok' => 'ok'
            ], $this->successStatus);
    }

    // ===================================== End individual_attendance  ============================================

        public function get_login_branch_name(){
             $settings = new Settings();
            $branch_id=$settings->employeeBranch();
            return response()->json([
             'branch_id' => $branch_id
            ], $this->successStatus);
        }

        // =====================================  employeeWiseExpanseHistoryMonthly ============================================
     public function brancemployeeWiseExpanseHistoryMonthly(Request $request)
    {
        $a =$request->startdate;
        $b =$request->enddate;
        $from = date($a);
        $to = date($b);
        $settings = new Settings();
        $branch_id=$settings->get_login_branch_id();



             $expanse_list = DB::table('tb_expanse')
        ->leftJoin('users','tb_expanse.created_by','=','users.id')
        ->leftJoin('tb_employee','tb_employee.id','=','users.emp_id')
        ->leftjoin('tb_departments','tb_employee.emp_department_id','=','tb_departments.id')
        ->leftjoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
        ->leftjoin('tb_branch','tb_employee.branch_id','=','tb_branch.id')
        ->leftJoin('tb_expanse_category','tb_expanse.category_id','=','tb_expanse_category.id')
        // ->select('tb_expanse.*','tb_employee.emp_first_name','tb_employee.emp_lastName','tb_employee.employeeId','users.name','tb_expanse_category.category_name','tb_branch.branch_name', DB::raw('SUM(tb_expanse.amount) as totAmount'))
        ->select('tb_expanse.*','tb_employee.emp_first_name','tb_employee.emp_lastName','tb_employee.employeeId','users.name','tb_expanse_category.category_name','tb_branch.branch_name')
        ->whereBetween('tb_expanse.expanse_date', [$from, $to])
        ->where('tb_employee.branch_id','=',$branch_id)
        ->where('tb_expanse.status','=',1)
        // ->where('tb_employee.branch_id','=',$request->id)
        // ->groupBy(DB::raw("MONTH(tb_expanse.expanse_date)"),DB::raw("YEAR(tb_expanse.expanse_date)"))
        ->orderBy('tb_expanse.expanse_date', 'desc')
        ->get();

        return response()->json([
             'expanse_list' => $expanse_list
            ], $this->successStatus);


    }
    // ===================================== End  employeeWiseExpanseHistoryMonthly ============================================



      public function employeeWiseExpanseHistoryMonthlyDetails(Request $request)
    {
        $a =$request->startdate;
        $b =$request->enddate;
        $from = date($a);
        $to = date($b);
        $emp_id = $request->emp_id;

        //   $year_month=Carbon::parse($request->salary_month)->toDateString();
         $dateexpanse_list = DB::table('tb_expanse')
        ->leftJoin('users','tb_expanse.created_by','=','users.id')
        ->leftJoin('tb_employee','tb_employee.id','=','users.emp_id')
        ->leftjoin('tb_departments','tb_employee.emp_department_id','=','tb_departments.id')
        ->leftjoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
        ->leftjoin('tb_branch','tb_employee.branch_id','=','tb_branch.id')
        ->leftJoin('tb_expanse_category','tb_expanse.category_id','=','tb_expanse_category.id')
        ->whereBetween('tb_expanse.expanse_date', [$from, $to])
        ->where('tb_expanse.created_by','=',$emp_id)
        ->where('tb_expanse.status','=',1)
        ->select('tb_expanse.id','tb_expanse.created_by','tb_expanse.amount','tb_expanse.expanse_date','tb_expanse.status','tb_expanse.attachment','users.name','tb_employee.emp_first_name','tb_employee.emp_lastName','tb_departments.department_name','tb_designations.designation_name','tb_employee.employeeId','tb_branch.branch_name','tb_expanse_category.category_name')
        // ->select('tb_expanse.id','tb_expanse.created_by','tb_expanse.amount','tb_expanse.expanse_date','tb_expanse.status','tb_expanse.attachment','users.name','tb_employee.emp_first_name','tb_employee.emp_lastName','tb_departments.department_name','tb_designations.designation_name','tb_employee.employeeId','tb_branch.branch_name','tb_expanse_category.category_name', DB::raw('SUM(tb_expanse.amount) as totAmount'))
        // ->groupBy('tb_expanse.created_by')
        ->orderBy('tb_expanse.expanse_date', 'desc')
        ->get();
         return response()->json([
             'dateexpanse_list' => $dateexpanse_list
            ], $this->successStatus);
    }
    // ===================================== End employeeWiseExpanseHistoryMonthlyDetails ============================================





        // =====================================  empSalaryList ============================================

     public function empSalaryList(Request $request)
    {






        if(  $departmen =$request->dpid=='All' &&  $designation =$request->des=='All'){
              $settings = new Settings();
                $branch_id=$settings->get_login_branch_id();
            $emp_salary_list = DB::table('tb_payroll_salary')->orderBy('tb_payroll_salary.id', 'desc')
            ->leftJoin('tb_employee','tb_payroll_salary.emp_id','=','tb_employee.id')
            ->leftjoin('tb_departments','tb_employee.emp_department_id','=','tb_departments.id')
            ->leftjoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
            ->leftJoin('tb_salary_grade','tb_payroll_salary.grade_id','=','tb_salary_grade.id')
             ->where('tb_employee.branch_id', $branch_id)
            ->select('tb_payroll_salary.id','tb_employee.employeeId','tb_departments.department_name','tb_designations.designation_name','tb_employee.emp_photo',
                DB::raw("CONCAT(tb_employee.emp_first_name,' ',tb_employee.emp_lastName) as emp_name"),
                'tb_salary_grade.grade_name','tb_payroll_salary.basic_salary','tb_payroll_salary.total_salary',
                'tb_payroll_salary.provident_fund_percent','tb_payroll_salary.provident_fund_amount'
            )
            ->get();

            $path['link']= asset('employee_image/');
            return response()->json([
             'emp_salary_list' => $emp_salary_list,
             'filepath'=>$path,
            ], $this->successStatus);

        }


        if( $departmen =$request->dpid=='All'){

              if( $designation =$request->des==null){
                  $settings = new Settings();
                $branch_id=$settings->get_login_branch_id();
                $emp_salary_list = DB::table('tb_payroll_salary')->orderBy('tb_payroll_salary.id', 'desc')
                ->leftJoin('tb_employee','tb_payroll_salary.emp_id','=','tb_employee.id')
                ->leftjoin('tb_departments','tb_employee.emp_department_id','=','tb_departments.id')
                ->leftjoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
                ->leftJoin('tb_salary_grade','tb_payroll_salary.grade_id','=','tb_salary_grade.id')
                 ->where('tb_employee.branch_id', $branch_id)
                ->select('tb_payroll_salary.id','tb_employee.employeeId','tb_departments.department_name','tb_designations.designation_name','tb_employee.emp_photo',
                    DB::raw("CONCAT(tb_employee.emp_first_name,' ',tb_employee.emp_lastName) as emp_name"),
                    'tb_salary_grade.grade_name','tb_payroll_salary.basic_salary','tb_payroll_salary.total_salary',
                    'tb_payroll_salary.provident_fund_percent','tb_payroll_salary.provident_fund_amount'
                )
            ->get();

            $path['link']= asset('employee_image/');
            return response()->json([
             'emp_salary_list' => $emp_salary_list,
             'filepath'=>$path,
            ], $this->successStatus);
        }else{
           $designation =$request->des;
            $dpid =$request->dpid;

            $settings = new Settings();
                $branch_id=$settings->get_login_branch_id();
              $emp_salary_list = DB::table('tb_payroll_salary')->orderBy('tb_payroll_salary.id', 'desc')
            ->leftJoin('tb_employee','tb_payroll_salary.emp_id','=','tb_employee.id')
            ->leftjoin('tb_departments','tb_employee.emp_department_id','=','tb_departments.id')
            ->leftjoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
            ->leftJoin('tb_salary_grade','tb_payroll_salary.grade_id','=','tb_salary_grade.id')
            // ->where('tb_payroll_salary.emp_id','=',$request->emp_id)
            ->where('tb_employee.branch_id', $branch_id)
             ->where('tb_employee.emp_department_id', $dpid)
             ->where('tb_employee.emp_department_id', $designation)
            ->select('tb_payroll_salary.id','tb_employee.employeeId','tb_departments.department_name','tb_designations.designation_name','tb_employee.emp_photo',
                DB::raw("CONCAT(tb_employee.emp_first_name,' ',tb_employee.emp_lastName) as emp_name"),
                'tb_salary_grade.grade_name','tb_payroll_salary.basic_salary','tb_payroll_salary.total_salary',
                'tb_payroll_salary.provident_fund_percent','tb_payroll_salary.provident_fund_amount'
            )
            ->get();

            $path['link']= asset('employee_image/');
            return response()->json([
             'emp_salary_list' => $emp_salary_list,
             'filepath'=>$path,
            ], $this->successStatus);
        }

        }


        if($designation =$request->des=='All'){

            $dpid =$request->dpid;

            $settings = new Settings();
                $branch_id=$settings->get_login_branch_id();

              $emp_salary_list = DB::table('tb_payroll_salary')->orderBy('tb_payroll_salary.id', 'desc')
            ->leftJoin('tb_employee','tb_payroll_salary.emp_id','=','tb_employee.id')
            ->leftjoin('tb_departments','tb_employee.emp_department_id','=','tb_departments.id')
            ->leftjoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
            ->leftJoin('tb_salary_grade','tb_payroll_salary.grade_id','=','tb_salary_grade.id')
            // ->where('tb_payroll_salary.emp_id','=',$request->emp_id)

             ->where('tb_employee.emp_department_id', $dpid)
             ->where('tb_employee.branch_id', $branch_id)
            ->select('tb_payroll_salary.id','tb_employee.employeeId','tb_departments.department_name','tb_designations.designation_name','tb_employee.emp_photo',
                DB::raw("CONCAT(tb_employee.emp_first_name,' ',tb_employee.emp_lastName) as emp_name"),
                'tb_salary_grade.grade_name','tb_payroll_salary.basic_salary','tb_payroll_salary.total_salary',
                'tb_payroll_salary.provident_fund_percent','tb_payroll_salary.provident_fund_amount'
            )
            ->get();

            $path['link']= asset('employee_image/');
            return response()->json([
             'emp_salary_list' => $emp_salary_list,
             'filepath'=>$path,
            ], $this->successStatus);

        }else{
            $dpid =$request->dpid;
            $designation =$request->des;

            $settings = new Settings();
                $branch_id=$settings->get_login_branch_id();

              $emp_salary_list = DB::table('tb_payroll_salary')->orderBy('tb_payroll_salary.id', 'desc')
            ->leftJoin('tb_employee','tb_payroll_salary.emp_id','=','tb_employee.id')
            ->leftjoin('tb_departments','tb_employee.emp_department_id','=','tb_departments.id')
            ->leftjoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
            ->leftJoin('tb_salary_grade','tb_payroll_salary.grade_id','=','tb_salary_grade.id')
            // ->where('tb_payroll_salary.emp_id','=',$request->emp_id)

            ->where('tb_employee.branch_id', $branch_id)
             ->where('tb_employee.emp_department_id', $dpid)
             ->where('tb_employee.emp_department_id', $designation)

            ->select('tb_payroll_salary.id','tb_employee.employeeId','tb_departments.department_name','tb_designations.designation_name','tb_employee.emp_photo',
                DB::raw("CONCAT(tb_employee.emp_first_name,' ',tb_employee.emp_lastName) as emp_name"),
                'tb_salary_grade.grade_name','tb_payroll_salary.basic_salary','tb_payroll_salary.total_salary',
                'tb_payroll_salary.provident_fund_percent','tb_payroll_salary.provident_fund_amount'
            )
            ->get();

            $path['link']= asset('employee_image/');
            return response()->json([
             'emp_salary_list' => $emp_salary_list,
             'filepath'=>$path,
            ], $this->successStatus);
        }

    }

    // ===================================== End  empSalaryList ============================================










}
