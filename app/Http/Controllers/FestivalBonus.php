<?php

namespace App\Http\Controllers; 

use DB;
use Auth;
use Carbon\Carbon;
use Validator;
use App\Repositories\Settings;
use Redirect;
use Session;

use Illuminate\Http\Request;

class FestivalBonus extends Controller
{   

    protected $branche;
    public function __construct()
    {
        // create object of settings class
        $this->branche = new Settings();
    }

    public function festival_bonussinglepage()
    {   
        $this->checkuserRole(['admin','super-admin','branch-manager'],'');
        return view('backend.festival_bonus.festival_bonus_single');
    } 

      public function performance_bonus(){
          if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin')){
             $branch_list2=$this->branche->branchname_loginemployee();
            $branch_list=$this->branche->all_branch();
            return view('backend.festival_bonus.performance_bonus',compact('branch_list','branch_list2'));
          }else{
             $branch_list2=$this->branche->branchname_loginemployee();
            $branch_list=$this->branche->all_branch();
            return view('backend.festival_bonus.performance_bonus',compact('branch_list','branch_list2'));
          }
       
    }

    /*
     Festival Bonus Page
    */
    public function festival_bonus(){

        if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin')){ 
             $branch_list2=$this->branche->branchname_loginemployee();
            $branch_list=$this->branche->all_branch();
            return view('backend.festival_bonus.festival_bonus',compact('branch_list','branch_list2'));
        }else{
             $branch_list2=$this->branche->branchname_loginemployee();
            $branch_list=$this->branche->all_branch();
            return view('backend.festival_bonus.festival_bonus',compact('branch_list','branch_list2'));
        }
        
    }

    /*
     Branch wise designation ajax
   */
    public function branchDesignation($id){
      $designation=DB::table('tb_employee')->where('tb_employee.branch_id',$id)
      ->leftjoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
      ->select('tb_designations.designation_name','tb_designations.id as designation_id')
      ->groupBy('tb_employee.emp_designation_id')
      ->get();
      return response()->json($designation);
    }

    /*
      Designation wise employee ajax
    */
    public function designationEmployee($id){
        $designation=DB::table('tb_employee')->where('tb_employee.emp_designation_id',$id)
            ->leftjoin('tb_payroll_salary','tb_employee.id','=','tb_payroll_salary.emp_id')
            ->select('tb_employee.id as emp_id','tb_employee.emp_first_name','tb_employee.emp_lastName','tb_employee.employeeId','tb_payroll_salary.basic_salary')
            ->get();
        return response()->json($designation);
    }

    /*
     Save festival bonus
   */
    public function save_festival_bonus(Request $request){
        $month=date('Y-m-01',strtotime($request->month));
        $check=DB::table('tb_festival_bonus')->whereIn('emp_id',$request->emp_id)->where('date',$month)->where('bonus_type',2)->count();
        if($check>0){
            $check=DB::table('tb_festival_bonus')->whereIn('emp_id',$request->emp_id)->where('date',$month)->delete();
            for($i=0;$i<count($request->emp_id);$i++){
                $percent=$request->basic[$i]/100*$request->percent[$i];

                $insert=DB::table('tb_festival_bonus')->insert([
                    'bonus_title' =>$request->bonus_title,
                    'emp_id' =>$request->emp_id[$i],
                    'bonus_type' =>$request->bonus_type, 
                    'amount' =>$request->amount[$i],
                    'percent' =>$request->percent[$i],
                    'festival_bonus' =>$request->amount[$i]+$percent,
                    'date' => $month,
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ]);
            }
        }else{
            for($i=0;$i<count($request->emp_id);$i++){
                $percent=$request->basic[$i]/100*$request->percent[$i];
                $insert=DB::table('tb_festival_bonus')->insert([
                    'bonus_title' =>$request->bonus_title,
                    'emp_id' =>$request->emp_id[$i],
                    // 'bonus_type' =>2,
                    'bonus_type' =>$request->bonus_type, 
                    'amount' =>$request->amount[$i],
                    'percent' =>$request->percent[$i],
                    'festival_bonus' =>$request->amount[$i]+$percent ,
                    'date' => $month,
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ]);
            }
        }
        Session::flash('success','Bonus has been  Successfully added');
        return redirect()->back();
    }


}
