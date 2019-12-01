<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\DB;
use Validator;
use Carbon\Carbon;
use App\Repositories\Settings;

class adminPanelController extends Controller
{
    protected $settings;

    public function __construct()
    {
        // create object of settings class
        $this->settings = new Settings();
    }

    public $successStatus = 200;


    // ===================================== adminallEmployee ============================================


    public function employee_branch($id){
//        return $id;
        $employee_list = DB::table('tb_employee')
            ->leftjoin('tb_departments','tb_employee.emp_department_id','=','tb_departments.id')
            ->leftjoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
            ->leftjoin('tb_branch','tb_employee.branch_id','=','tb_branch.id')
            ->select('tb_employee.id','tb_employee.emp_first_name','tb_employee.emp_lastName','tb_employee.emp_account_status','tb_employee.emp_card_number','tb_departments.department_name','tb_designations.designation_name','tb_employee.employeeId','tb_branch.branch_name','tb_employee.emp_photo')
            ->orderBy('tb_employee.id', 'ASC');
        if($id!="All"){
            $employee_list=$employee_list->where('tb_employee.branch_id','=',$id);
        }
        $employee_list=$employee_list->get();


        $path['link']= asset('employee_image/');
        return response()->json(['employee' => $employee_list,
            'filepath'=>$path
        ], $this->successStatus);
    }

    public function adminallEmployee(Request $request){


        if( $branch_id =$request->id=='All' && $dpid =$request->dpid=='All'){

            $employee_list = DB::table('tb_employee')
            ->leftjoin('tb_departments','tb_employee.emp_department_id','=','tb_departments.id')
            ->leftjoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
            ->leftjoin('tb_branch','tb_employee.branch_id','=','tb_branch.id')
            ->select('tb_employee.id','tb_employee.emp_first_name','tb_employee.emp_lastName','tb_employee.emp_account_status','tb_employee.emp_card_number','tb_departments.department_name','tb_designations.designation_name','tb_employee.employeeId','tb_branch.branch_name','tb_employee.emp_photo')

            ->orderBy('tb_employee.id', 'ASC')
            ->get();

              $path['link']= asset('employee_image/');
             return response()->json(['employee' => $employee_list,
            'filepath'=>$path
            ], $this->successStatus);

        }

        if( $branch_id =$request->id=='All'){

              if( $designation =$request->dpid==null){
            $employee_list = DB::table('tb_employee')
            ->leftjoin('tb_departments','tb_employee.emp_department_id','=','tb_departments.id')
            ->leftjoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
            ->leftjoin('tb_branch','tb_employee.branch_id','=','tb_branch.id')
            ->select('tb_employee.id','tb_employee.emp_first_name','tb_employee.emp_lastName','tb_employee.emp_account_status','tb_employee.emp_card_number','tb_departments.department_name','tb_designations.designation_name','tb_employee.employeeId','tb_branch.branch_name','tb_employee.emp_photo')
            ->orderBy('tb_employee.id', 'ASC')
            ->get();

            $path['link']= asset('employee_image/');
            return response()->json(['employee' => $employee_list,
            'filepath'=>$path
            ], $this->successStatus);
            }
            else{
                 $dpid =$request->dpid;
                $employee_list = DB::table('tb_employee')
                ->leftjoin('tb_departments','tb_employee.emp_department_id','=','tb_departments.id')
                ->leftjoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
                ->leftjoin('tb_branch','tb_employee.branch_id','=','tb_branch.id')
                ->select('tb_employee.id','tb_employee.emp_first_name','tb_employee.emp_lastName','tb_employee.emp_account_status','tb_employee.emp_card_number','tb_departments.department_name','tb_designations.designation_name','tb_employee.employeeId','tb_branch.branch_name','tb_employee.emp_photo')
                 ->where('tb_employee.emp_department_id', $dpid)
                ->orderBy('tb_employee.id', 'ASC')
                ->get();

                $path['link']= asset('employee_image/');
                return response()->json(['employee' => $employee_list,
                'filepath'=>$path
                ], $this->successStatus);
            }
        }

        if($dpid =$request->dpid=='All'){
            $branch_id =$request->id;
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
        }else{
            $dpid =$request->dpid;
              $branch_id =$request->id;
            $employee_list = DB::table('tb_employee')
            ->leftjoin('tb_departments','tb_employee.emp_department_id','=','tb_departments.id')
            ->leftjoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
            ->leftjoin('tb_branch','tb_employee.branch_id','=','tb_branch.id')
            ->select('tb_employee.id','tb_employee.emp_first_name','tb_employee.emp_lastName','tb_employee.emp_account_status','tb_employee.emp_card_number','tb_departments.department_name','tb_designations.designation_name','tb_employee.employeeId','tb_branch.branch_name','tb_employee.emp_photo')
             ->where('tb_employee.branch_id', $branch_id)
             ->where('tb_employee.emp_department_id', $dpid)
            ->orderBy('tb_employee.id', 'ASC')
            ->get();
            $path['link']= asset('employee_image/');
                return response()->json(['employee' => $employee_list,
                'filepath'=>$path
                ], $this->successStatus);
        }







    }





       public function admindesignationallEmployee(Request $request){

        if( $branch_id =$request->id=='All' && $designationid =$request->designationid=='All'){

         $employee_list = DB::table('tb_employee')
        ->leftjoin('tb_departments','tb_employee.emp_department_id','=','tb_departments.id')
        ->leftjoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
        ->leftjoin('tb_branch','tb_employee.branch_id','=','tb_branch.id')
        ->select('tb_employee.id','tb_employee.emp_first_name','tb_employee.emp_lastName','tb_employee.emp_account_status','tb_employee.emp_card_number','tb_departments.department_name','tb_designations.designation_name','tb_employee.employeeId','tb_branch.branch_name','tb_employee.emp_photo')
        //  ->where('tb_employee.branch_id', $branch_id)
        ->orderBy('tb_employee.id', 'ASC')
        ->get();

          $path['link']= asset('employee_image/');
         return response()->json(['employee' => $employee_list,
        'filepath'=>$path
        ], $this->successStatus);

        }

        if($request->id=='All'){

            if( $designationid =$request->designationid==null){
            $employee_list = DB::table('tb_employee')
            ->leftjoin('tb_departments','tb_employee.emp_department_id','=','tb_departments.id')
            ->leftjoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
            ->leftjoin('tb_branch','tb_employee.branch_id','=','tb_branch.id')
            ->select('tb_employee.id','tb_employee.emp_first_name','tb_employee.emp_lastName','tb_employee.emp_account_status','tb_employee.emp_card_number','tb_departments.department_name','tb_designations.designation_name','tb_employee.employeeId','tb_branch.branch_name','tb_employee.emp_photo')
            ->orderBy('tb_employee.id', 'ASC')
            ->get();

            $path['link']= asset('employee_image/');
            return response()->json(['employee' => $employee_list,
            'filepath'=>$path
            ], $this->successStatus);
            }
            else{
                 $designationid =$request->designationid;
                $employee_list = DB::table('tb_employee')
                ->leftjoin('tb_departments','tb_employee.emp_department_id','=','tb_departments.id')
                ->leftjoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
                ->leftjoin('tb_branch','tb_employee.branch_id','=','tb_branch.id')
                ->select('tb_employee.id','tb_employee.emp_first_name','tb_employee.emp_lastName','tb_employee.emp_account_status','tb_employee.emp_card_number','tb_departments.department_name','tb_designations.designation_name','tb_employee.employeeId','tb_branch.branch_name','tb_employee.emp_photo')
                 ->where('tb_employee.emp_designation_id', $designationid)
                ->orderBy('tb_employee.id', 'ASC')
                ->get();

                $path['link']= asset('employee_image/');
                return response()->json(['employee' => $employee_list,
                'filepath'=>$path
                ], $this->successStatus);
            }
        }


          if($designationid =$request->designationid=='All'){
            $branch_id =$request->id;
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
        }else{
            $designationid =$request->designationid;
              $branch_id =$request->id;
            $employee_list = DB::table('tb_employee')
            ->leftjoin('tb_departments','tb_employee.emp_department_id','=','tb_departments.id')
            ->leftjoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
            ->leftjoin('tb_branch','tb_employee.branch_id','=','tb_branch.id')
            ->select('tb_employee.id','tb_employee.emp_first_name','tb_employee.emp_lastName','tb_employee.emp_account_status','tb_employee.emp_card_number','tb_departments.department_name','tb_designations.designation_name','tb_employee.employeeId','tb_branch.branch_name','tb_employee.emp_photo')
             ->where('tb_employee.branch_id', $branch_id)
             ->where('tb_employee.emp_designation_id', $designationid)
            ->orderBy('tb_employee.id', 'ASC')
            ->get();
            $path['link']= asset('employee_image/');
                return response()->json(['employee' => $employee_list,
                'filepath'=>$path
                ], $this->successStatus);
        }




    }
    // ===================================== End adminallEmployee ============================================



    // ===================================== adminemployee_profile ============================================

     public function adminEmployeeProfile($id){

          $id = $id;
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
            ->select('tb_employee.id as emp_id','tb_employee.*','tb_departments.department_name','tb_designations.designation_name','tb_branch.branch_name','tb_shift.shift_name','tb_employee.emp_photo')
            ->where('tb_employee.id',$id)
            ->first();
            $path['link']= asset('employee_image/');
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
                    'path' => $path,
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


    // ===================================== End adminemployee_profile ============================================



    // ===================================== adminannouncementList ============================================

       public function adminannouncementList(Request $request){

     if($request->id == 'All'){
          $announcement_list=DB::table('tb_announcement')
            ->leftJoin('tb_branch','tb_announcement.branch_id','=','tb_branch.id')
            ->select('tb_announcement.*','tb_branch.branch_name')

            ->get();

         return response()->json([
             'announcement_list' => $announcement_list,
            ], $this->successStatus);
     }else{
           $announcement_list=DB::table('tb_announcement')
            ->leftJoin('tb_branch','tb_announcement.branch_id','=','tb_branch.id')
            ->select('tb_announcement.*','tb_branch.branch_name')
            ->where('tb_announcement.branch_id',$request->id)
            ->orWhere('tb_announcement.branch_id', 0)
            ->get();

         return response()->json([
             'announcement_list' => $announcement_list,
            ], $this->successStatus);
     }

    }
    // ===================================== End adminannouncementList ============================================



    // ===================================== adminclientList ============================================

      public function adminClientList(Request $request){
        if($request->id=='All'){
              $company=$this->settings->companyInformation();
            $client=DB::table('tb_clients')->get();


           return response()->json(['client' => $client], $this->successStatus);
        }else{
              $company=$this->settings->companyInformation();
            $client=DB::table('tb_clients')->where('branch_id',$request->id)->get();


           return response()->json(['client' => $client], $this->successStatus);
        }


    }
    // ===================================== End adminclientList ============================================


    // ===================================== adminclientProjectList ============================================
   public function adminclientProjectList(Request $request){
      if($request->id =="All"){

        $client_project=DB::table('tb_project')
        ->leftjoin('tb_clients','tb_project.client_id','=','tb_clients.id')
        ->select('tb_project.*','tb_clients.*')
        ->get();


           return response()->json(['client_project' => $client_project], $this->successStatus);

      }else{


        $client_project=DB::table('tb_project')->where('tb_project.branch_id',$request->id)
        ->leftjoin('tb_clients','tb_project.client_id','=','tb_clients.id')
        ->select('tb_project.*','tb_clients.*')
        ->get();


           return response()->json(['client_project' => $client_project], $this->successStatus);
      }

    }

    // ===================================== End adminclientProjectList ============================================




    // ===================================== adminDashboard ============================================
     public function adminDashboard(){

         // ===================================== employee_list ============================================
         $employee_list = DB::table('tb_employee')->count();
         // ===================================== end employee_list ============================================

         // ===================================== active_employee_list ============================================
         $active_employee_list = DB::table('tb_employee')->where('emp_account_status', '=', '1')->count();
         // ===================================== end active_employee_list ============================================

         // ===================================== inactive_employee_list ============================================
         $inactive_employee_list = DB::table('tb_employee')->where('emp_account_status', '=', '0')->count();
         // ===================================== end inactive_employee_list ============================================

         // ===================================== active_male_employee_list ============================================
         $active_male_employee_list = DB::table('tb_employee')->where([['emp_account_status', '=', '1'], ['emp_gender_id', '=', '1']])->count();
         // ===================================== End active_male_employee_list ============================================

         // ===================================== active_female_employee_list ============================================
         $active_female_employee_list = DB::table('tb_employee')->where([['emp_account_status', '=', '1'], ['emp_gender_id', '=', '2']])->count();
         // ===================================== End active_female_employee_list ============================================

         // ===================================== favourites_employee ============================================
         $favourites_employee = DB::table('tb_favourites')->count();
         // ===================================== End favourites_employee ============================================

         // ===================================== employee_group ============================================
         $employee_group = DB::table('tb_groups')->count();
         // ===================================== End employee_group ============================================

         // ===================================== branch ============================================
         $branch = DB::table('tb_branch')->count();
         // ===================================== End branch ============================================

         // ===================================== designations ============================================
          $designations = DB::table('tb_designations')->count();
         // ===================================== End designations ============================================

         // ===================================== departments ============================================
          $departments = DB::table('tb_departments')->count();
         // ===================================== End departments ============================================

         // ===================================== clients ============================================
          $clients = DB::table('tb_clients')->count();
         // ===================================== End clients ============================================

         // ===================================== projects ============================================
          $projects = DB::table('tb_project')->count();
         // ===================================== End projects ============================================

         // ===================================== training ============================================
             $training = DB::table('tb_training')->count();
         // ===================================== End training ============================================

         // ===================================== training ============================================
              $shift = DB::table('tb_shift')->count();
         // ===================================== End training ============================================




        $today_attendance = DB::table('tb_attendance')->where('attendance_date', date('Y-m-d'))->count();


        // absent not working
         $queryLeave=DB::table('tb_employee')
                ->leftJoin('tb_departments', 'tb_employee.emp_department_id', '=', 'tb_departments.id')
                ->leftJoin('tb_designations', 'tb_employee.emp_designation_id', '=', 'tb_designations.id')
                ->leftJoin('tb_shift', 'tb_employee.emp_shift_id', '=', 'tb_shift.id')
                ->leftJoin('tb_branch', 'tb_employee.branch_id', '=', 'tb_branch.id')
                ->join('tb_leave_application', 'tb_employee.id', '=', 'tb_leave_application.emp_id')
                ->where("tb_leave_application.leave_starting_date",'<=', date('Y-m-d'))
                ->where("tb_leave_application.leave_ending_date",'>=', date('Y-m-d'))->count();

        $absent = $active_employee_list - $today_attendance-$queryLeave ;


         $leate=DB::table('tb_employee')
                ->leftJoin('tb_departments','tb_employee.emp_department_id','=','tb_departments.id')
                ->leftJoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
                ->leftJoin('tb_shift','tb_employee.emp_shift_id','=','tb_shift.id')
                ->leftJoin('tb_branch','tb_employee.branch_id','=','tb_branch.id')
                ->join('tb_attendance','tb_employee.id','=','tb_attendance.emp_id')
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


    // ===================================== adminMeetingList ============================================

    public function adminMeetingList(Request $request){
        if($request->id == 'All'){
            $meeting_list = DB::table('tb_meetings')
            ->leftJoin('users','tb_meetings.created_by','=','users.id')
            ->leftJoin('tb_branch','tb_meetings.branch_id','=','tb_branch.id')
            ->select('tb_meetings.*','users.name','tb_branch.branch_name')
            ->get();

         return response()->json([
             'meeting_list' => $meeting_list,
            ], $this->successStatus);
        }else{
            $meeting_list = DB::table('tb_meetings')
            ->leftJoin('users','tb_meetings.created_by','=','users.id')
            ->leftJoin('tb_branch','tb_meetings.branch_id','=','tb_branch.id')
            ->select('tb_meetings.*','users.name','tb_branch.branch_name')
            ->where('tb_meetings.branch_id',$request->id)
            ->get();

         return response()->json([
             'meeting_list' => $meeting_list,
            ], $this->successStatus);
        }

    }

    // ===================================== End adminMeetingList ============================================




    // ===================================== adminLeave_statusPending ============================================
    public function adminLeaveStatusPending(Request $request){




        if($request->id == 'All'){
            $leave_application = DB::table('tb_leave_application')
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
        ->where('tb_leave_application.status','=',0)
        ->groupBy('unique_id')
        ->get();

         return response()->json(['leave_application' =>$leave_application], $this->successStatus);
        }else{
            $leave_application = DB::table('tb_leave_application')
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
         ->where('tb_employee.branch_id',$request->id)
        ->get();

         return response()->json(['leave_application' =>$leave_application], $this->successStatus);
        }


    }

    // ===================================== End adminLeave_statusPending ============================================


        // ===================================== adminLeaveStatusApproved ============================================
    public function adminLeaveStatusApproved(Request $request){

         if($request->id == 'All'){
            $leave_application = DB::table('tb_leave_application')
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
        ->where('tb_leave_application.status','=',1)
        ->groupBy('unique_id')
        ->get();

         return response()->json(['leave_application' =>$leave_application], $this->successStatus);
        }else{
            $leave_application = DB::table('tb_leave_application')
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
         ->where('tb_employee.branch_id',$request->id)
        ->get();

         return response()->json(['leave_application' =>$leave_application], $this->successStatus);
        }


    }

    // ===================================== End adminLeaveStatusApproved ============================================


    // ===================================== adminLeaveStatusReject ============================================

        public function adminLeaveStatusReject(Request $request){

          if($request->id == 'All'){
            $leave_application = DB::table('tb_leave_application')
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
            ->where('tb_leave_application.status','=',2)
            ->groupBy('unique_id')
            ->get();

            return response()->json(['leave_application' =>$leave_application], $this->successStatus);
        }else{
            $leave_application = DB::table('tb_leave_application')
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
         ->where('tb_employee.branch_id',$request->id)
        ->get();

         return response()->json(['leave_application' =>$leave_application], $this->successStatus);
        }

    }

    // ===================================== End  adminLeaveStatusReject ============================================


    // ===================================== End  individual_attendance_report_data ============================================

     public function adminindIvidualAttendanceReportData($emp_id, Request $request){
         $start = $request->start_date;
         $end = $request->end_date;

         $sdate = date_create($start);
         $edate = date_create($end);
         $start_date = date_format($sdate, "Y-m-d");
         $end_date = date_format($edate, "Y-m-d");
         $festivalLeave = DB::table('tb_festival_leave')->get();
         $weekendLeave=DB::table('tb_week_leave')->where('status','=',1)->get();
         $approvedLeave = DB::table('tb_leave_application')
             ->leftJoin('tb_leave_type','tb_leave_application.leave_type_id','=','tb_leave_type.id')
             ->where(['emp_id' => $emp_id, 'tb_leave_application.status' => 1])
             ->select('tb_leave_application.*','tb_leave_type.leave_type')
             ->get();
         $datas = [];

         for ($i = Carbon::createFromFormat('Y-m-d', $start_date); $i->lte(Carbon::createFromFormat('Y-m-d', $end_date)); $i->addDay(1)) {
             $key=0;
             $weekend=0;
             $fes=0;
             $lev=0;
             $dates = $i->format('Y-m-d');
             $timestamp = strtotime($dates);

             $day = date('l', $timestamp);
             foreach ($festivalLeave as $fe){
                 $fesDayStart=strtotime($fe->start_date);
                 $fesDayEnd=strtotime($fe->end_date);
                 if($timestamp >=$fesDayStart && $timestamp<=$fesDayEnd){
                     $fes=1;
                     break;
                 }

             }
             foreach ($weekendLeave as $wl){
                 if($wl->day==$day){
                     $weekend=1;
                 }
             }
             foreach ($approvedLeave as $al){
                 if($timestamp >=strtotime($al->leave_starting_date) && $timestamp<=strtotime($al->leave_ending_date))
                 {
                     $lev=1;
                     $leave_name=$al->leave_type;
                     break;
                 }
             }

             if($key=1) {
                 if ($fes != 1) {
                     if($weekend!=1) {
                         if ($lev != 1) {
                             $data = collect(DB::select("SELECT tb_employee.id, tb_employee.emp_first_name, tb_employee.emp_lastName, tb_employee.emp_joining_date, tb_employee.employeeId,tb_designations.designation_name, tb_departments.department_name, tb_attendance.attendance_date, 'Present' as status  from 
                                `tb_attendance` inner join `tb_employee` on `tb_attendance`.`emp_id` = `tb_employee`.`id` inner join `tb_departments` on `tb_employee`.`emp_department_id` = `tb_departments`.`id` inner join `tb_designations` on `tb_employee`.`emp_designation_id` = `tb_designations`.`id` where tb_employee.id =" . $emp_id . " and attendance_date='$dates'"))->first();
                             if(isset($data)){
                                 $datas[] = $data;


                             }
                              else {
                                 $sql = "SELECT tb_employee.id,tb_employee.emp_first_name, tb_employee.emp_lastName, tb_employee.emp_joining_date, tb_employee.emp_lastName, tb_employee.date_of_discontinuation,
                                tb_employee.employeeId, tb_designations.designation_name, tb_departments.department_name, '$dates' as attendance_date, 'Absent' as status FROM tb_employee inner join `tb_departments` on `tb_employee`.`emp_department_id` = `tb_departments`.`id`
                                inner join `tb_designations` on `tb_employee`.`emp_designation_id` = `tb_designations`.`id` where tb_employee.id = $emp_id ";
                                 $data = collect(DB::select($sql))->first();

                                 $datas[] = $data;

                             }
                         }
                         else {
                             $sql = "SELECT tb_employee.id,tb_employee.emp_first_name, tb_employee.emp_lastName, tb_employee.emp_joining_date, tb_employee.emp_lastName, tb_employee.date_of_discontinuation,
                                tb_employee.employeeId, tb_designations.designation_name, tb_departments.department_name, '$dates' as attendance_date, 'On Leave' as status, '$leave_name' as leave_type FROM tb_employee inner join `tb_departments` on `tb_employee`.`emp_department_id` = `tb_departments`.`id`
                                inner join `tb_designations` on `tb_employee`.`emp_designation_id` = `tb_designations`.`id` where tb_employee.id = $emp_id ";
                             $data = collect(DB::select($sql))->first();

                             $datas[] = $data;


                         }
                    }
                     else{

                         $data = collect(DB::select("SELECT tb_employee.id, tb_employee.emp_first_name, tb_employee.emp_lastName, tb_employee.emp_joining_date, tb_employee.employeeId,tb_designations.designation_name, tb_departments.department_name, tb_attendance.attendance_date, 'Present' as status  from 
                                `tb_attendance` inner join `tb_employee` on `tb_attendance`.`emp_id` = `tb_employee`.`id` inner join `tb_departments` on `tb_employee`.`emp_department_id` = `tb_departments`.`id` inner join `tb_designations` on `tb_employee`.`emp_designation_id` = `tb_designations`.`id` where tb_employee.id =" . $emp_id . " and attendance_date='$dates'"))->first();

                         if (isset($data)) {
                             $datas[] = $data;
                         } else {
                             $sql="SELECT tb_employee.id,tb_employee.emp_first_name, tb_employee.emp_lastName, tb_employee.emp_joining_date, tb_employee.emp_lastName, tb_employee.date_of_discontinuation,
                                tb_employee.employeeId, tb_designations.designation_name, tb_departments.department_name, '$dates' as attendance_date, 'Weekend' as status FROM tb_employee inner join `tb_departments` on `tb_employee`.`emp_department_id` = `tb_departments`.`id`
                                inner join `tb_designations` on `tb_employee`.`emp_designation_id` = `tb_designations`.`id` where tb_employee.id = $emp_id ";
                             $data = collect(DB::select($sql))->first();

                             $datas[] = $data;

                         }

                     }
                 }
                 else {
                     $sql="SELECT tb_employee.id,tb_employee.emp_first_name, tb_employee.emp_lastName, tb_employee.emp_joining_date, tb_employee.emp_lastName, tb_employee.date_of_discontinuation,
                                tb_employee.employeeId, tb_designations.designation_name, tb_departments.department_name, '$dates' as attendance_date, 'Festival Holiday' as status FROM tb_employee inner join `tb_departments` on `tb_employee`.`emp_department_id` = `tb_departments`.`id`
                                inner join `tb_designations` on `tb_employee`.`emp_designation_id` = `tb_designations`.`id` where tb_employee.id = $emp_id ";
                     $data = collect(DB::select($sql))->first();

                     $datas[] = $data;

                 }
             }
         }

//         return $datas;

//         $datas = collect($datas)->map(function ($item) {
//             return (object) $item;
//         });

         return response()->json([
             "data"=>$datas
         ]);
    }
    // ===================================== End  individual_attendance_report_data ============================================


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

                 return response()->json(['success' => 'Leave Application been successfully Approved.']);
        }
    // =====================================  tb_leave_application ============================================


    // =====================================  empSalaryList ============================================

     public function empSalaryList(Request $request)
    {
        if( $branch_id =$request->id=='All' && $dpid =$request->dpid=='All'){
        $emp_salary_list = DB::table('tb_payroll_salary')->orderBy('tb_payroll_salary.id', 'desc')
            ->leftJoin('tb_employee','tb_payroll_salary.emp_id','=','tb_employee.id')
            ->leftjoin('tb_departments','tb_employee.emp_department_id','=','tb_departments.id')
            ->leftjoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
            ->leftJoin('tb_salary_grade','tb_payroll_salary.grade_id','=','tb_salary_grade.id')
            // ->where('tb_payroll_salary.emp_id','=',$request->emp_id)
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


        if( $branch_id =$request->id=='All'){

              if( $designation =$request->dpid==null){
                $emp_salary_list = DB::table('tb_payroll_salary')->orderBy('tb_payroll_salary.id', 'desc')
                ->leftJoin('tb_employee','tb_payroll_salary.emp_id','=','tb_employee.id')
                ->leftjoin('tb_departments','tb_employee.emp_department_id','=','tb_departments.id')
                ->leftjoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
                ->leftJoin('tb_salary_grade','tb_payroll_salary.grade_id','=','tb_salary_grade.id')
                // ->where('tb_payroll_salary.emp_id','=',$request->emp_id)
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
            $branch_id =$request->id;
            $dpid =$request->dpid;
              $emp_salary_list = DB::table('tb_payroll_salary')->orderBy('tb_payroll_salary.id', 'desc')
            ->leftJoin('tb_employee','tb_payroll_salary.emp_id','=','tb_employee.id')
            ->leftjoin('tb_departments','tb_employee.emp_department_id','=','tb_departments.id')
            ->leftjoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
            ->leftJoin('tb_salary_grade','tb_payroll_salary.grade_id','=','tb_salary_grade.id')
            // ->where('tb_payroll_salary.emp_id','=',$request->emp_id)
            ->where('tb_employee.branch_id', $branch_id)
             ->where('tb_employee.emp_department_id', $dpid)
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


        if($dpid =$request->dpid=='All'){
             $branch_id =$request->id;

              $emp_salary_list = DB::table('tb_payroll_salary')->orderBy('tb_payroll_salary.id', 'desc')
            ->leftJoin('tb_employee','tb_payroll_salary.emp_id','=','tb_employee.id')
            ->leftjoin('tb_departments','tb_employee.emp_department_id','=','tb_departments.id')
            ->leftjoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
            ->leftJoin('tb_salary_grade','tb_payroll_salary.grade_id','=','tb_salary_grade.id')
            // ->where('tb_payroll_salary.emp_id','=',$request->emp_id)

            //  ->where('tb_employee.emp_department_id', $dpid)
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
            $branch_id =$request->id;

              $emp_salary_list = DB::table('tb_payroll_salary')->orderBy('tb_payroll_salary.id', 'desc')
            ->leftJoin('tb_employee','tb_payroll_salary.emp_id','=','tb_employee.id')
            ->leftjoin('tb_departments','tb_employee.emp_department_id','=','tb_departments.id')
            ->leftjoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
            ->leftJoin('tb_salary_grade','tb_payroll_salary.grade_id','=','tb_salary_grade.id')
            // ->where('tb_payroll_salary.emp_id','=',$request->emp_id)

            ->where('tb_employee.branch_id', $branch_id)
             ->where('tb_employee.emp_department_id', $dpid)
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


    // ===================================== getBranchgetEmployee ============================================
    public function getBranchgetEmployee($id){
       $employeeId=DB::table('tb_employee')->where('branch_id',$id)->select('tb_employee.id as emp_id','emp_first_name','emp_lastName','tb_employee.employeeId')->get();
       return response()->json([
             'employeeId' => $employeeId
            ], $this->successStatus);
     }

    // ===================================== End  getBranchgetEmployee ============================================


    // =====================================  employeeWiseExpanseHistoryMonthly ============================================
     public function employeeWiseExpanseHistoryMonthly(Request $request)
    {
        $a =$request->startdate;
        $b =$request->enddate;
        $from = date($a);
        $to = date($b);
        $branch_id = $request->branch_id;


        if($branch_id='All'){
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
        // ->where('tb_employee.branch_id','=',$branch_id)
        ->where('tb_expanse.status','=',1)
        // ->where('tb_employee.branch_id','=',$request->id)
        // ->groupBy(DB::raw("MONTH(tb_expanse.expanse_date)"),DB::raw("YEAR(tb_expanse.expanse_date)"))
        ->orderBy('tb_expanse.expanse_date', 'desc')
        ->get();

        return response()->json([
             'expanse_list' => $expanse_list
            ], $this->successStatus);
        }else{
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

    }
    // ===================================== End  employeeWiseExpanseHistoryMonthly ============================================


    // ===================================== employeeWiseExpanseHistoryMonthlyDetails ============================================

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


    // ===================================== getDepartmentEmployee ============================================
     public function getDepartmentEmployee($id){
       $employeeId=DB::table('tb_employee')->where('emp_department_id',$id)->select('tb_employee.id as emp_id','emp_first_name','emp_lastName','tb_employee.employeeId')->get();
       return response()->json([
             'employeeId' => $employeeId
            ], $this->successStatus);
     }
    // ===================================== End  getDepartmentEmployee ============================================


    // ===================================== getDepartmentEmployee ============================================
     public function getDesignationEmployee($id){
       $employeeId=DB::table('tb_employee')->where('emp_designation_id',$id)->select('tb_employee.id as emp_id','emp_first_name','emp_lastName','tb_employee.employeeId')->get();
       return response()->json([
             'employeeId' => $employeeId
            ], $this->successStatus);
     }
    // ===================================== End  getDepartmentEmployee ============================================



        public function daily_absent_report_data(Request $request){
            $request->date=Carbon::parse($request->date)->toDateString();
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

            if($request->branch_id!='All'){
                $queryAbsent=$queryAbsent->where('tb_employee.branch_id','=',$request->branch_id);
            }
            if($request->department_id!='All') {
                $queryAbsent = $queryAbsent->where('tb_employee.emp_department_id', '=', $request->department_id);
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
                    ->select('tb_employee.emp_first_name','tb_employee.emp_lastName', 'tb_employee.id',
                        'tb_employee.emp_photo',
                        'tb_employee.employeeId', 'tb_branch.branch_name', 'tb_departments.department_name','tb_designations.designation_name',
                        DB::raw("'Absent' as status"))
                    ->get();
            }
            else{
                $absent = $queryAbsent
                    ->select('tb_employee.emp_first_name','tb_employee.emp_lastName', 'tb_employee.id',
                        'tb_employee.emp_photo',
                        'tb_employee.employeeId', 'tb_branch.branch_name', 'tb_departments.department_name','tb_designations.designation_name',
                        DB::raw("'Absent' as status"))
                    ->get();

            }
            $path['link']= asset('employee_image/');

            return response()->json([
                'absent' => $absent,
                'filepath'=>$path
            ], $this->successStatus);

    }


    public function late_report_data(Request $request){
        $query=DB::table('tb_employee')
            ->leftJoin('tb_departments','tb_employee.emp_department_id','=','tb_departments.id')
            ->leftJoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
            ->leftJoin('tb_shift','tb_employee.emp_shift_id','=','tb_shift.id')
            ->leftJoin('tb_branch','tb_employee.branch_id','=','tb_branch.id')
            ->join('tb_attendance','tb_employee.id','=','tb_attendance.emp_id')
            ->where('tb_attendance.attendance_date',$request->date);
        if($request->branch_id!='All') {
            $query = $query->where('tb_employee.branch_id', '=', $request->branch_id);
        }
        if($request->department_id!='All') {

            $query = $query->where('tb_employee.emp_department_id', '=', $request->department_id);
        }

        $query=$query->where('emp_account_status','=',1);
        $query=$query->where('tb_attendance.in_time','>',DB::raw("tb_shift.entry_time"));

        $attendance_data=$query->select(
            'tb_employee.emp_first_name','tb_employee.emp_lastName', 'tb_employee.emp_photo',
            'tb_attendance.attendance_date','tb_attendance.in_time',
            'tb_shift.entry_time as shift_entry_time','tb_shift.exit_time as shift_exit_time',
            'tb_attendance.out_time','tb_employee.employeeId','tb_branch.branch_name',
            'tb_designations.designation_name',DB::raw("'Late' as status"))
            ->get();

        $path['link']= asset('employee_image/');


        return response()->json([
            'late' => $attendance_data,
            'filepath'=>$path
        ], $this->successStatus);

    }

    public function searchEmployee(Request $request){
        $q = $request->q;

        $employee = DB::table('tb_employee')->where('tb_employee.emp_first_name','LIKE','%'.$q.'%')->orWhere('tb_employee.employeeId','LIKE','%'.$q.'%')->orWhere('tb_employee.emp_lastName','LIKE','%'.$q.'%')->orWhere('tb_employee.emp_card_number','LIKE','%'.$q.'%')->orWhere('tb_employee.emp_email','LIKE','%'.$q.'%')->orWhere('tb_employee.emp_phone','LIKE','%'.$q.'%')
        ->Where('emp_marital_status', '=', 1)
        ->limit(20)
        ->get();

      return response()->json([
             'employee' => $employee,
            ], $this->successStatus);

    }


}
