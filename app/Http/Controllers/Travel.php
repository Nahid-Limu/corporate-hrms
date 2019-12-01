<?php

namespace App\Http\Controllers; 

use DB;
use Auth;
use Carbon\Carbon;
use Validator;
use App\Repositories\Settings;

use Illuminate\Http\Request;

class Travel extends Controller
{
        protected $branche;
    public function __construct()
    {
        // create object of settings class
        $this->branche = new Settings();
    }

    public function festival_bonussinglepage()
    {
        return view('backend.festival_bonus.festival_bonus_single');
    } 

      public function performance_bonus(){
        $branch_list=$this->branche->all_branch();
        $designation_list=$this->branche->all_designation();
        $files=DB::table('tb_attendance_file')->orderBy('upload_date','desc')
            ->take(5)
            ->get();
        return view('backend.festival_bonus.create',compact('files','branch_list','designation_list'));
    }

    /*
     Festival Bonus Page
    */
    public function travel_create(){
        $branch_list=$this->branche->all_branch();
        
        return view('backend.travel.create',compact('branch_list','test'));

       
    }

    /*
     Branch wise designation ajax
   */
    public function branchDepartment($id){
      $designation=DB::table('tb_employee')->where('tb_employee.branch_id',$id)
      ->leftjoin('tb_departments','tb_employee.emp_department_id','=','tb_departments.id')
      ->select('tb_departments.department_name','tb_departments.id as departments_id')
      ->get();
      return response()->json($designation);
    }

    /*
      Designation wise employee ajax
    */
    public function designationEmployee($id){
        $designation=DB::table('tb_employee')->where('tb_employee.emp_designation_id',$id)
            ->leftjoin('tb_payroll_salary','tb_employee.id','=','tb_payroll_salary.emp_id')
            ->select('tb_employee.emp_first_name','tb_employee.emp_lastName','tb_employee.employeeId','tb_payroll_salary.basic_salary')
            ->get();
        return response()->json($designation);
    }

    /*
     Save festival bonus
   */
    public function save_festival_bonus(Request $request){
        return $request->all();
    }


     public function test(){
        
    }
}
