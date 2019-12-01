<?php namespace App\Repositories;
use Carbon\Carbon;
use auth;
use Illuminate\Support\Facades\DB;

class Settings
{
    //all employee
    public function all_employee(){
        return DB::table('tb_employee')
        ->select(DB::raw("tb_employee.id,tb_employee.employeeId,CONCAT(tb_employee.emp_first_name,' ',tb_employee.emp_lastName) as name"))
        ->where('emp_account_status','=',1)
        ->get(['id','full_name']);
    }

    // login user branch name

    //  public function branchname_loginemployee(){

    //   return DB::table('tb_employee')
    //     ->join('tb_branch','tb_employee.branch_id','=','tb_branch.id')
    //     ->join('users','tb_employee.id','=','users.emp_id')
    //     ->where('users.emp_id',auth()->user()->emp_id)
    //     ->select('tb_branch.id','tb_branch.branch_name')->first();

        
    // }
     public function branchname_loginemployee(){

      return DB::table('tb_employee')
        ->join('tb_branch','tb_employee.branch_id','=','tb_branch.id')
        ->where('tb_employee.id',auth()->user()->emp_id)
        ->select('tb_branch.id','tb_branch.branch_name')->first();

        
    }

  

    //branch all employee
    public function branchall_employee(){

       $branch_id=  DB::table('tb_employee')
        ->join('tb_branch','tb_employee.branch_id','=','tb_branch.id')
        ->join('users','tb_employee.id','=','users.emp_id')
        ->where('users.emp_id',auth()->user()->emp_id)
        ->select('tb_branch.id','tb_branch.branch_name')->first();

        return DB::table('tb_employee')
        ->select(DB::raw("tb_employee.id,tb_employee.employeeId,CONCAT(tb_employee.emp_first_name,' ',tb_employee.emp_lastName) as name"))
        ->where('emp_account_status','=',1)
        ->where('branch_id','=', $branch_id->id)
        ->get(['id','full_name']);
    }

    // all branch data
    public function all_branch()
    {
        return DB::table('tb_branch')->where('status',1)->select('id','branch_name')->get();
    }


  


    public function get_login_branch_id()
    {
        $branch_id = DB::table('users')
            ->join('tb_employee', 'users.emp_id', '=', 'tb_employee.id')
            ->where('users.id', auth()->user()->id)
            ->first()->branch_id;
        return $branch_id;

    }



    // all branch data
    public function emp_branch_name()
    {   
         $branch_id=  DB::table('tb_employee')
        ->join('tb_branch','tb_employee.branch_id','=','tb_branch.id')
        ->join('users','tb_employee.id','=','users.emp_id')
        ->where('users.emp_id',auth()->user()->emp_id)
        ->select('tb_branch.id','tb_branch.branch_name')->first();

        return DB::table('tb_branch')->where('status',1)->where('id', $branch_id->id)->select('id','branch_name')->get();
    }

    //Login employee branch
    public function employeeBranch(){
        return DB::table('tb_employee')
        ->join('tb_branch','tb_employee.branch_id','=','tb_branch.id')
        ->join('users','tb_employee.id','=','users.emp_id')
        ->where('users.emp_id',auth()->user()->emp_id)
        ->select('tb_branch.id','tb_branch.branch_name')->get();

    }

      //Login employee department
      public function employeeDepartment(){
        return DB::table('tb_employee')
        ->join('tb_departments','tb_employee.emp_department_id','=','tb_departments.id')
        ->join('users','tb_employee.id','=','users.emp_id')
        ->where('users.emp_id',auth()->user()->emp_id)
        ->select('tb_departments.id','tb_departments.department_name')->get();

    }

    public function employeeDepartmentBranch(){


         $branch_id=  DB::table('tb_employee')
        ->join('tb_branch','tb_employee.branch_id','=','tb_branch.id')
        ->join('users','tb_employee.id','=','users.emp_id')
        ->where('users.emp_id',auth()->user()->emp_id)
        ->select('tb_branch.id','tb_branch.branch_name')->first();

        return DB::table('tb_employee')
        ->join('tb_departments','tb_employee.emp_department_id','=','tb_departments.id')
        ->join('users','tb_employee.id','=','users.emp_id')
        ->where('tb_employee.branch_id', $branch_id->id)
        ->select('tb_departments.id','tb_departments.department_name')->get();

    }

      //Login employee designation
      public function employeeDesignation(){
        return DB::table('tb_employee')
        ->join('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
        ->join('users','tb_employee.id','=','users.emp_id')
        ->where('users.emp_id',auth()->user()->emp_id)
        ->select('tb_designations.id','tb_designations.designation_name')->get();
    }

       //Login employee shift
       public function employeeShift(){
        return DB::table('tb_employee')
        ->join('tb_shift','tb_employee.emp_shift_id','=','tb_shift.id')
        ->join('users','tb_employee.id','=','users.emp_id')
        ->where('users.emp_id',auth()->user()->emp_id)
        ->select('tb_shift.id','tb_shift.shift_name')->get();
    }



    //all department
    public function all_department(){
        return DB::table('tb_departments')->where('status',1)->orderBy('id','DESC')->get();
    }

    //all department
    public function all_departmentasc(){
        return DB::table('tb_departments')->where('status',1)->orderBy('id','ASC')->get();
    }

    //all designation
    public function all_designation(){
        return DB::table('tb_designations')->where('status',1)->orderBy('id','DESC')->get();
    }

    //all shift
    public function all_shift(){
        return DB::table('tb_shift')->orderBy('id','DESC')->get();
    }

    //all task
    public function all_task(){
        return DB::table('tb_task')->where('status','=',1)->get(['id','title']);
    }

    //all leave type
    public function all_leave_type(){
        return DB::table('tb_leave_type')->where('status',1)->get(['id','leave_type']);
    }
    //all grade
    public function all_grade(){
        return DB::table('tb_salary_grade')->where('status','=',1)->get(['id','grade_name']);
    }

    //all active client
    public function all_client(){
        return DB::table('tb_clients')
            ->where('tb_clients.status','=',1)
            ->get(['id','client_name']);
    }

    //all active project
    public function active_project(){
        return DB::table('tb_project')->get(['id','project_name']);
    }


    //working day find function
    public function dayCalculator($d1,$d2){
        $date1=strtotime($d1);
        $date2=strtotime($d2);
        $interval1=1+round(abs($date1-$date2)/86400);
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
        $start_date=date('Y-m-d', $date1);
        $end_date=date('Y-m-d', $date2);
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
        $interval=(int)$interval1-((int)$dcount+$key);
        return $interval;
    }



     //weekend find function
     function weekdayCalculator($d1,$d2){
        $date1=strtotime($d1);
        $date2=strtotime($d2);
        $interval1=1+round(abs($date1-$date2)/86400);
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
        $start_date=date('Y-m-d', $date1);
        $end_date=date('Y-m-d', $date2);
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
        $interval=(int)$interval1-((int)$dcount+$key);
        return $key;
    }

    //all active training
    public function all_training(){
        return DB::table('tb_training')
            ->get(['id','training_name']);
    }

    //company information
    public function companyInformation(){
        return DB::table('tb_company_information')->first();
    }



    
    //festival_leave 

        function festivalLeaveCalculator($d1,$d2){
        $date1=strtotime($d1);
        $date2=strtotime($d2);
        $interval1=1+round(abs($date1-$date2)/86400);
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

            return $dcount;
        
       
    }
}
    


}
