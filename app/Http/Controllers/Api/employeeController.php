<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use \Datetime;
use Illuminate\Support\Facades\DB;
use Validator;
use Carbon\Carbon;
use App\Repositories\Settings;

class EmployeeController extends Controller
{
    protected $settings;

    public function __construct()
    {
        // create object of settings class
        $this->settings = new Settings();
    }

    public $successStatus = 200;



   // =====================================  employeeDashboard  ===========================================

     function weekend_count($start_date, $end_date){
        $start_date=Carbon::parse($start_date)->toDateString();
        $end_date=Carbon::parse($end_date)->toDateString();
        $wl=DB::table('tb_week_leave')->where('status','=',1)->get();
        $count=0;
        for ($i=$start_date; $i<$end_date;)
        {
            foreach ($wl as $w){
                if($w->day==Carbon::parse($i)->format('l'))
                {
                    $count++;
                }
            }
            $i=Carbon::parse($i)->addDay(1);

        }

        return $count;


    }

    public function dayCalculator($d1,$d2){
        //$request=DB::table('tb_leave_application')->where(['id'=>$id])->first();
        $date1=strtotime($d1);
        $date2=strtotime($d2);
        $interval1=1+round(abs($date1-$date2)/86400);
//        return $interval1;

        $festivalLeave = DB::table('tb_festival_leave')->get();
        $dcount=0;

        foreach($festivalLeave as $fleave){
            if(strtotime($fleave->start_date) >= $date1 && strtotime($fleave->end_date) <= $date2){
                $dcount+=1+round(abs(strtotime($fleave->start_date)-strtotime($fleave->end_date))/86400);

            }
            else if(strtotime($fleave->start_date) >= $date1 && strtotime($fleave->start_date) <= $date2 && strtotime($fleave->end_date) > $date2){
                $dcount+=1+round(abs(strtotime($fleave->start_date)-$date2)/86400);

            }
            else{
                continue;
            }
        }
        $weekends=DB::table('tb_week_leave')->where(['status'=>1])->pluck('day')->unique()->toArray();

        //dd($weekends);
        $start_date=date('Y-m-d', $date1);
        $end_date=date('Y-m-d', $date2);
        // dd($start_date,$end_date);
        $key=0;
        for ($i = Carbon::createFromFormat('Y-m-d', $start_date);$i->lte(Carbon::createFromFormat('Y-m-d', $end_date)); $i->addDay(1)) {

            $dates = $i->format('Y-m-d');
            $timestamp = strtotime($dates);
            $day = date('l', $timestamp);

            for($j=0;$j<count($weekends);$j++)
            {
                if($day==$weekends[$j]){
                    $key++;
                }
            }

        }
        //dd($start_date,$end_date,$key);
        $interval=(int)$interval1-((int)$dcount+$key);
        //dd($start_date,$end_date,$key,$interval);
        return $interval;
    }

        public function employeDashboard(){
            $start_date=Carbon::now('Asia/Dhaka')->subDay(30)->toDateString();
            $end_date=Carbon::now('Asia/Dhaka')->toDateString();
            $emp_id=auth()->user()->emp_id;
            $late_count=DB::table('tb_attendance')
                ->join('tb_employee','tb_attendance.emp_id','=','tb_employee.id')
                ->join('tb_shift','tb_employee.emp_shift_id','=','tb_shift.id')
                ->where('tb_employee.id','=',$emp_id)
                ->where('tb_attendance.in_time','>',DB::raw('tb_shift.entry_time'))
                ->whereBetween('tb_attendance.attendance_date',[$start_date,$end_date])
                ->count();
            $present_count=DB::table('tb_attendance')
                ->where('emp_id','=',$emp_id)
                ->whereBetween('tb_attendance.attendance_date',[$start_date,$end_date])
                ->count();

            $leave=DB::select("select SUM(actual_days) as aggregate from `tb_leave_application` where `emp_id` = $emp_id and `status` = 1 and (`leave_starting_date` between '$start_date' and '$end_date'  or `leave_ending_date` between '$start_date' and '$end_date') group by `emp_id`");
            if(isset($leave[0]->aggregate)){
                $l=$leave[0]->aggregate;

            }
            else{
                $l=0;
            }

            $working_days=$this->dayCalculator($start_date, $end_date);

            $absent_count=$working_days-$present_count-$l;
            $dashboard=[
                'present' => $present_count,
                'late' => $late_count,
                'absent' => $absent_count,
            ];


            return response()->json([
                'dashboard'=>
                    $dashboard


            ], $this->successStatus);
        }

   // =====================================  End employeDashboard  ===========================================


    public function allEmployee(){

        $employee_list = DB::table('tb_employee')
        ->leftjoin('tb_departments','tb_employee.emp_department_id','=','tb_departments.id')
        ->leftjoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
        ->leftjoin('tb_branch','tb_employee.branch_id','=','tb_branch.id')
        ->select('tb_employee.id','tb_employee.emp_first_name','tb_employee.emp_account_status','tb_employee.emp_card_number','tb_departments.department_name','tb_designations.designation_name','tb_employee.employeeId','tb_employee.emp_photo','tb_branch.branch_name')
        ->orderBy('tb_employee.id', 'desc')->get();

        $path = asset('employee_image/'.$employee_list->emp_photo);

         return response()->json(['employee' =>$employee_list],['filepath'=>$path], $this->successStatus);

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

        return response()->json(['task_list' =>  $task_list], $this->successStatus);

     }


       public function myProfile(){
        //   $id=auth()->id();
        //   $user=DB::table('users')
        //       ->leftJoin('tb_employee','users.emp_id','=','tb_employee.id')
        //       ->where('users.id','=',$id)
        //       ->select('users.*','tb_employee.employeeId')
        //       ->first();
        //  return response()->json(['user' =>  $user], $this->successStatus);



         $employee_list = DB::table('tb_employee')
        ->leftjoin('tb_departments','tb_employee.emp_department_id','=','tb_departments.id')
        ->leftjoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
         ->leftjoin('tb_shift','tb_employee.emp_shift_id','=','tb_shift.id')
        ->leftjoin('tb_branch','tb_employee.branch_id','=','tb_branch.id')
        // ->select('tb_employee.id','tb_employee.emp_first_name','tb_employee.emp_account_status','tb_employee.emp_card_number','tb_departments.department_name','tb_designations.designation_name','tb_employee.employeeId','tb_employee.emp_photo','tb_branch.branch_name')
        ->select('tb_employee.*','tb_departments.department_name','tb_designations.designation_name','tb_branch.branch_name','tb_shift.shift_name','tb_employee.emp_photo','tb_branch.branch_name')
        ->where('tb_employee.id','=',auth()->id())
        ->first();

        $path = asset('employee_image/'.$employee_list->emp_photo);

         return response()->json(['employee' =>$employee_list,'filepath'=>$path], $this->successStatus);
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

         return response()->json(['meeting' => $meeting], $this->successStatus);

     }



      //assign project list login employee wise

      public function assignMemberProject(){
        $assign_member=DB::table('tb_assign_project')->where('tb_assign_project.member_id',auth()->user()->emp_id)
        ->leftjoin('tb_project','tb_assign_project.project_id','=','tb_project.id')
        ->leftjoin('tb_employee','tb_project.team_leader','=','tb_employee.id')
        ->leftjoin('users','tb_assign_project.assign_by','=','users.id')
        ->select('tb_project.*','tb_employee.emp_first_name','tb_employee.emp_lastName','tb_employee.employeeId','users.name as assigned_by','tb_project.status as project_status',DB::raw('abs(DATEDIFF(tb_project.start_date,tb_project.end_date)) as days'))
        ->groupBy('tb_assign_project.project_id')
        ->get();

         $path['link']= asset('employee_image/');

         return response()->json([
             'assign_member' => $assign_member,
             'filepath' => $path,
        ], $this->successStatus);
      }


      public function announcementList(){

            $first_day_this_month = date('m-01-Y'); // hard-coded '01' for first day
            $last_day_this_month  = date('m-t-Y');

            $all_branch=$this->settings->all_branch();
            $branch_emp_id=$this->settings->branchname_loginemployee();
            $branch_list2=$this->settings->branchname_loginemployee();
            $announcement_list=DB::table('tb_announcement')
            ->leftJoin('tb_branch','tb_announcement.branch_id','=','tb_branch.id')
            ->select('tb_announcement.*','tb_branch.branch_name')
            ->where('tb_announcement.branch_id', $branch_emp_id->id)
            ->orWhere('tb_announcement.branch_id', 0)
            ->whereBetween('tb_announcement.start_date', [$first_day_this_month, $last_day_this_month])

             ///this month date
             ->orWhere(function ($query) use ($first_day_this_month, $last_day_this_month) {
                    $query->where('tb_announcement.start_date', '<=', $first_day_this_month);
                    $query->where('tb_announcement.end_date', '>=', $last_day_this_month);
                })
            ->get();

             return response()->json(['announcement_list' => $announcement_list], $this->successStatus);
      }


      // =====================================  empSalaryList ============================================

     public function loginEmpSalaryList()
    {
        $emp_salary_list = DB::table('tb_payroll_salary')->orderBy('tb_payroll_salary.id', 'desc')
            ->leftJoin('tb_employee','tb_payroll_salary.emp_id','=','tb_employee.id')
            ->leftJoin('tb_salary_grade','tb_payroll_salary.grade_id','=','tb_salary_grade.id')
            ->where('tb_payroll_salary.emp_id','=',auth()->user()->emp_id)
            ->select('tb_payroll_salary.id','tb_employee.employeeId',
                DB::raw("CONCAT(tb_employee.emp_first_name,' ',tb_employee.emp_lastName) as emp_name"),
                'tb_salary_grade.grade_name','tb_payroll_salary.*'
            )
            // ->select('tb_payroll_salary.id','tb_employee.employeeId',
            //     DB::raw("CONCAT(tb_employee.emp_first_name,' ',tb_employee.emp_lastName) as emp_name"),
            //     'tb_salary_grade.grade_name','tb_payroll_salary.basic_salary','tb_payroll_salary.total_salary',
            //     'tb_payroll_salary.provident_fund_percent','tb_payroll_salary.provident_fund_amount','tb_payroll_salary.house_rant','tb_payroll_salary.medical','tb_payroll_salary.transport','tb_payroll_salary.food'
            // )
            ->first();


            return response()->json([
             'emp_salary_list' => $emp_salary_list,
            ], $this->successStatus);
    }

    // ===================================== End  empSalaryList ============================================



     // ===================================== employee_statusPending ============================================
    public function employeeLeaveStatusPending(){

        $leave_application = DB::table('tb_leave_application')
        ->leftJoin('tb_employee','tb_leave_application.emp_id','=','tb_employee.id')
        ->leftJoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
        ->leftJoin('tb_leave_type','tb_leave_application.leave_type_id','=','tb_leave_type.id')
        ->leftJoin('users','tb_leave_application.approved_by','=','users.id')
         ->where('tb_leave_application.emp_id','=',auth()->user()->emp_id)
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

    }

    // ===================================== End employee_statusPending ============================================

         // ===================================== employee_statusPending ============================================
    public function employeLeaveStatusApproved(){

        $leave_application = DB::table('tb_leave_application')
        ->leftJoin('tb_employee','tb_leave_application.emp_id','=','tb_employee.id')
        ->leftJoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
        ->leftJoin('tb_leave_type','tb_leave_application.leave_type_id','=','tb_leave_type.id')
        ->leftJoin('users','tb_leave_application.approved_by','=','users.id')
         ->where('tb_leave_application.emp_id','=',auth()->user()->emp_id)
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

    }

    // ===================================== End employee_statusPending ============================================



             // ===================================== employee_statusPending ============================================
    public function employeLeaveStatusRejected(){

        $leave_application = DB::table('tb_leave_application')
        ->leftJoin('tb_employee','tb_leave_application.emp_id','=','tb_employee.id')
        ->leftJoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
        ->leftJoin('tb_leave_type','tb_leave_application.leave_type_id','=','tb_leave_type.id')
        ->leftJoin('users','tb_leave_application.approved_by','=','users.id')
         ->where('tb_leave_application.emp_id','=',auth()->user()->emp_id)
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

    }

    // ===================================== End employee_statusPending ============================================



    // ===================================== employeeWiseExpanseHistoryMonthlyDetails ============================================

     public function employeeWiseExpanseHistoryDetails(Request $request)
    {
        $a =$request->startdate;
        $b =$request->enddate;
        $from = date($a);
        $to = date($b);

        //   $year_month=Carbon::parse($request->salary_month)->toDateString();
         $dateexpanse_list = DB::table('tb_expanse')
        ->leftJoin('users','tb_expanse.created_by','=','users.id')
        ->leftJoin('tb_employee','tb_employee.id','=','users.emp_id')
        ->leftjoin('tb_departments','tb_employee.emp_department_id','=','tb_departments.id')
        ->leftjoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
        ->leftjoin('tb_branch','tb_employee.branch_id','=','tb_branch.id')
        ->leftJoin('tb_expanse_category','tb_expanse.category_id','=','tb_expanse_category.id')
        ->whereBetween('tb_expanse.expanse_date', [$from, $to])
        ->where('tb_expanse.created_by','=',auth()->user()->emp_id)
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






        // =====================================  ExpanseAdd  ============================================
    public function expanse_add(Request $request)
    {




            $attachment = $request->attachment ?:null;
            // $new_file = 'expanse_attachment' . '-' . time() . '.' . $attachment->getClientOriginalExtension();
            // $attachment->move(('expanse_attachment'), $new_file);

                $expanse_create = DB::table('tb_expanse')->insert([
                    'category_id'=>$request->category_id,
                    'expanse_date'=>$request->expanse_date,
                    'amount'=>$request->amount,
                    'remarks'=>$request->remarks,
                    'status'=>0,
                    'attachment'=>$attachment,
                    'created_by'=>Auth::user()->id,
                    // 'approved_by'=>$approved_by,
                    'created_at'=>Carbon::now()->toDateTimeString(),
                    'updated_at'=>Carbon::now()->toDateTimeString()
                ]);

             return response()->json(['success' => 'Expanse has been successfully added.']);

    }
    // ===================================== End ExpanseAdd  ============================================


    // ===================================== get_leave_type  ============================================
      public function get_leave_type()
        {
            $emp = DB::table('tb_employee')->find(Auth::user()->id);
            if ($emp->emp_gender_id == 2) {
                $leave_type = $this->settings->all_leave_type();
                return response()->json([
             'leave_type' => $leave_type
            ], $this->successStatus);
            }else {
                $leave_type = DB::table('tb_leave_type')->where('status',1)->whereNotIn('id', [1])->get();
                return response()->json([
             'leave_type' => $leave_type
            ], $this->successStatus);
            }
        }

    // ===================================== End get_leave_type  ============================================


    // ===================================== leave_application  ============================================

        public function  leave_application(Request $request){



            $earlier = new DateTime($request->starting_date);
            $later = new DateTime($request->ending_date);

            $diff = $later->diff($earlier)->format("%a");
            $total = $diff +1;
            $unique_id = mt_rand(1000000000, 9999999999);
            $leave_application =  DB::table('tb_leave_application')->insert([
                        'unique_id'=> $unique_id,
                        'emp_id'=>Auth::user()->id,
                        'leave_type_id'=>$request->leave_type_id,
                        'leave_starting_date'=>$request->starting_date,
                        'leave_ending_date'=>$request->ending_date,
                        'actual_days'=>$total,
                        // 'approved_by'=>Auth::user()->id,
                        'attachment'=>$request->attachment,
                        'description'=>$request->description,
                        'status'=>0,
                        'created_at'=>Carbon::now()->toDateTimeString(),
                        'updated_at'=>Carbon::now()->toDateTimeString()
                        ]);



             return response()->json(['success' => 'Leave Application has been successfully added.']);

        }

    // ===================================== End leave_application  ============================================


       // =====================================  expansecategory  ===========================================
    public function expansecategory_list(Request $request)
    {




        $expansecategory_list = DB::table('tb_expanse_category')->orderBy('id', 'desc')
        ->select('tb_expanse_category.id','tb_expanse_category.category_name','tb_expanse_category.description','tb_expanse_category.status')
        ->get();


         return response()->json([
             'expansecategory_list' => $expansecategory_list
            ], $this->successStatus);
    }
    // ===================================== End expansecategory  ============================================



       // =====================================  individual_attendance  ===========================================


    public function individual_attendance(Request $request){
        $start = $request->start_date;
        $end = $request->end_date;
        $emp_id=auth()->user()->emp_id;

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
        return response()->json([
            "data"=>$datas
        ],$this->successStatus);
    }

    public function late_report_data(Request $request){
         $start_date=Carbon::parse($request->start_date)->toDateString();
         $end_date=Carbon::parse($request->end_date)->toDateString();
         $emp_id=auth()->user()->emp_id;

        $query=DB::table('tb_employee')
            ->leftJoin('tb_departments','tb_employee.emp_department_id','=','tb_departments.id')
            ->leftJoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
            ->leftJoin('tb_shift','tb_employee.emp_shift_id','=','tb_shift.id')
            ->leftJoin('tb_branch','tb_employee.branch_id','=','tb_branch.id')
            ->join('tb_attendance','tb_employee.id','=','tb_attendance.emp_id')
            ->where('emp_account_status','=',1)
            ->where('tb_attendance.in_time','>',DB::raw("tb_shift.entry_time"))
            ->where('tb_attendance.emp_id','=',$emp_id)
            ->whereBetween('tb_attendance.attendance_date',[$start_date,$end_date]);

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

    public function absent_report_data(Request $request){
        $start = $request->start_date;
        $end = $request->end_date;
        $emp_id=auth()->user()->emp_id;

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
//                                $datas[] = $data;


                            }
                            else {
                                $sql = "SELECT tb_employee.id,tb_employee.emp_first_name, tb_employee.emp_lastName, tb_employee.emp_joining_date, tb_employee.emp_lastName, tb_employee.date_of_discontinuation,
                                tb_employee.employeeId, tb_designations.designation_name, tb_departments.department_name, '$dates' as attendance_date, 'Absent' as status FROM tb_employee inner join `tb_departments` on `tb_employee`.`emp_department_id` = `tb_departments`.`id`
                                inner join `tb_designations` on `tb_employee`.`emp_designation_id` = `tb_designations`.`id` where tb_employee.id = $emp_id ";
                                $data = collect(DB::select($sql))->first();

                                $datas[] = $data;

                            }
                        }
                    }
                }

            }
        }
        return response()->json([
            "absent"=>$datas
        ],$this->successStatus);


    }




}
